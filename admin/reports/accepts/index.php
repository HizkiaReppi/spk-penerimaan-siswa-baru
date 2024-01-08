<?php
include_once "../../../lib/koneksi.php";

$title = "Laporan";

include_once "../../templates/header.php";

$id_jurusan = $_GET['id_jurusan'];
?>

<main class="main">
  <!-- Breadcrumb-->
  <?php
  $stmt = mysqli_prepare($mysqli, "SELECT * FROM jurusan WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "s", $id_jurusan);
  mysqli_stmt_execute($stmt);
  $tampiljurusan = mysqli_stmt_get_result($stmt);
  $jurusan = mysqli_fetch_assoc($tampiljurusan);
  ?>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/dasboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/reports">Laporan</a></li>
    <li class="breadcrumb-item active"><?= $jurusan['name']; ?></li>
    <!-- Breadcrumb Menu-->
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Laporan Diterima Jurusan <?= $jurusan['name']; ?></div>
            <div class="card-body">
              <div class="col-6 col-sm-4 col-md mb-3 mb-xl-0">
                <a href="<?= BASE_URL_ADMIN; ?>/reports/accepts/<?= $id_jurusan; ?>/print" class="btn btn-primary">
                  <i class="fa fa-file"> Cetak Laporan</i>
                </a>
              </div>
              <div>
                <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                  <thead>
                    <tr>
                      <th>Ranking</th>
                      <th>No Pendaftaran</th>
                      <th>Nama Peserta</th>
                      <th>Asal Sekolah</th>
                      <th>Nilai Akhir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $rank = 1;
                    $tampilpeserta = mysqli_query($mysqli, "SELECT no_pendaftaran, p.name as nama_peserta, asal_sekolah, nilai_akhir FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id WHERE p.id_jurusan = '$id_jurusan' ORDER BY nilai_akhir DESC");
                    while ($peserta = mysqli_fetch_array($tampilpeserta)) :
                    ?>
                      <tr>
                        <td><?= $rank; ?></td>
                        <td><?= $peserta['no_pendaftaran']; ?></td>
                        <td><?= $peserta['nama_peserta']; ?></td>
                        <td><?= $peserta['asal_sekolah']; ?></td>
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
      </div>
    </div>
  </div>
</main>

<?php include_once "../../templates/footer.php"; ?>
