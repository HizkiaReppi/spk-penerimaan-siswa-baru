<?php
session_start();

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href=../login><b>LOGIN</b></a></center>";
} else {
	include "../../lib/koneksi.php";

	$id_admin = $_POST['id_admin'];
	$nama = $_POST['nama'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$querySimpan = mysqli_query($mysqli, "UPDATE admin SET name='$nama', Username='$user', password='$pass' WHERE Id_Admin=$id_admin");
	if ($querySimpan) {
		echo "<script> alert ('Data Anda Berhasil Disimpan'); window.location='../akun/edit_akun.php';</script>";
	} else {
		echo "<script> alert ('Data Anda Gagal Disimpan'); window.location='../akun/edit_akun.php';</script>";
	}
}
