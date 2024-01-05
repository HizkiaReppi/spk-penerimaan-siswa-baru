<?php
session_start();

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href=../login><b>LOGIN</b></a></center>";
	exit;
}

include_once "../../../lib/koneksi.php";

$no_daftar = $_GET['no_pendaftaran'];

try {
	$mysqli->begin_transaction();
	$stmt1 = $mysqli->prepare("DELETE FROM nilai WHERE no_pendaftaran = ?");
	$stmt1->bind_param('s', $no_daftar);
	$stmt1->execute();

	$stmt2 = $mysqli->prepare("DELETE FROM normalisasi WHERE no_pendaftaran = ?");
	$stmt2->bind_param('s', $no_daftar);
	$stmt2->execute();

	$stmt3 = $mysqli->prepare("DELETE FROM peserta WHERE no_pendaftaran = ?");
	$stmt3->bind_param('s', $no_daftar);
	$stmt3->execute();

	$mysqli->commit();

	$_SESSION['flash_message'] = 'Data Peserta Berhasil Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/participants");
} catch (\Exception $e) {
	$mysqli->rollback();

	$_SESSION['flash_message'] = 'Data Peserta Gagal Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/participants");
} finally {
	$stmt1->close();
	$stmt2->close();
	$stmt3->close();
	$mysqli->close();
}
