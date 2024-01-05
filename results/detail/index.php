<?php
$slug = $_GET['slug'];

require_once '../../lib/koneksi.php';
require_once '../../lib/functions.php';


$stmtJurusan = $mysqli->prepare("SELECT id, name FROM jurusan WHERE slug = ?");
$stmtJurusan->bind_param("s", $slug);
$stmtJurusan->execute();
$tampiljurusan = $stmtJurusan->get_result();
$stmtJurusan->close();
$jurusan = mysqli_fetch_assoc($tampiljurusan);

$title = "Hasil Seleksi Jurusan $jurusan[name]";

$id_jurusan = $jurusan['id'];
$stmt = $mysqli->prepare("SELECT no_pendaftaran, p.name AS nama_peserta, nilai_akhir FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id WHERE p.id_jurusan = ? ORDER BY nilai_akhir DESC");
$stmt->bind_param("s", $id_jurusan);
$stmt->execute();
$tampilpeserta = $stmt->get_result();
$stmt->close();

include_once '../../templates/header.php';

?>
<div class="features">
	<div class="container">
		<h2 class="text-center">Hasil Seleksi Jurusan <?= $jurusan['name']; ?></h2>
		<div class="row features_row justify-content-center">
			<div class="col-md-10">
				<table class="table table-responsive-sm table-striped" style="margin-top: 20px">
					<thead>
						<tr>
							<th>Ranking</th>
							<th>No Pendaftaran</th>
							<th>Nama Peserta</th>
							<th>Nilai Akhir</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$rank = 1;
						while ($peserta = $tampilpeserta->fetch_array()) : ?>
							<tr>
								<td><?= $rank; ?></td>
								<td><?= $peserta['no_pendaftaran']; ?></td>
								<td><?= $peserta['nama_peserta']; ?></td>
								<td><?= $peserta['nilai_akhir']; ?></td>
							</tr>
						<?php
							$rank++;
						endwhile;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php include_once '../../templates/footer.php' ?>
