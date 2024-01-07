<?php

include_once "../../../lib/koneksi.php";
include_once "../../../lib/functions.php";

$title = 'Tambah Data Kriteria';

include_once "../../templates/header.php";

// Hitung sisa bobot yang tersedia
$total_bobot = 1;
$stmt = mysqli_prepare($mysqli, "SELECT SUM(bobot) AS total_bobot FROM kriteria");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$total_bobot -= (float)$row['total_bobot'];
mysqli_stmt_close($stmt);

if ($total_bobot == 0) {
  $_SESSION['flash_message'] = 'Total Bobot Telah Penuh';
  echo "<script>window.location.href='" . BASE_URL_ADMIN . "/criteria'</script>";
}

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/criteria">Kriteria</a></li>
    <li class="breadcrumb-item active">Baru</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Tambah Data Kriteria</div>
            <form action="store.php" method="POST">
              <div class="card-body">
                <?= csrf($_SESSION['csrf_token']);  ?>
                <div class="form-group">
                  <label for="criteria-name">Nama Kriteria</label>
                  <input class="form-control <?= isset($errors['criteria-name']) ? 'is-invalid' : ''; ?>" id="criteria-name" type="text" name="criteria-name" value="<?= isset($old_input['name']) ? $old_input['name'] : ''; ?>">
                  <?php if (isset($errors['criteria-name'])) : ?>
                    <div class="invalid-feedback"><?= $errors['criteria-name']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="bobot">Bobot</label>
                  <input class="form-control <?= isset($errors['bobot']) ? 'is-invalid' : ''; ?>" id="bobot" type="number" name="bobot" value="<?= isset($old_input['bobot']) ? $old_input['bobot'] : ''; ?>" min="0" max="1" step="0.05">
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
                    <option value="benefit" <?= isset($old_input['jenis']) && $old_input['jenis'] == 'benefit' ? 'selected' : ''; ?>>Benefit</option>
                    <option value="cost" <?= isset($old_input['jenis']) && $old_input['jenis'] == 'cost' ? 'selected' : ''; ?>>Cost</option>
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
      </div>
    </div>
  </div>
</main>

<?php include_once "../../templates/footer.php"; ?>
