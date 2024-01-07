<?php
session_start();

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href='" . BASE_URL_ADMIN . "/login'><b>LOGIN</b></a></center>";
	exit;
}

include_once "../../../lib/koneksi.php";
include_once "../../../lib/functions.php";

$idKriteria = $_GET['id'];

$isDataNotAvailable = isDataAvailable($mysqli, 'kriteria', 'id', $idKriteria);

if ($isDataNotAvailable) {
	$_SESSION['flash_message'] = 'Data Kriteria Tidak Ditemukan!';
	header("Location: " . BASE_URL_ADMIN . "/criteria");
}

try {
	$mysqli->begin_transaction();
	$queryHapus = mysqli_prepare($mysqli, "DELETE FROM kriteria WHERE id = ?");
	mysqli_stmt_bind_param($queryHapus, 's', $idKriteria);
	mysqli_stmt_execute($queryHapus);

	if (mysqli_stmt_affected_rows($queryHapus) > 0) {
		$mysqli->commit();

		$_SESSION['flash_message'] = 'Data Berhasil Dihapus!';
		header("Location: " . BASE_URL_ADMIN . "/criteria");
	}
} catch (Exception $e) {
	$mysqli->rollback();

	$_SESSION['flash_message'] = 'Data Gagal Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/criteria");
} finally {
	$queryHapus->close();
	$mysqli->close();
}
