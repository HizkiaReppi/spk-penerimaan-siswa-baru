<?php
session_start();

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href=../login><b>LOGIN</b></a></center>";
}

include "../../../lib/koneksi.php";

$no_daftar = $_POST['no_pendaftaran'];
$C1 = $_POST['C1'];
$C2 = $_POST['C2'];
$C3 = $_POST['C3'];
$C4 = $_POST['C4'];
$C5 = $_POST['C5'];

$stmtUpdateNilai = $mysqli->prepare("UPDATE nilai SET C1=?, C2=?, C3=?, C4=?, C5=? WHERE no_pendaftaran=?");
$stmtUpdateNilai->bind_param('diiiis', $C1, $C2, $C3, $C4, $C5, $no_daftar);
$querySimpan = $stmtUpdateNilai->execute();
$stmtUpdateNilai->close();

$stmtUpdateUN = $mysqli->prepare("UPDATE peserta SET nilai_ujian_sekolah=? WHERE no_pendaftaran=?");
$stmtUpdateUN->bind_param('ds', $C1, $no_daftar);
$queryUN = $stmtUpdateUN->execute();
$stmtUpdateUN->close();

if ($querySimpan && $queryUN) {
	$_SESSION['flash_message'] = 'Data Nilai Berhasil Diubah!';
	header("Location: " . BASE_URL_ADMIN . "/values");
} else {
	$_SESSION['flash_message'] = 'Data Nilai Gagal Diubah!';
	header("Location: " . BASE_URL_ADMIN . "/values");
}
