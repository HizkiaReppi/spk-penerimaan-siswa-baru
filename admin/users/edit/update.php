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

	$id = htmlspecialchars($_POST['id']);
	$fullname = htmlspecialchars($_POST['fullname']);
	$role = htmlspecialchars($_POST['role']);
	$username = htmlspecialchars($_POST['username']);
	$passwordOld = htmlspecialchars($_POST['old-password']);
	$password = htmlspecialchars($_POST['password']);
	$passwordConfirmation = htmlspecialchars($_POST['password-confirmation']);
	$photo = isset($_POST['photo_profile']) ? htmlspecialchars($_POST['photo_profile']) : null;

	// Ambil data pengguna sebelumnya dari database
	$query = "SELECT * FROM admin WHERE id = ?";
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$oldData = mysqli_fetch_assoc($result);
	mysqli_stmt_close($stmt);

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
	} elseif ($username != $oldData['username']) {
		if (!isDataAvailable($mysqli, 'admin', 'username', $username)) {
			$errors['username'] = "Username sudah terdaftar, silakan pilih username lain";
		}
	}

	if (!empty($passwordOld) && !password_verify($passwordOld, $oldData['password'])) {
		$errors['old-password'] = "Password lama tidak cocok";
	} else if (!empty($password) && strlen($password) < 8) {
		$errors['password'] = "Password harus memiliki panjang minimal 8 karakter";
	} elseif (!empty($password) && $password != $passwordConfirmation) {
		$errors['password'] = "Password Baru dan konfirmasi password tidak cocok";
	}

	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['oldValues'] = array(
			'id' => $id,
			'fullname' => $fullname,
			'role' => $role,
			'username' => $username,
			'photo_profile' => $photo,
		);

		header("Location: " . BASE_URL_ADMIN . "/users/" . $username . "/edit");
		exit;
	}

	// Gunakan data sebelumnya jika user tidak mengisi data baru
	$fullname = empty($fullname) ? $oldData['fullname'] : $fullname;
	$role = empty($role) ? $oldData['role'] : $role;
	$username = empty($username) ? $oldData['username'] : $username;

	// Hash password baru jika diisi, jika tidak gunakan password lama
	$hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $oldData['password'];

	$query = "UPDATE admin SET fullname = ?, role = ?, username = ?, password = ?, photo = ? WHERE id = ?";
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, "sssssi", $fullname, $role, $username, $hashed_password, $photo, $id);
	$result = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if ($result) {
		$_SESSION['flash_message'] = 'Data Pengguna Berhasil Diubah!';
		header("Location: " . BASE_URL_ADMIN . "/users");
	} else {
		$_SESSION['flash_message'] = 'Data Pengguna Gagal Diubah!';
		header("Location: " . BASE_URL_ADMIN . "/users/" . $username . "/edit");
	}
}
