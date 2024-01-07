<?php

include_once "../../../lib/koneksi.php";
include_once "../../../lib/functions.php";

$title = 'Edit Data Kriteria';

include_once "../../templates/header.php";

if (!isset($_GET['id'])) {
  echo '<script>window.location.href = "' . BASE_URL_ADMIN . '/criteria";</script>';
  exit;
}

$idKriteria = $_GET['id'];

$stmt = mysqli_prepare($mysqli, "SELECT * FROM kriteria where ID = ?");
mysqli_stmt_bind_param($stmt, 's', $idKriteria);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$kriteria = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) <= 1) {
  $_SESSION['flash_message'] = 'Data Kriteria Tidak Ditemukan!';
  echo '<script>window.location.href = "' . BASE_URL_ADMIN . '/criteria";</script>';
  exit;
}

// Hitung sisa bobot yang tersedia
$total_bobot = 1;
$query = "SELECT SUM(bobot) AS total_bobot FROM kriteria WHERE ID != ?";
$stmt = mysqli_prepare($mysqli, $query);
mysqli_stmt_bind_param($stmt, "s", $idKriteria);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$total_bobot -= (float)$row['total_bobot'];
mysqli_stmt_close($stmt);

$oldValues = isset($_SESSION['oldValues']) ? $_SESSION['oldValues'] : $kriteria;

unset($_SESSION['oldValues']);

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/criteria">Kriteria</a></li>
    <li class="breadcrumb-item active">Ubah</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Ubah Data Kriteria</div>
            <form action="<?= BASE_URL_ADMIN . "/criteria/" . $idKriteria . "/update" ?>" method="POST">
              <div class="card-body">
                <?= csrf($_SESSION['csrf_token']);  ?>
                <div class="form-group">
                  <input type="hidden" name="id" value="<?= $idKriteria; ?>">
                  <label for="criteria-name">Nama Kriteria</label>
                  <input class="form-control <?= isset($errors['criteria-name']) ? 'is-invalid' : ''; ?>" id="criteria-name" type="text" name="criteria-name" value="<?= isset($oldValues['name']) ? $oldValues['name'] : ''; ?>">
                  <?php if (isset($errors['criteria-name'])) : ?>
                    <div class="invalid-feedback"><?= $errors['criteria-name']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="bobot">Bobot</label>
                  <input class="form-control <?= isset($errors['bobot']) ? 'is-invalid' : ''; ?>" id="bobot" type="number" name="bobot" value="<?= isset($oldValues['bobot']) ? $oldValues['bobot'] : ''; ?>" min="0" max="1" step="0.05">
                  <small class="form-text text-muted">
                    Sisa bobot yang tersedia: <?= $total_bobot; ?>
                  </small>
                  <?php if (isset($errors['bobot'])) : ?>
                    <div class="invalid-feedback"><?= $errors['bobot']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="jenis">Jenis</label>
                  <select class="form-select" id="jenis" name="jenis">
                    <option value="benefit" <?= isset($oldValues['jenis']) && $oldValues['jenis'] == 'benefit' ? 'selected' : ''; ?>>Benefit</option>
                    <option value="cost" <?= isset($oldValues['jenis']) && $oldValues['jenis'] == 'cost' ? 'selected' : ''; ?>>Cost</option>
                  </select>
                </div>
                <div class="row align-items-center mt-3">
                  <div class="col-sm-6">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Simpan</button>
                  </div>
                  <div class="col-sm-6">
                    <a class="btn btn-outline-info btn-lg btn-block" href="<?= BASE_URL_ADMIN ?>/criteria">Batal</a>
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

<?php include_once "../../templates/footer.php"; ?>
