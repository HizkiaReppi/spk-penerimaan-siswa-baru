<?php

include_once "../../../lib/koneksi.php";
include_once "../../../lib/functions.php";

$title = 'Edit Data Jurusan';

include_once "../../templates/header.php";

$slug = $_GET['slug'];

$stmt = mysqli_prepare($mysqli, "SELECT * FROM jurusan where slug = ?");
mysqli_stmt_bind_param($stmt, 's', $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$jurusan = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$jurusan) {
  echo "<center>Data Jurusan tidak ditemukan</center>";
  exit;
}

$oldValues = isset($_SESSION['oldValues']) ? $_SESSION['oldValues'] : $jurusan;

unset($_SESSION['oldValues']);

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/majors">Jurusan</a></li>
    <li class="breadcrumb-item active">Ubah</li>
  </ol>

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Ubah Data Jurusan</div>
            <form action="<?= BASE_URL_ADMIN . "/majors/" . $slug . "/update"; ?>" method="POST">
              <div class="card-body">
                <?= csrf($_SESSION['csrf_token']);  ?>
                <br>
                <input type="hidden" name="slug" value="<?= $oldValues['slug']; ?>">
                <input type="hidden" name="id" value="<?= $oldValues['id']; ?>">
                <div class="form-group">
                  <label for="major-name">Nama Jurusan</label>
                  <input class="form-control <?= isset($errors['major-name']) ? 'is-invalid' : ''; ?>" id="major-name" type="text" name="major-name" value="<?= isset($oldValues['name']) ? $oldValues['name'] : ''; ?>">
                  <?php if (isset($errors['major-name'])) : ?>
                    <div class="invalid-feedback"><?= $errors['major-name']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="quota">Kuota</label>
                  <input class="form-control <?= isset($errors['quota']) ? 'is-invalid' : ''; ?>" id="quota" type="number" min="1" name="quota" value="<?= isset($oldValues['quota']) ? $oldValues['quota'] : ''; ?>">
                  <?php if (isset($errors['quota'])) : ?>
                    <div class="invalid-feedback"><?= $errors['quota']; ?></div>
                  <?php endif; ?>
                </div>
                <div class="row align-items-center mt-3">
                  <div class="col-sm-6">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Simpan</button>
                  </div>
                  <div class="col-sm-6">
                    <a class="btn btn-outline-info btn-lg btn-block" href="<?= BASE_URL_ADMIN ?>/majors">Batal</a>
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

<script>
  const majorName = document.querySelector('#major-name');
  const quota = document.querySelector('#quota');

  majorName.addEventListener("keyup", function() {
    if (this.value.length >= 2) {
      this.classList.remove("is-invalid");
    }
  });

  quota.addEventListener('input', function() {
    if (this.value.length > 3) this.value = this.value.slice(0, 3);
    this.value = this.value.replace(/[^0-9]/g, '');

    // Input tidak boleh ada angka 0 di depan
    if (this.value.length > 1 && this.value[0] == 0) {
      this.value = this.value.slice(1, this.value.length);
    }
  })

  quota.addEventListener('change', function() {
    if (this.value < 1)
      this.value = 1;
  })

  quota.addEventListener("keyup", function() {
    if (this.value >= 1 && this.value <= 999) {
      this.classList.remove("is-invalid");
    }
  });
</script>

<?php include "../../templates/footer.php"; ?>
