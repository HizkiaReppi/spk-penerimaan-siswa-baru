<?php
session_start();

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href=../login><b>LOGIN</b></a></center>";
	exit;
}

include_once "../../../lib/koneksi.php";

$username = $_GET['username'];

try {
	$mysqli->begin_transaction();
	$stmt = $mysqli->prepare("DELETE FROM admin WHERE username = ?");
	$stmt->bind_param('s', $username);
	$stmt->execute();

	$mysqli->commit();

	$_SESSION['flash_message'] = 'Data Berhasil Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/users");
} catch (\Exception $e) {
	$mysqli->rollback();

	$_SESSION['flash_message'] = 'Data Gagal Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/users");
} finally {
	$stmt->close();
	$mysqli->close();
}
