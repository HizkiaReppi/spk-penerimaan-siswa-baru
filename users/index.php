<?php
include "../lib/koneksi.php";
include_once "../templates/header.php";

if (isset($_SESSION['user'])) {
  $session_user = $_SESSION['user']['no_pendaftaran'];
} else {
  echo "<script>window.location.href='" . BASE_URL . "/login'</script>";
  exit;
}

$tampilpeserta = mysqli_query($mysqli, "SELECT email, nisn, p.name as nama_peserta, j.name as nama_jurusan, jenis_kelamin, tanggal_lahir, alamat, asal_sekolah, nilai_ujian_sekolah, nilai_akhir, quota, C1, C2, C3, C4, C5 FROM peserta p INNER JOIN jurusan j ON p.id_jurusan = j.id INNER JOIN nilai n ON p.no_pendaftaran = n.no_pendaftaran WHERE p.no_pendaftaran = '$session_user'");
$peserta = mysqli_fetch_assoc($tampilpeserta);

$tampilranking = mysqli_query($mysqli, "SELECT DISTINCT id_jurusan, no_pendaftaran, name, nilai_akhir, ranking
      FROM (
        SELECT
          id_jurusan,
          no_pendaftaran,
          name,
          nilai_akhir,
          @peserta:=CASE WHEN @jurusan <> id_jurusan THEN 1 ELSE @peserta+1 END AS ranking,
          @jurusan:=id_jurusan AS Jurusan
        FROM (
          SELECT p.id_jurusan, p.no_pendaftaran, p.name, p.nilai_akhir
          FROM peserta p
          JOIN nilai n ON p.no_pendaftaran = n.no_pendaftaran
          ORDER BY p.id_jurusan, p.nilai_akhir DESC
        ) AS temp
      ) AS temp2
      WHERE no_pendaftaran = '$session_user'
      ");
$ranking = mysqli_fetch_assoc($tampilranking);

$i = 1;
$tampilkriteria = mysqli_query($mysqli, "SELECT * FROM kriteria");
while ($kriteria = mysqli_fetch_assoc($tampilkriteria)) {
  $C[$i] = $kriteria['name'];
  $i++;
}

is_null($ranking['ranking']) && $ranking['ranking'] <= $peserta['quota'] ? $status = 'Lulus' : $status = 'Tidak Lulus';

?>
<!-- Features -->
<div class="popular">
  <div class="section_background parallax-window" data-parallax="scroll" data-image-src="images/courses_background.jpg" data-speed="0.8"></div>
  <div class="container">
    <div class="row courses_row justify-content-center">
      <!-- Features Item -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Data Peserta</div>
          <form>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-sm-6">
                  <div class="callout callout-info">
                    <small class="text-muted">Nilai Akhir</small>
                    <br>
                    <strong class="h4">
                      <?php
                      echo $peserta['nilai_akhir'] == NULL ? "Belum Dinilai" : $peserta['nilai_akhir'];
                      ?>
                    </strong>
                    <div class="chart-wrapper">
                      <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="callout callout-danger">
                    <small class="text-muted">Ranking</small>
                    <br>
                    <strong class="h4">
                      <?php
                      echo $ranking['ranking'] == NULL ? "Belum Dinilai" : $ranking['ranking'];
                      ?>
                    </strong>
                    <div class="chart-wrapper">
                      <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-10 mt-3">
                  <a href="<?= BASE_URL; ?>/users/edit" class="btn btn-success btn-block">
                    <i class="fa fa-pencil mr-2"></i>Edit
                  </a>
                  <a href="<?= BASE_URL; ?>/users/print" class="btn btn-info btn-block">
                    <i class="fa fa-print mr-2"></i>Cetak
                  </a>
                  <a href="<?= BASE_URL; ?>/logout" class="btn btn-primary btn-block">
                    <i class="fa fa-lock mr-2"></i>Logout
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
        <br>
        <?php if (!is_null($ranking['ranking'])) : ?>
          <div class="card text-white <?= $status === 'Lulus' ? 'bg-success' : 'bg-danger' ?>">
            <div class="card-body">
              <div class="text-value">
                <h3 class="text-center text-white mb-2"><?= $status; ?></h3>
              </div>
              <div><?= $status === 'Lulus' ? 'Selamat, Anda dinyatakan' : 'Mohon Maaf, Anda belum' ?> diterima di jurusan <?= $peserta['nama_jurusan']; ?></div>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Detail Data Peserta</div>
          <div class="card-body">
            <div class="bd-example">
              <dl class="row">
                <dt class="col-sm-3">Nama Lengkap</dt>
                <dd class="col-sm-9"><?= $peserta['nama_peserta']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Jenis Kelamin</dt>
                <dd class="col-sm-9">
                  <?php echo $peserta['jenis_kelamin'] === 'L' ? 'Laki-Laki' : 'Perempuan' ?>
                </dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Tanggal Lahir</dt>
                <dd class="col-sm-9">
                  <?php
                  $newDate = date("d-m-Y", strtotime($peserta['tanggal_lahir']));
                  echo $newDate;
                  ?>
                </dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9"><?= $peserta['alamat']; ?></dd>
              </dl>
              <hr class="mt-0">
              <dl class="row">
                <dt class="col-sm-3">No Pendaftaran</dt>
                <dd class="col-sm-9"><?= $session_user; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">NISN</dt>
                <dd class="col-sm-9"><?= $peserta['nisn']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9"><?= $peserta['email']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Nama Jurusan</dt>
                <dd class="col-sm-9"><?= $peserta['nama_jurusan']; ?></dd>
              </dl>
              <hr class="mt-0">
              <dl class="row">
                <dt class="col-sm-3">Asal Sekolah</dt>
                <dd class="col-sm-9"><?= $peserta['asal_sekolah']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Nilai <?= $C[1]; ?></dt>
                <dd class="col-sm-9"><?= $peserta['nilai_ujian_sekolah']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Nilai <?= $C[2]; ?></dt>
                <dd class="col-sm-9"><?= $peserta['C2']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Nilai <?= $C[3]; ?></dt>
                <dd class="col-sm-9"><?= $peserta['C3']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Nilai <?= $C[4]; ?></dt>
                <dd class="col-sm-9"><?= $peserta['C4']; ?></dd>
              </dl>
              <dl class="row">
                <dt class="col-sm-3">Nilai <?= $C[5]; ?></dt>
                <dd class="col-sm-9"><?= $peserta['C5']; ?></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once '../templates/footer.php' ?>
