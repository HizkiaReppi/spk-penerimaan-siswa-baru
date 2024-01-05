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

	$nama_jurusan = htmlspecialchars($_POST['major-name']);
	$kuota = (int)$_POST['quota'];
	$slug = createSlug($nama_jurusan);

	$errors = array();

	if (empty($nama_jurusan)) {
		$errors['major-name'] = "Nama jurusan harus diisi";
	} else if (strlen($nama_jurusan) <= 2 || strlen($nama_jurusan) >= 50) {
		$errors['major-name'] = "Nama jurusan harus memiliki panjang 2 hingga 50 karakter";
	} else if (!isDataAvailable($mysqli, 'jurusan', 'name', $nama_jurusan)) {
		$errors['major-name'] = "Nama jurusan sudah terdaftar, silakan pilih nama jurusan lain";
	} else if (!ctype_alpha(str_replace(' ', '', $nama_jurusan))) {
		$errors['major-name'] = "Nama jurusan hanya boleh berisi huruf";
	}

	if ($kuota <= 1) {
		$errors['quota'] = "Kuota harus lebih besar dari 1";
	} else if ($kuota > 999) {
		$errors['quota'] = "Kuota tidak boleh lebih dari 999";
	} else if (!is_numeric($kuota)) {
		$errors['quota'] = "Kuota harus berupa angka";
	}

	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;

		$_SESSION['old_input'] = array(
			'major-name' => $nama_jurusan,
			'quota' => $kuota,
		);

		header("Location: " . BASE_URL_ADMIN . "/majors/insert/");
		exit;
	}

	$query = "INSERT INTO jurusan (name, quota, slug) VALUES (?, ?, ?)";
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, "sis", $nama_jurusan, $kuota, $slug);
	$result = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if ($result) {
		$_SESSION['flash_message'] = 'Data Jurusan Berhasil Disimpan!';
		header("Location: " . BASE_URL_ADMIN . "/majors");
	} else {
		$_SESSION['flash_message'] = 'Data Jurusan Gagal Disimpan!';
		header("Location: " . BASE_URL_ADMIN . "/majors/insert/");
	}
}
