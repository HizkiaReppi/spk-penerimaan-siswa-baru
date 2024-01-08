<?php
include_once "../../../lib/koneksi.php";

$no_daftar = $_GET['no_pendaftaran'];

$query = "SELECT p.email, p.nisn, p.name as nama_peserta, j.name as nama_jurusan, p.jenis_kelamin, p.tanggal_lahir, p.alamat, p.asal_sekolah, p.nilai_ujian_sekolah, p.nilai_akhir, j.quota FROM peserta p INNER JOIN jurusan j on p.id_jurusan = j.id where no_pendaftaran = ?";
$stmt = mysqli_prepare($mysqli, $query);
$stmt->bind_param('s', $no_daftar);
mysqli_stmt_execute($stmt);
$tampilpeserta = mysqli_stmt_get_result($stmt);
$peserta = mysqli_fetch_assoc($tampilpeserta);

$query = "SELECT no_pendaftaran, nilai_akhir, FIND_IN_SET( nilai_akhir, (
    SELECT GROUP_CONCAT( nilai_akhir
    ORDER BY nilai_akhir DESC )
    FROM peserta )
    ) AS ranking
    FROM peserta
    WHERE no_pendaftaran = ?";
$stmt = mysqli_prepare($mysqli, $query);
$stmt->bind_param('s', $no_daftar);
mysqli_stmt_execute($stmt);
$tampilranking = mysqli_stmt_get_result($stmt);
$ranking = mysqli_fetch_assoc($tampilranking);
mysqli_stmt_close($stmt);

$title = "Detail Peserta " . $peserta['nama_peserta'];

include_once "../../templates/header.php";

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/participants">Peserta</a></li>
    <li class=" breadcrumb-item active">Detail Peserta</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Data Peserta</div>
            <form>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="callout callout-info">
                      <small class="text-muted">Nilai Akhir</small>
                      <br>
                      <strong class="h4">
                        <?php
                        if ($peserta['nilai_akhir'] == NULL) {
                          echo "0";
                        } else {
                          echo $peserta['nilai_akhir'];
                        }
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
                        <?= $ranking['ranking']; ?>
                      </strong>
                      <div class="chart-wrapper">
                        <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php if ($ranking['ranking'] <= $peserta['quota']) : ?>
            <div class="card text-white bg-success">
              <div class="card-body">
                <div class="text-value">
                  <span class="text-center">Lulus</span>
                </div>
                <div>Selamat, Anda dinyatakan diterima di jurusan <?= $peserta['nama_jurusan']; ?></div>
              </div>
            </div>
          <?php else : ?>
            <div class="card text-white bg-danger">
              <div class="card-body">
                <div class="text-value">
                  <span class="text-center">Tidak Lulus</span>
                </div>
                <div>Mohon Maaf, Anda belum diterima di jurusan <?= $peserta['nama_jurusan']; ?></div>
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
                  <dt class="col-sm-3">No Pendaftaran</dt>
                  <dd class="col-sm-9"><?= $no_daftar; ?></dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Email</dt>
                  <dd class="col-sm-9"><?= $peserta['email']; ?></dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">NISN</dt>
                  <dd class="col-sm-9"><?= $peserta['nisn']; ?></dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Nama Jurusan</dt>
                  <dd class="col-sm-9"><?= $peserta['nama_jurusan']; ?></dd>
                </dl>
                <hr class="mt-0">
                <dl class="row">
                  <dt class="col-sm-3">Nama Peserta</dt>
                  <dd class="col-sm-9"><?= $peserta['nama_peserta']; ?></dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Jenis Kelamin</dt>
                  <dd class="col-sm-9">
                    <?php if ($peserta['jenis_kelamin'] == 'L') {
                      echo "Laki-Laki";
                    } elseif ($peserta['jenis_kelamin'] == 'P') {
                      echo "Perempuan";
                    } ?>
                  </dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Tanggal Lahir</dt>
                  <dd class="col-sm-9">
                    <?php
                    $originalDate = $peserta['tanggal_lahir'];
                    $newDate = date("d-m-Y", strtotime($originalDate));
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
                  <dt class="col-sm-3">Asal Sekolah</dt>
                  <dd class="col-sm-9"><?= $peserta['asal_sekolah']; ?></dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Nilai Ujian Sekolah</dt>
                  <dd class="col-sm-9"><?= $peserta['nilai_ujian_sekolah']; ?></dd>
                </dl>
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

<?php include_once "../../templates/footer.php"; ?>
