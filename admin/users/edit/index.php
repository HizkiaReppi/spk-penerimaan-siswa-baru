<?php
include "../../../lib/koneksi.php";
include "../../../lib/functions.php";
include "../../templates/header.php";

$sessionUser = $_SESSION['admin'];
$username = $_GET['username'];

// Periksa apakah pengguna telah login sebelum mengakses halaman ini
if (!isset($_SESSION['admin'])) {
  header("location: ../../login/");
  exit;
}

// Periksa apakah pengguna memiliki hak akses untuk mengakses halaman ini
if ($sessionUser['role'] != 'admin' && $sessionUser['username'] != $username) {
  echo "<script>alert('Anda tidak memiliki hak akses untuk mengakses halaman ini'); window.location = '../../dashboard';</script>";
  exit;
}

$stmt = mysqli_prepare($mysqli, "SELECT * FROM admin WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$admin) {
  echo "<center>Data Pengguna tidak ditemukan</center>";
  exit;
}

$oldValues = isset($_SESSION['oldValues']) ? $_SESSION['oldValues'] : $admin;

unset($_SESSION['oldValues']);
?>

<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/users">Pengguna</a></li>
    <li class="breadcrumb-item active">Ubah</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Foto</div>
            <form action="update.php" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <div>
                  <?php if (!empty($admin['photo'])) : ?>
                    <img id="photo_preview" class="img-fluid mb-2" src="<?= $admin['photo']; ?>" alt="Foto Profil <?= $admin['fullname']; ?>">
                  <?php else : ?>
                    <img id="photo_preview" class="img-fluid mb-2">
                  <?php endif; ?>
                </div>
                <div>
                  <input type="file" class="form-control" name="photo_profile" id="photo_profile">
                </div>
              </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Ubah Data Pengguna</div>
            <div class="card-body">
              <?= csrf($_SESSION['csrf_token']); ?>
              <input type="hidden" name="id" value="<?= $oldValues['id']; ?>">
              <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <input class="form-control <?= isset($errors['fullname']) ? 'is-invalid' : ''; ?>" id="fullname" type="text" name="fullname" value="<?= isset($oldValues['fullname']) ? $oldValues['fullname'] : ''; ?>">
                <?php if (isset($errors['fullname'])) : ?>
                  <div class="invalid-feedback"><?= $errors['fullname']; ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="role">Jabatan</label>
                <select class="form-select <?= isset($errors['role']) ? 'is-invalid' : ''; ?>" id="role" name="role">
                  <option value="" disabled>Pilih Jabatan</option>
                  <option value="member" <?= isset($oldValues['role']) && $oldValues['role'] == 'member' ? 'selected' : ''; ?>>Anggota</option>
                  <option value="admin" <?= isset($oldValues['role']) && $oldValues['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
                <?php if (isset($errors['role'])) : ?>
                  <div class="invalid-feedback"><?= $errors['role']; ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control <?= isset($errors['username']) ? 'is-invalid' : ''; ?>" id="username" type="text" name="username" value="<?= isset($oldValues['username']) ? $oldValues['username'] : ''; ?>">
                <?php if (isset($errors['username'])) : ?>
                  <div class="invalid-feedback"><?= $errors['username']; ?></div>
                <?php endif; ?>
              </div>
              <?php if ($sessionUser['username'] == $username || $sessionUser['role'] !== 'admin') : ?>
                <div class="form-group">
                  <label for="old-password">Password Lama</label>
                  <input class="form-control <?= isset($errors['old-password']) ? 'is-invalid' : ''; ?>" id="old-password" type="password" name="old-password">
                  <?php if (isset($errors['old-password'])) : ?>
                    <div class="invalid-feedback"><?= $errors['old-password']; ?></div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <?php if ($sessionUser['username'] == $username || $sessionUser['role'] == 'admin') : ?>
                <div class="form-group">
                  <label for="password">Password Baru</label>
                  <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" id="password" type="password" name="password">
                  <?php if (isset($errors['password'])) : ?>
                    <div class="invalid-feedback"><?= $errors['password']; ?></div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <?php if ($sessionUser['username'] == $username || $sessionUser['role'] !== 'admin') : ?>
                <div class="form-group">
                  <label for="password-confirmation">Konfirmasi Password</label>
                  <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" id="password-confirmation" type="password" name="password-confirmation">
                </div>
              <?php endif; ?>
              <div class="row align-items-center mt-3">
                <div class="col-sm-6">
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Simpan</button>
                </div>
                <div class="col-sm-6">
                  <a class="btn btn-outline-info btn-lg btn-block" href="<?= BASE_URL_ADMIN; ?>/users">Batal</a>
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
  const photo_profile = document.querySelector("#photo_profile");
  const photo_preview = document.querySelector("#photo_preview");

  photo_profile.addEventListener("change", function() {
    const file = new FileReader();
    file.onload = function(e) {
      photo_preview.src = e.target.result;
    }
    file.readAsDataURL(this.files[0]);
  });

  const fullname = document.querySelector("#fullname");
  const role = document.querySelector("#role");
  const password = document.querySelector("#password");

  fullname.addEventListener("keyup", function() {
    if (this.value.length >= 3) {
      this.classList.remove("is-invalid");
    }
  });

  fullname.addEventListener("change", function() {
    const fullnameValue = this.value.split(" ").map(word => word[0].toUpperCase() + word.slice(1)).join(" ");
    fullname.value = fullnameValue;
  });

  role.addEventListener("change", function() {
    if (this.value.length >= 3) {
      this.classList.remove("is-invalid");
    }
  });

  password.addEventListener("keyup", function() {
    if (this.value.length >= 8) {
      this.classList.remove("is-invalid");
    }
  });
</script>

<?php
include "../../templates/footer.php";
?>
