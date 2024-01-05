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
	$criteria_name = htmlspecialchars($_POST['criteria-name']);
	$bobot = (float)htmlspecialchars($_POST['bobot']);
	$jenis = htmlspecialchars($_POST['jenis']);

	// Ambil data kriteria sebelumnya dari database
	$query = "SELECT SUM(bobot) AS total_bobot FROM kriteria WHERE id != ?";
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);
	$total_bobot = (float)$row['total_bobot'];
	mysqli_stmt_close($stmt);

	$errors = array();

	if (empty($criteria_name)) {
		$errors['criteria-name'] = "name kriteria harus diisi";
	} else if (strlen($criteria_name) <= 2 || strlen($criteria_name) >= 50) {
		$errors['criteria-name'] = "name kriteria harus memiliki panjang 2 hingga 50 karakter";
	}

	if ($bobot <= 0) {
		$errors['bobot'] = "Bobot harus lebih besar dari 0";
	} else if ($bobot + $total_bobot > 1) {
		$errors['bobot'] = "Saat ini total bobot kriteria adalah $total_bobot, jadi bobot maksimal yang bisa ditambahkan adalah " . (1 - $total_bobot) . "";
	}

	if (empty($jenis)) {
		$errors['jenis'] = "Jenis kriteria harus diisi";
	} else if (!in_array($jenis, ['benefit', 'cost'])) {
		$errors['jenis'] = "Jenis kriteria harus 'benefit' atau 'cost'";
	}

	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['oldValues'] = array(
			'id' => $id,
			'name' => $criteria_name,
			'bobot' => $bobot,
			'jenis' => $jenis,
		);

		header("Location: " . BASE_URL_ADMIN . "/criteria/edit/?id_kriteria=$id");
		exit;
	}

	// Gunakan data sebelumnya jika user tidak mengisi data baru
	$criteria_name = empty($criteria_name) ? $oldData['name'] : $criteria_name;
	$bobot = empty($bobot) ? $oldData['bobot'] : $bobot;
	$jenis = empty($jenis) ? $oldData['jenis'] : $jenis;

	$query = "UPDATE kriteria SET name = ?, bobot = ?, jenis = ? WHERE id = ?";
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, "sdsi", $criteria_name, $bobot, $jenis, $id);
	$result = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if ($result) {
		$_SESSION['flash_message'] = 'Data Kriteria Berhasil Diubah!';
		header("Location: " . BASE_URL_ADMIN . "/criteria");
	} else {
		$_SESSION['flash_message'] = 'Data Kriteria Gagal Diubah!';
		header("Location: " . BASE_URL_ADMIN . "/criteria/edit/?id_kriteria=$id");
	}
}
