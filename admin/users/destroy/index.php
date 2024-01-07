<?php
session_start();

include_once "../../../lib/koneksi.php";

if (empty($_SESSION['admin'])) {
	header("Location: " . BASE_URL_ADMIN . "/login");
	exit;
}

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
