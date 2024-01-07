<?php
session_start();
include "../../../lib/koneksi.php";
include "../../../lib/functions.php";

if (empty($_SESSION['admin'])) {
	$_SESSION['flash_message'] = 'Untuk mengakses modul, Anda harus Login';
	header("Location: " . BASE_URL_ADMIN . "/login");
	exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (!isset($_POST['csrf_token'])) {
		header("HTTP/1.1 403 Forbidden");
		echo "403 Forbidden";
		exit;
	}
	// Validasi CSRF token
	$csrf_token = $_POST['csrf_token'];
	if (!validateCSRFToken($csrf_token)) {
		header("HTTP/1.1 403 Forbidden");
		echo "403 Forbidden";
		exit;
	}

	$fullname = htmlspecialchars(trim($_POST['fullname']));
	$role = htmlspecialchars(trim($_POST['role']));
	$username = htmlspecialchars(trim($_POST['username']));
	$password = htmlspecialchars(trim($_POST['password']));
	$passwordConfirmation = htmlspecialchars(trim($_POST['password-confirmation']));
	$photo = isset($_POST['photo_profile']) ? htmlspecialchars(trim($_POST['photo_profile'])) : null;

	$errors = array();

	if (empty($fullname)) {
		$errors['fullname'] = "Nama lengkap harus diisi";
	} else if (strlen($fullname) < 4 || strlen($fullname) > 50) {
		$errors['fullname'] = "Nama lengkap harus memiliki panjang 4 hingga 50 karakter";
	} else if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
		$errors['fullname'] = "Nama lengkap hanya boleh berisi karakter alfabet";
	}

	if (empty($role)) {
		$errors['role'] = "Role harus diisi";
	} else if (!in_array($role, array('admin', 'member'))) {
		$errors['role'] = "Role tidak valid";
	}

	if (empty($username)) {
		$errors['username'] = "Username harus diisi";
	} elseif (strlen($username) < 4 || strlen($username) > 20) {
		$errors['username'] = "Username harus memiliki panjang 4 hingga 20 karakter";
	} elseif (!ctype_alnum($username)) {
		$errors['username'] = "Username hanya boleh berisi karakter ASCII";
	} elseif (!isDataAvailable($mysqli, 'admin', 'username', $username)) {
		$errors['username'] = "Username sudah terdaftar, silakan pilih username lain";
	}

	if (!empty($password) && strlen($password) < 8) {
		$errors['password'] = "Password harus memiliki panjang minimal 8 karakter";
	} elseif (!empty($password) && $password != $passwordConfirmation) {
		$errors['password'] = "Password Baru dan konfirmasi password tidak cocok";
	}

	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;

		$_SESSION['old_input'] = array(
			'fullname' => $fullname,
			'role' => $role,
			'username' => $username,
			'photo_profile' => $photo,
		);

		header("Location: " . BASE_URL_ADMIN . "/users/insert/");
		exit;
	}

	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	$id = generateUuid();

	try {
		$mysqli->begin_transaction();
		$stmt = $mysqli->prepare("INSERT INTO admin (id, fullname, role, username, password, photo) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $id, $fullname, $role, $username, $hashed_password, $photo);
		$stmt->execute();

		$mysqli->commit();

		$_SESSION['flash_message'] = 'Data Pengguna Berhasil Disimpan!';
		header("Location: " . BASE_URL_ADMIN . "/users");
	} catch (\Exception $error) {
		$_SESSION['flash_message'] = 'Data Pengguna Gagal Disimpan!';
		echo "<script>console.log('" . $error->getMessage() . "')</script>";

		$mysqli->rollback();
		header("Location: " . BASE_URL_ADMIN . "/users/insert/");
	} finally {
		$stmt->close();
		$mysqli->close();
	}
}
