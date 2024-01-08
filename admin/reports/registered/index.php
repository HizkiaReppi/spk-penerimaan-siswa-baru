<?php
include_once "../../../lib/koneksi.php";

$title = "Laporan";

include_once "../../templates/header.php";

$id_jurusan = $_GET['id_jurusan'];

$tampiljurusan = mysqli_query($mysqli, "SELECT * FROM jurusan where id = '$id_jurusan'");
$jurusan = mysqli_fetch_assoc($tampiljurusan);

?>
<main class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/reports">Laporan</a></li>
    <li class="breadcrumb-item active"><?= $id_jurusan != 'all' ? $jurusan['name'] : 'Semua Jurusan'; ?></li>
    <!-- Breadcrumb Menu-->
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <?php if ($id_jurusan == 'all') : ?>
              <div class="card-header">Laporan Pendaftar Semua Jurusan</div>
              <div class="card-body">
                <div class="col-6 col-sm-4 col-md mb-3 mb-xl-0">
                  <a href="<?= BASE_URL_ADMIN; ?>/reports/registered/all/print" class="btn btn-primary">
                    <i class="fa fa-file"> Cetak Laporan</i>
                  </a>
                </div>
                <div>
                  <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                    <thead>
                      <tr>
                        <th>No Pendaftaran</th>
                        <th>NISN</th>
                        <th>Nama Peserta</th>
                        <th>Email</th>
                        <th>Asal Sekolah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $rank = 1;
                      $tampilpeserta = mysqli_query($mysqli, "SELECT no_pendaftaran, nisn, name, asal_sekolah, email FROM peserta ORDER BY no_pendaftaran ASC");
                      while ($peserta = mysqli_fetch_array($tampilpeserta)) :
                      ?>
                        <tr>
                          <td><?= $peserta['no_pendaftaran']; ?></td>
                          <td><?= $peserta['nisn']; ?></td>
                          <td><?= $peserta['name']; ?></td>
                          <td><?= $peserta['email']; ?></td>
                          <td><?= $peserta['asal_sekolah']; ?></td>
                        </tr>
                      <?php $rank++;
                      endwhile; ?>
                    </tbody>
                  </table>
                <?php else : ?>
                  <div class="card-header">Laporan Pendaftar Jurusan <?= $jurusan['name']; ?></div>
                  <div class="card-body">
                    <div class="col-6 col-sm-4 col-md mb-3 mb-xl-0">
                      <a href="<?= BASE_URL_ADMIN; ?>/reports/registered/<?= $id_jurusan; ?>/print" class="btn btn-primary">
                        <i class="fa fa-file"> Cetak Laporan</i>
                      </a>
                    </div>
                    <div>
                      <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                        <thead>
                          <tr>
                            <th>No Pendaftaran</th>
                            <th>NISN</th>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Asal Sekolah</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $rank = 1;
                          $tampilpeserta = mysqli_query($mysqli, "SELECT no_pendaftaran, nisn, p.name AS nama_peserta, asal_sekolah, email FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id WHERE p.id_jurusan = '$id_jurusan'");
                          while ($peserta = mysqli_fetch_array($tampilpeserta)) : ?>
                            <tr>
                              <td><?= $peserta['no_pendaftaran']; ?></td>
                              <td><?= $peserta['nisn']; ?></td>
                              <td><?= $peserta['nama_peserta']; ?></td>
                              <td><?= $peserta['email']; ?></td>
                              <td><?= $peserta['asal_sekolah']; ?></td>
                            </tr>
                          <?php
                            $rank++;
                          endwhile
                          ?>
                        </tbody>
                      </table>
                    <?php
                  endif;
                    ?>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include_once "../../templates/footer.php"; ?>
