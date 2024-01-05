<?php
include "../../../lib/koneksi.php";
include "../../templates/header.php";

$id_jurusan = $_GET['id_jurusan'];
$session_admin = $_SESSION['admin'];

// Prepared statement untuk mendapatkan nilai maksimal
$stmtMax = $mysqli->prepare("SELECT MAX(C1) AS maxC1, MAX(C2) AS maxC2, MAX(C3) AS maxC3, MAX(C4) AS maxC4, MAX(C5) AS maxC5 FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id INNER JOIN nilai n ON p.no_pendaftaran = n.no_pendaftaran WHERE p.id_jurusan = ?");
$stmtMax->bind_param('s', $id_jurusan);
$stmtMax->execute();
$resultMax = $stmtMax->get_result();
$maksimal = $resultMax->fetch_assoc();
$stmtMax->close();

// Prepared statement untuk mendapatkan bobot kriteria
$stmtBobot = $mysqli->prepare("SELECT bobot FROM kriteria");
$stmtBobot->execute();
$resultBobot = $stmtBobot->get_result();

$i = 1;
while ($bobot_kriteria = $resultBobot->fetch_assoc()) {
  $bobot[$i] = $bobot_kriteria['bobot'];
  $i++;
}
$stmtBobot->close();

// Prepared statement untuk mengupdate nilai normalisasi
$stmtUpdate = $mysqli->prepare("UPDATE normalisasi SET C1=?, C2=?, C3=?, C4=?, C5=? WHERE no_pendaftaran=?");

// Prepared statement untuk mengupdate nilai akhir
$stmtNilaiAkhir = $mysqli->prepare("UPDATE peserta SET nilai_akhir=? WHERE no_pendaftaran=?");

// Prepared statement untuk menampilkan data peserta
$tampilpeserta = $mysqli->prepare("SELECT p.no_pendaftaran, p.name AS nama_peserta, C1, C2, C3, C4, C5 FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id INNER JOIN nilai n ON p.no_pendaftaran = n.no_pendaftaran WHERE p.id_jurusan = ?");
$tampilpeserta->bind_param('s', $id_jurusan);
$tampilpeserta->execute();
$resultPeserta = $tampilpeserta->get_result();

while ($peserta = $resultPeserta->fetch_assoc()) {
  $nomor = $peserta['no_pendaftaran'];
  $normalC1 = number_format($peserta['C1'] / $maksimal['maxC1'], 6);
  $normalC2 = number_format($peserta['C2'] / $maksimal['maxC2'], 6);
  $normalC3 = number_format($peserta['C3'] / $maksimal['maxC3'], 6);
  $normalC4 = number_format($peserta['C4'] / $maksimal['maxC4'], 6);
  $normalC5 = number_format($peserta['C5'] / $maksimal['maxC5'], 6);

  $stmtUpdate->bind_param('ddddds', $normalC1, $normalC2, $normalC3, $normalC4, $normalC5, $nomor);
  $stmtUpdate->execute();

  $akhir = number_format(($normalC1 * $bobot[1]) + ($normalC2 * $bobot[2]) + ($normalC3 * $bobot[3]) + ($normalC4 * $bobot[4]) + ($normalC5 * $bobot[5]), 6);

  $stmtNilaiAkhir->bind_param('ds', $akhir, $nomor);
  $stmtNilaiAkhir->execute();
}

$stmtUpdate->close();
$stmtNilaiAkhir->close();

$stmtNilaiAlternatif = $mysqli->prepare("SELECT p.no_pendaftaran, p.name AS nama_peserta, j.name AS nama_jurusan, C1, C2, C3, C4, C5 FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id INNER JOIN nilai n ON p.no_pendaftaran = n.no_pendaftaran WHERE p.id_jurusan = ?");
$stmtNilaiAlternatif->bind_param('s', $id_jurusan);
$stmtNilaiAlternatif->execute();
$tampilNilaiAlternatif = $stmtNilaiAlternatif->get_result();
$stmtNilaiAlternatif->close();

$tampiljurusan = $mysqli->query("SELECT * FROM jurusan where id = '$id_jurusan'");
$jurusan = $tampiljurusan->fetch_assoc();

$stmtNilaiR = $mysqli->prepare("SELECT p.no_pendaftaran, p.name AS nama_peserta, j.name AS nama_jurusan, C1, C2, C3, C4, C5 FROM peserta p INNER JOIN jurusan j on p.id_jurusan=j.id INNER JOIN normalisasi n ON p.no_pendaftaran = n.no_pendaftaran WHERE p.id_jurusan = ?");
$stmtNilaiR->bind_param('s', $id_jurusan);
$stmtNilaiR->execute();
$tampilNilaiR = $stmtNilaiR->get_result();
$stmtNilaiR->close();

$tampilkriteria = $mysqli->query("SELECT name FROM kriteria");

$stmtNilaiAkhir = $mysqli->prepare("SELECT no_pendaftaran, p.name AS nama_peserta, nilai_akhir FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id WHERE p.id_jurusan = ? ORDER BY nilai_akhir DESC");
$stmtNilaiAkhir->bind_param('s', $id_jurusan);
$stmtNilaiAkhir->execute();
$tampilNilaiAkhir = $stmtNilaiAkhir->get_result();
$stmtNilaiAkhir->close();

?>

<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/normalization">Normalisasi</a></li>
    <li class="breadcrumb-item active"><?= $jurusan['name']; ?></li>
    <!-- Breadcrumb Menu-->
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Data Normalisasi <?= $jurusan['name']; ?></div>
            <div class="card-body">
              <h3>Nilai Alternatif Kriteria</h3>
              <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th>No Pendaftaran</th>
                    <th>Nama Peserta</th>
                    <?php while ($kriteria = $tampilkriteria->fetch_array()) : ?>
                      <th><?= $kriteria['name']; ?></th>
                    <?php endwhile; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($peserta = $tampilNilaiAlternatif->fetch_array()) : ?>
                    <tr>
                      <td><?= $peserta['no_pendaftaran']; ?></td>
                      <td><?= $peserta['nama_peserta']; ?></td>
                      <td><?= $peserta['C1']; ?></td>
                      <td><?= $peserta['C2']; ?></td>
                      <td><?= $peserta['C3']; ?></td>
                      <td><?= $peserta['C4']; ?></td>
                      <td><?= $peserta['C5']; ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
              <h3>Nilai Normalisasi R</h3>
              <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th>No Pendaftaran</th>
                    <th>Nama Peserta</th>
                    <?php
                    $tampilkriteria = $mysqli->query("SELECT name FROM kriteria");
                    while ($kriteria = $tampilkriteria->fetch_array()) : ?>
                      <th><?= $kriteria['name']; ?></th>
                    <?php endwhile; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($peserta = $tampilNilaiR->fetch_array()) : ?>
                    <tr>
                      <td><?= $peserta['no_pendaftaran']; ?></td>
                      <td><?= $peserta['nama_peserta']; ?></td>
                      <td><?= $peserta['C1']; ?></td>
                      <td><?= $peserta['C2']; ?></td>
                      <td><?= $peserta['C3']; ?></td>
                      <td><?= $peserta['C4']; ?></td>
                      <td><?= $peserta['C5']; ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
              <h3>Nilai Akhir</h3>
              <div class="col-md-6">
                <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                  <thead>
                    <tr>
                      <th>Ranking</th>
                      <th>No Pendaftaran</th>
                      <th>Nama Jurusan</th>
                      <th>Nilai Akhir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $rank = 1;
                    while ($peserta = $tampilNilaiAkhir->fetch_array()) :
                    ?>
                      <tr>
                        <td><?= $rank; ?></td>
                        <td><?= $peserta['no_pendaftaran']; ?></td>
                        <td><?= $peserta['nama_peserta']; ?></td>
                        <td><?= $peserta['nilai_akhir']; ?></td>
                      </tr>
                    <?php
                      $rank++;
                    endwhile
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- /.row-->
    </div>
  </div>
</main>
<?php
include "../../templates/footer.php";
?>
