<?php
session_start();
include "../../lib/koneksi.php";

if (isset($_SESSION['user'])) {
	$session_user = $_SESSION['user']['no_pendaftaran'];
} else {
	echo "<script>window.location.href='" . BASE_URL . "/login'</script>";
	exit;
}

$stmt = $mysqli->prepare("SELECT email, nisn, p.name AS nama_peserta, j.name AS nama_jurusan, jenis_kelamin, tanggal_lahir, alamat, asal_sekolah, nilai_ujian_sekolah, nilai_akhir FROM peserta p INNER JOIN jurusan j on p.id_jurusan = j.id WHERE no_pendaftaran = ?");
$stmt->bind_param("s", $session_user);
$stmt->execute();
$tampilpeserta = $stmt->get_result();
$peserta = mysqli_fetch_assoc($tampilpeserta);

?>

<!DOCTYPE html>
<html>

<head>
	<title>
		Bukti Pendaftaran <?= $session_user . "-" . $peserta['nama_peserta']; ?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>/assets/styles/bootstrap4/bootstrap.min.css">
</head>

<body class="container my-5">
	<div class="d-flex flex-column justify-content-center align-items-center">
		<h2>Sekolah Menengah Atas Negeri 1 Langowan</h2>
		<h6>Jl. Siswa, Sumarayar, Kec. Langowan Timur, Kab. Minahasa, Sulawesi Utara</h6>
	</div>
	<hr>
	<br />

	<div class="d-flex flex-column justify-content-center align-items-center">
		<h3>Bukti Pendaftaran Calon Peserta Didik</h3>

		<table border="0">
			<tr>
				<td>No Pendaftaran</td>
				<td>:</td>
				<td><?= $session_user; ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td>:</td>
				<td><?= $peserta['email']; ?></td>
			</tr>
			<tr>
				<td>NISN</td>
				<td>:</td>
				<td><?= $peserta['nisn']; ?></td>
			</tr>
			<tr>
				<td>Jurusan</td>
				<td>:</td>
				<td><?= $peserta['nama_jurusan']; ?></td>
			</tr>
			<tr>
				<td>Nama Peserta</td>
				<td>:</td>
				<td><?= $peserta['nama_peserta']; ?></td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>
					<?= $peserta['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan'; ?>
				</td>
			</tr>
			<tr>
				<td>Tanggal Lahir</td>
				<td>:</td>
				<td>
					<?php
					$newDate = date("d-m-Y", strtotime($peserta['tanggal_lahir']));
					echo $newDate;
					?>
				</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td><?= $peserta['alamat']; ?></td>
			</tr>
			<tr>
				<td>Asal Sekolah</td>
				<td>:</td>
				<td><?= $peserta['asal_sekolah']; ?></td>
			</tr>
			<tr>
				<td>Nilai Ujian Nasional</td>
				<td>:</td>
				<td><?= $peserta['nilai_ujian_sekolah']; ?></td>
			</tr>
		</table>
		<button type="button" id="btn" class="btn btn-primary d-none mt-5">
			<a class="text-white text-decoration-none" href="<?= BASE_URL; ?>/users">Kembali</a>
		</button>
	</div>

	<script>
		setTimeout(() => {
			document.getElementById('btn').classList.remove('d-none');
		}, 10000);

		window.print();
	</script>

</body>

</html>
