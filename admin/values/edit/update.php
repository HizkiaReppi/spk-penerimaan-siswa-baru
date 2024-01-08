<?php
session_start();
include_once "../../../lib/koneksi.php";

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href='" . BASE_URL_ADMIN . "/login'><b>LOGIN</b></a></center>";
}

$no_daftar = htmlspecialchars(trim($_POST['no_pendaftaran']));
$C1 = htmlspecialchars(trim($_POST['C1']));
$C2 = htmlspecialchars(trim($_POST['C2']));
$C3 = htmlspecialchars(trim($_POST['C3']));
$C4 = htmlspecialchars(trim($_POST['C4']));
$C5 = htmlspecialchars(trim($_POST['C5']));

try {
	$mysqli->autocommit(FALSE);
	$mysqli->begin_transaction();

	$stmtUpdateNilai = $mysqli->prepare("UPDATE nilai SET C1=?, C2=?, C3=?, C4=?, C5=? WHERE no_pendaftaran=?");
	$stmtUpdateNilai->bind_param('ddddds', $C1, $C2, $C3, $C4, $C5, $no_daftar);
	$querySimpan = $stmtUpdateNilai->execute();

	$stmtUpdateUAS = $mysqli->prepare("UPDATE peserta SET nilai_ujian_sekolah=? WHERE no_pendaftaran=?");
	$stmtUpdateUAS->bind_param('ds', $C1, $no_daftar);
	$queryUN = $stmtUpdateUAS->execute();

	$mysqli->commit();
	$_SESSION['flash_message'] = 'Data Nilai Berhasil Diubah!';
	header("Location: " . BASE_URL_ADMIN . "/values");
} catch (\Exception $e) {
	$mysqli->rollback();
	$_SESSION['flash_message'] = 'Data Nilai Gagal Diubah!';
	header("Location: " . BASE_URL_ADMIN . "/values");
} finally {
	$mysqli->autocommit(TRUE);
	$stmtUpdateNilai->close();
	$stmtUpdateUAS->close();
	$mysqli->close();
}
