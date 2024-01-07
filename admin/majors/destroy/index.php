<?php
session_start();
include_once "../../../lib/koneksi.php";

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href='" . BASE_URL_ADMIN . "/login'><b>LOGIN</b></a></center>";
	exit;
}

$slug = $_GET['slug'];

try {
	$mysqli->begin_transaction();
	$queryHapus = mysqli_prepare($mysqli, "DELETE FROM jurusan WHERE slug = ?");
	mysqli_stmt_bind_param($queryHapus, 's', $slug);
	mysqli_stmt_execute($queryHapus);

	if (mysqli_stmt_affected_rows($queryHapus) > 0) {
		$mysqli->commit();

		$_SESSION['flash_message'] = 'Data Berhasil Dihapus!';
		header("Location: " . BASE_URL_ADMIN . "/majors");
	}
} catch (Exception $e) {
	$mysqli->rollback();
	$_SESSION['flash_message'] = 'Data Gagal Dihapus!';
	header("Location: " . BASE_URL_ADMIN . "/majors");
} finally {
	$queryHapus->close();
	$mysqli->close();
}
