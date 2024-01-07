<?php
session_start();
include "../../../lib/koneksi.php";
include "../../../lib/functions.php";

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href='" . BASE_URL_ADMIN . "/login'><b>LOGIN</b></a></center>";
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

	$criteria_name = htmlspecialchars(trim($_POST['criteria-name']));
	$bobot = (float)htmlspecialchars($_POST['bobot']);
	$jenis = strtolower(htmlspecialchars(trim($_POST['jenis'])));

	// Ambil data kriteria sebelumnya dari database
	$stmt = mysqli_prepare($mysqli, "SELECT SUM(bobot) AS total_bobot FROM kriteria ");
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);
	$total_bobot = (float)$row['total_bobot'];
	mysqli_stmt_close($stmt);

	$errors = array();

	if (empty($criteria_name)) {
		$errors['criteria-name'] = "Nama Kriteria harus diisi";
	} else if (strlen($criteria_name) <= 2 || strlen($criteria_name) >= 100) {
		$errors['criteria-name'] = "Nama Kriteria harus memiliki panjang 2 hingga 109 karakter";
	}

	if ($bobot <= 0) {
		$errors['bobot'] = "Bobot harus lebih besar dari 0";
	} else if ($bobot + $total_bobot > 1) {
		$errors['bobot'] = "Saat ini total bobot kriteria adalah $total_bobot, " . (1 - $total_bobot != 0 ? "jadi bobot maksimal yang bisa ditambahkan adalah " . (1 - $total_bobot) . "" : "jadi anda tidak bisa menambah kriteria");
	}

	if (empty($jenis)) {
		$errors['jenis'] = "Jenis kriteria harus diisi";
	} else if (!in_array($jenis, ['benefit', 'cost'])) {
		$errors['jenis'] = "Jenis kriteria harus 'benefit' atau 'cost'";
	}

	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;
		$_SESSION['old_input'] = array(
			'id' => $id,
			'name' => $criteria_name,
			'bobot' => $bobot,
			'jenis' => $jenis,
		);

		header("Location: " . BASE_URL_ADMIN . "/criteria/insert");
		exit;
	}

	$id = generateUuid();

	try {
		$mysqli->begin_transaction();

		$query = "INSERT INTO kriteria (id, name, bobot, jenis) VALUES (?, ?, ?, ?)";
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_bind_param($stmt, "ssds", $id, $criteria_name, $bobot, $jenis);
		$result = mysqli_stmt_execute($stmt);

		$mysqli->commit();

		$_SESSION['flash_message'] = 'Data Kriteria Berhasil Ditambah!';
		header("Location: " . BASE_URL_ADMIN . "/criteria");
	} catch (\Exception $e) {
		$mysqli->rollback();
		$_SESSION['flash_message'] = 'Data Kriteria Gagal Ditambah!';
		header("Location: " . BASE_URL_ADMIN . "/criteria/insert");
	} finally {
		mysqli_stmt_close($stmt);
		$mysqli->close();
	}
}
