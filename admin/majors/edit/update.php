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
	$kuota = (int)htmlspecialchars($_POST['quota']);
	$slug = htmlspecialchars($_POST['slug']);

	// Ambil data jurusan sebelumnya dari database
	$query = "SELECT id, name, quota FROM jurusan WHERE slug = ?";
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, "s", $slug);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$oldData = mysqli_fetch_assoc($result);
	mysqli_stmt_close($stmt);

	$errors = array();

	if (empty($nama_jurusan)) {
		$errors['nama_jurusan'] = "Nama jurusan harus diisi";
	} else if (strlen($nama_jurusan) <= 2 || strlen($nama_jurusan) >= 50) {
		$errors['major-name'] = "Nama jurusan harus memiliki panjang 2 hingga 50 karakter";
	} else if ($oldData['name'] != $nama_jurusan) {
		if (!isDataAvailable($mysqli, 'jurusan', 'name', $nama_jurusan)) {
			$errors['major-name'] = "Nama jurusan sudah terdaftar, silakan pilih nama jurusan lain";
		}
	} else if (!ctype_alpha(str_replace(' ', '', $nama_jurusan))) {
		$errors['major-name'] = "Nama jurusan hanya boleh berisi huruf";
	}

	if ($kuota <= 1) {
		$errors['quota'] = "Kuota harus lebih besar dari 1";
	} else if ($kuota >= 999) {
		$errors['quota'] = "Kuota tidak boleh lebih dari 999";
	} else if (!is_numeric($kuota)) {
		$errors['quota'] = "Kuota harus berupa angka";
	}

	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['oldValues'] = array(
			'name' => $nama_jurusan,
			'quota' => $kuota,
			'slug' => $slug,
		);

		header("Location: " . BASE_URL_ADMIN . "/majors/edit/?slug=$slug");
		exit;
	}

	// Gunakan data sebelumnya jika user tidak mengisi data baru
	$nama_jurusan = empty($nama_jurusan) ? $oldData['name'] : $nama_jurusan;
	$kuota = empty($kuota) ? $oldData['quota'] : $kuota;
	$slug = createSlug($nama_jurusan);

	$query = "UPDATE jurusan SET name = ?, quota = ?, slug = ? WHERE id = ?";
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, "sisi", $nama_jurusan, $kuota, $slug, $oldData['id']);
	$result = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if ($result) {
		$_SESSION['flash_message'] = 'Data Jurusan Berhasil Diubah!';
		header("Location: " . BASE_URL_ADMIN . "/majors");
	} else {
		$_SESSION['flash_message'] = 'Data Jurusan Gagal Diubah!';
		header("Location: " . BASE_URL_ADMIN . "/majors/edit/?slug=$slug");
	}
}
