<?php
session_start();

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href=../login><b>LOGIN</b></a></center>";
	exit;
}

include_once "../../../lib/koneksi.php";

$idKriteria = $_GET['id_kriteria'];

$queryHapus = mysqli_prepare($mysqli, "DELETE FROM kriteria WHERE id = ?");
mysqli_stmt_bind_param($queryHapus, 'i', $idKriteria);
mysqli_stmt_execute($queryHapus);

if (mysqli_stmt_affected_rows($queryHapus) > 0) {
	$_SESSION['flash_message'] = 'Data Berhasil Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/criteria");
} else {
	$_SESSION['flash_message'] = 'Data Gagal Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/criteria");
}
