<?php
include "../../../lib/koneksi.php";
include "../../../lib/functions.php";
include "../../templates/header.php";

$no_daftar = $_GET['no_pendaftaran'];
$session_admin = $_SESSION['admin'];

$stmtPeserta = $mysqli->prepare("SELECT name, C1, C2, C3, C4, C5 FROM peserta p JOIN nilai n ON p.no_pendaftaran = n.no_pendaftaran WHERE n.no_pendaftaran = ?");
$stmtPeserta->bind_param('s', $no_daftar);
$stmtPeserta->execute();
$resultPeserta = $stmtPeserta->get_result();
$peserta = $resultPeserta->fetch_assoc();
$resultPeserta->close();
$stmtPeserta->close();

$stmtC1 = $mysqli->prepare("SELECT * FROM kriteria WHERE id = 1");
$stmtC2 = $mysqli->prepare("SELECT * FROM kriteria WHERE id = 2");
$stmtC3 = $mysqli->prepare("SELECT * FROM kriteria WHERE id = 3");
$stmtC4 = $mysqli->prepare("SELECT * FROM kriteria WHERE id = 4");
$stmtC5 = $mysqli->prepare("SELECT * FROM kriteria WHERE id = 5");

$stmtC1->execute();
$resultC1 = $stmtC1->get_result();
$C1 = $resultC1->fetch_assoc();
$stmtC1->close();

$stmtC2->execute();
$resultC2 = $stmtC2->get_result();
$C2 = $resultC2->fetch_assoc();
$stmtC2->close();

$stmtC3->execute();
$resultC3 = $stmtC3->get_result();
$C3 = $resultC3->fetch_assoc();
$stmtC3->close();

$stmtC4->execute();
$resultC4 = $stmtC4->get_result();
$C4 = $resultC4->fetch_assoc();
$stmtC4->close();

$stmtC5->execute();
$resultC5 = $stmtC5->get_result();
$C5 = $resultC5->fetch_assoc();
$stmtC5->close();
?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/values">Nilai</a></li>
    <li class="breadcrumb-item active">Ubah</li>
  </ol>

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Data Peserta</div>
            <div class="card-body">
              <h2><?= $no_daftar; ?></h2>
              <h2><?= $peserta['name']; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Ubah Data Nilai Peserta</div>
            <form action="<?= BASE_URL_ADMIN ?>/values/<?= $no_daftar; ?>/update" method="POST">
              <div class="card-body">
                <input type="hidden" name="no_pendaftaran" value="<?= $no_daftar; ?>">
                <div class="form-group">
                  <label for="company"><?= $C1['name']; ?></label>
                  <input class="form-control" id="company" type="number" step="any" value="<?= $peserta['C1']; ?>" name="C1">
                </div>
                <div class="form-group">
                  <label for="company"><?= $C2['name']; ?></label>
                  <input class="form-control" id="company" type="number" step="any" value="<?= $peserta['C2']; ?>" name="C2">
                </div>
                <div class="form-group">
                  <label for="company"><?= $C3['name']; ?></label>
                  <input class="form-control" id="company" type="number" step="any" value="<?= $peserta['C3']; ?>" name="C3">
                </div>
                <div class="form-group">
                  <label for="company"><?= $C4['name']; ?></label>
                  <input class="form-control" id="company" type="number" step="any" value="<?= $peserta['C4']; ?>" name="C4">
                </div>
                <div class="form-group">
                  <label for="company"><?= $C5['name']; ?></label>
                  <input class="form-control" id="company" type="number" step="any" value="<?= $peserta['C5']; ?>" name="C5">
                </div>
                <div class="row align-items-center mt-3">
                  <div class="col-sm-6">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Simpan</button>
                  </div>
                  <div class="col-sm-6">
                    <a class="btn btn-outline-info btn-lg btn-block" href="<?= BASE_URL_ADMIN ?>/values">Batal</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- /.row-->
    </div>
  </div>
</main>

<?php include "../../templates/footer.php"; ?>
