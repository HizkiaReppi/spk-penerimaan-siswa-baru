<?php

include_once "../../../lib/koneksi.php";
include_once "../../../lib/functions.php";
include_once "../../templates/header.php";


?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/users">Pengguna</a></li>
    <li class="breadcrumb-item active">Baru</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Foto Profile</div>
            <form action="store.php" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div>
                  <img id="photo_preview" class="img-fluid mb-2">
                </div>
                <div>
                  <input type="file" class="form-control" name="photo_profile" id="photo_profile">
                </div>
              </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Tambah Data Pengguna</div>
            <div class="card-body">
              <?= csrf($_SESSION['csrf_token']);  ?>
              <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <input class="form-control <?= isset($errors['fullname']) ? 'is-invalid' : '' ?>" id="fullname" type="text" placeholder="Nama Lengkap" name="fullname" value="<?= isset($old_input['fullname']) ? $old_input['fullname'] : '' ?>">
                <span class="invalid-feedback"><?= isset($errors['fullname']) ? $errors['fullname'] : '' ?></span>
              </div>
              <div class="form-group">
                <label for="role">Jabatan</label>
                <select class="form-select <?= isset($errors['role']) ? 'is-invalid' : '' ?>" id="role" name="role">
                  <option value="">Pilih Jabatan</option>
                  <option value="member" <?= isset($old_input['role']) && $old_input['role'] == 'member' ? 'selected' : '' ?>>Member</option>
                  <option value="admin" <?= isset($old_input['role']) && $old_input['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                <span class="invalid-feedback"><?= isset($errors['role']) ? $errors['role'] : '' ?></span>
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" type="text" placeholder="Username" name="username" value="<?= isset($old_input['username']) ? $old_input['username'] : '' ?>">
                <span class="invalid-feedback"><?= isset($errors['username']) ? $errors['username'] : '' ?></span>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" type="password" placeholder="Password" name="password">
                <span class="invalid-feedback"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
              </div>
              <div class="form-group">
                <label for="password-confirmation">Konfirmasi Password</label>
                <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" placeholder="Konfirmasi Password" id="password-confirmation" type="password" name="password-confirmation">
              </div>
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
  const username = document.querySelector("#username");
  const role = document.querySelector("#role");
  const password = document.querySelector("#password");

  fullname.addEventListener("keyup", function() {
    if (this.value.length >= 3) {
      this.classList.remove("border", "border-danger");
    }
  });

  fullname.addEventListener("change", function() {
    const fullnameValue = this.value.split(" ").map(word => word[0].toUpperCase() + word.slice(1)).join(" ");
    fullname.value = fullnameValue;
  });

  username.addEventListener("keyup", function() {
    if (this.value.length >= 3 && /^[a-zA-Z0-9]+$/.test(this.value)) {
      this.classList.remove("border", "border-danger");
    }
  });

  username.addEventListener("change", function() {
    const usernameValue = this.value.toLowerCase();
    username.value = usernameValue;
  });

  role.addEventListener("change", function() {
    if (this.value.length >= 3) {
      this.classList.remove("border", "border-danger");
    }
  });

  password.addEventListener("keyup", function() {
    if (this.value.length >= 8) {
      this.classList.remove("border", "border-danger");
    }
  });
</script>

<?php include_once "../../templates/footer.php"; ?>
