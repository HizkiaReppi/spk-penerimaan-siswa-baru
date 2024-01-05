<?php
session_start();
include "../../../lib/koneksi.php";
include "../../../lib/functions.php";

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href=../login><b>LOGIN</b></a></center>";
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

	$fullname = htmlspecialchars($_POST['fullname']);
	$role = htmlspecialchars($_POST['role']);
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$passwordConfirmation = htmlspecialchars($_POST['password-confirmation']);
	$photo = isset($_POST['photo_profile']) ? htmlspecialchars($_POST['photo_profile']) : null;

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

	$mysqli->begin_transaction();
	try {
		$stmt = $mysqli->prepare("INSERT INTO admin (fullname, role, username, password, photo) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $fullname, $role, $username, $hashed_password, $photo);
		$stmt->execute();

		$mysqli->commit();

		$_SESSION['flash_message'] = 'Data Pengguna Berhasil Disimpan!';
		header("Location: " . BASE_URL_ADMIN . "/users");
	} catch (\Exception $error) {
		$_SESSION['flash_message'] = 'Data Pengguna Gagal Disimpan!';
		echo "<script>console.log('". $error->getMessage() ."')</script>";

		$mysqli->rollback();
		header("Location: " . BASE_URL_ADMIN . "/users/insert/");
	} finally {
		$stmt->close();
		$mysqli->close();
	}
}
