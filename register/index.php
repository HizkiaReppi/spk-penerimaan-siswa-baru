<?php
require_once '../lib/koneksi.php';
require_once '../lib/functions.php';

include_once '../templates/header.php';

$tampilJurusan = getAllJurusan($mysqli);
?>

<!-- Features -->

<div class="popular">
  <div class="container">
    <div class="row courses_row justify-content-center">

      <!-- Features Item -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Registrasi Akun</div>
          <form action="daftar_action.php" method="post">
            <div class="card-body">
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" type="text" placeholder="Nama Lengkap" name="name" value="<?= $old_input['nisn'] ?? '' ?>">
                <?php if (isset($errors['name'])) : ?>
                  <div class="invalid-feedback"><?= $errors['name'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="nisn">NISN</label>
                <input class="form-control <?= isset($errors['nisn']) ? 'is-invalid' : '' ?>" id="nisn" type="number" placeholder="NISN" name="nisn" value="<?= $old_input['nisn'] ?? '' ?>">
                <?php if (isset($errors['nisn'])) : ?>
                  <div class="invalid-feedback"><?= $errors['nisn'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select class="form-control <?= isset($errors['gender']) ? 'is-invalid' : '' ?>" id="gender" name="gender">
                  <option value="L" <?= isset($old_input['gender']) && $old_input['gender'] == 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                  <option value="P" <?= isset($old_input['gender']) && $old_input['gender'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
                <?php if (isset($errors['gender'])) : ?>
                  <div class="invalid-feedback"><?= $errors['gender'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="birthday">Tanggal Lahir</label>
                <input class="form-control <?= isset($errors['birthday']) ? 'is-invalid' : '' ?>" id="birthday" type="date" name="birthday" value="<?= $old_input['birthday'] ?? '' ?>">
                <?php if (isset($errors['birthday'])) : ?>
                  <div class="invalid-feedback"><?= $errors['birthday'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat" type="text" placeholder="Alamat" name="alamat" value="<?= $old_input['alamat'] ?? '' ?>">
                <?php if (isset($errors['alamat'])) : ?>
                  <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
                <?php endif; ?>
              </div>
              <hr class="mt-0">
              <div class="form-group">
                <label for="jurusan">Jurusan Yang Akan Dipilih</label>
                <select class="form-select <?= isset($errors['jurusan']) ? 'is-invalid' : '' ?>" id="jurusan" name="jurusan">
                  <?php while ($jurusan = mysqli_fetch_array($tampilJurusan)) : ?>
                    <option value="<?= $jurusan['id']; ?>" <?= (isset($old_input['jurusan']) && $old_input['jurusan'] == $jurusan['id']) ? 'selected' : '' ?>>
                      <?= $jurusan['name']; ?>
                    </option>
                  <?php endwhile; ?>
                </select>
                <?php if (isset($errors['jurusan'])) : ?>
                  <div class="invalid-feedback"><?= $errors['jurusan'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="asal-sekolah">Asal Sekolah</label>
                <input class="form-control <?= isset($errors['asal-sekolah']) ? 'is-invalid' : '' ?>" id="asal-sekolah" type="text" placeholder="Asal Sekolah" name="asal-sekolah" value="<?= $old_input['asal-sekolah'] ?? '' ?>">
                <?php if (isset($errors['asal-sekolah'])) : ?>
                  <div class="invalid-feedback"><?= $errors['asal-sekolah'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="uas">Nilai Ujian Sekolah</label>
                <input class="form-control <?= isset($errors['uas']) ? 'is-invalid' : '' ?>" id="uas" type="number" placeholder="Nilai Ujian Sekolah" name="uas" value="<?= $old_input['uas'] ?? '' ?>">
                <?php if (isset($errors['uas'])) : ?>
                  <div class="invalid-feedback"><?= $errors['uas'] ?></div>
                <?php endif; ?>
              </div>
              <hr class="mt-0">
              <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" type="email" placeholder="Email" name="email" value="<?= $old_input['email'] ?? '' ?>">
                <?php if (isset($errors['email'])) : ?>
                  <div class="invalid-feedback"><?= $errors['email'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" type="password" placeholder="Password" name="password">
                <?php if (isset($errors['password'])) : ?>
                  <div class="invalid-feedback"><?= $errors['password'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="passwordConfirm">Konfirmasi Password</label>
                <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="passwordConfirm" type="password" placeholder="Konfirmasi Password" name="passwordConfirm">
              </div>
              <div class="row align-items-center mt-3">
                <div class="col-sm-6">
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Daftar</button>
                </div>
                <div class="col-sm-6">
                  <a class="btn btn-outline-info btn-lg btn-block" href="<?= BASE_URL; ?>/">Batal</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once '../templates/footer.php'; ?>
