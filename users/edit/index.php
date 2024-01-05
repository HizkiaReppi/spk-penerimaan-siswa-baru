<?php
include "../../lib/koneksi.php";
include "../../lib/functions.php";
include_once "../../templates/header.php";

if (isset($_SESSION['user'])) {
  $session_user = $_SESSION['user']['no_pendaftaran'];
} else {
  echo "<script>window.location.href='" . BASE_URL . "/login'</script>";
  exit;
}

$stmt = $mysqli->prepare("SELECT no_pendaftaran, email, nisn, p.name AS nama_peserta, j.name AS nama_jurusan, jenis_kelamin, tanggal_lahir, alamat, asal_sekolah, nilai_ujian_sekolah FROM peserta p INNER JOIN jurusan j ON p.id_jurusan = j.id WHERE no_pendaftaran = ?");
$stmt->bind_param("s", $session_user);
$stmt->execute();
$tampilpeserta = $stmt->get_result();
$peserta = $tampilpeserta->fetch_assoc();
$stmt->close();

$tampilJurusan = getAllJurusan($mysqli);

$old_input = isset($old_input) ? $old_input : $peserta;

?>

<div class="popular">
  <div class="section_background parallax-window" data-parallax="scroll" data-image-src="images/courses_background.jpg" data-speed="0.8"></div>
  <div class="container">
    <div class="row courses_row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Ubah Data</div>
          <form action="update.php" method="POST">
            <div class="card-body">
              <div class="form-group">
                <label for="no_pendaftaran">No Pendaftaran</label>
                <input class="form-control <?= isset($errors['no_pendaftaran']) ? 'is-invalid' : '' ?>" id="no_pendaftaran" type="text" placeholder="no_pendaftaran" name="no_pendaftaran" value="<?= $old_input['no_pendaftaran'] ?? '' ?>" readonly>
                <?php if (isset($errors['no_pendaftaran'])) : ?>
                  <div class="invalid-feedback"><?= $errors['no_pendaftaran'] ?></div>
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
                <label for="select1">Jurusan</label>
                <select class="form-control" id="select1" name="jurusan">
                  <?php
                  while ($jurusan = mysqli_fetch_array($tampilJurusan)) :
                    if ($jurusan['id'] == $old_input['id_jurusan']) : ?>
                      <option value="<?= $jurusan['id']; ?>" selected=""><?= $jurusan['name']; ?></option>
                    <?php else : ?>
                      <option value="<?= $jurusan['id']; ?>"><?= $jurusan['name']; ?></option>
                  <?php
                    endif;
                  endwhile;
                  ?>
                </select>
              </div>
              <hr class="mt-0">
              <div class="form-group">
                <label for="name">Nama Peserta</label>
                <input class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" type="text" placeholder="name" name="name" value="<?= $old_input['nama_peserta'] ?? '' ?>">
                <?php if (isset($errors['name'])) : ?>
                  <div class="invalid-feedback"><?= $errors['name'] ?></div>
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
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input class="form-control <?= isset($errors['tanggal_lahir']) ? 'is-invalid' : '' ?>" id="tanggal_lahir" type="date" name="tanggal_lahir" value="<?= $old_input['tanggal_lahir'] ?? '' ?>">
                <?php if (isset($errors['tanggal_lahir'])) : ?>
                  <div class="invalid-feedback"><?= $errors['tanggal_lahir'] ?></div>
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
                <label for="asal_sekolah">Asal Sekolah</label>
                <input class="form-control <?= isset($errors['asal_sekolah']) ? 'is-invalid' : '' ?>" id="asal_sekolah" type="text" placeholder="Asal Sekolah" name="asal_sekolah" value="<?= $old_input['asal_sekolah'] ?? '' ?>">
                <?php if (isset($errors['asal_sekolah'])) : ?>
                  <div class="invalid-feedback"><?= $errors['asal_sekolah'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="nilai_ujian_sekolah">Nilai Ujian Sekolah</label>
                <input class="form-control <?= isset($errors['nilai_ujian_sekolah']) ? 'is-invalid' : '' ?>" id="nilai_ujian_sekolah" type="number" placeholder="Nilai Ujian Sekolah" name="nilai_ujian_sekolah" value="<?= $old_input['nilai_ujian_sekolah'] ?? '' ?>">
                <?php if (isset($errors['nilai_ujian_sekolah'])) : ?>
                  <div class="invalid-feedback"><?= $errors['nilai_ujian_sekolah'] ?></div>
                <?php endif; ?>
              </div>
              <hr class="mt-0">
              <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" type="email" placeholder="email" name="email" value="<?= $old_input['email'] ?? '' ?>">
                <?php if (isset($errors['email'])) : ?>
                  <div class="invalid-feedback"><?= $errors['email'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="passwordOld">Password Lama</label>
                <input class="form-control <?= isset($errors['passwordOld']) ? 'is-invalid' : '' ?>" id="passwordOld" type="password" placeholder="Password Lama" name="passwordOld">
                <?php if (isset($errors['passwordOld'])) : ?>
                  <div class="invalid-feedback"><?= $errors['passwordOld'] ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="passwordNew">Password Baru</label>
                <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="passwordNew" type="password" placeholder="Password Baru" name="passwordNew">
              </div>
              <div class="form-group">
                <label for="passwordConfirm">Konfirmasi Password</label>
                <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="passwordConfirm" type="password" placeholder="Konfirmasi Password" name="passwordConfirm">
              </div>
              <div class="row align-items-center mt-3">
                <div class="col-sm-6">
                  <button class="btn btn-primary btn-lg btn-block" type="submit">Simpan</button>
                </div>
                <div class="col-sm-6">
                  <a class="btn btn-outline-info btn-lg btn-block" href="<?= BASE_URL; ?>/users">Batal</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Footer -->

<?php include_once '../../templates/footer.php' ?>
