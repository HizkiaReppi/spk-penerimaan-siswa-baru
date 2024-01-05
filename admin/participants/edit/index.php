<?php
include_once "../../../lib/koneksi.php";
include_once "../../../lib/functions.php";
include_once "../../templates/header.php";

$no_pendaftaran = $_GET['no_pendaftaran'];

$stmt = $mysqli->prepare("SELECT * FROM peserta where no_pendaftaran = ?");
$stmt->bind_param('s', $no_pendaftaran);
$stmt->execute();
$result = $stmt->get_result();
$peserta = mysqli_fetch_assoc($result);
$stmt->close();

$tampilJurusan = getAllJurusan($mysqli);
$mysqli->close();

$oldValues = isset($_SESSION['old_input']) ? $_SESSION['old_input'] : $peserta;
unset($_SESSION['old_input']);

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/participants">Peserta</a></li>
    <li class="breadcrumb-item active">Ubah</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Ubah Data Peserta</div>
            <form action="update" method="post">
              <div class="card-body">
                <div class="form-group">
                  <?= csrf($_SESSION['csrf_token']); ?>
                  <label for="no_pendaftaran">No Pendaftaran</label>
                  <input class="form-control <?= isset($errors['no_pendaftaran']) ? 'is-invalid' : '' ?>" id="no_pendaftaran" type="text" placeholder="no_pendaftaran" name="no_pendaftaran" value="<?= $oldValues['no_pendaftaran'] ?? '' ?>" readonly>
                  <?php if (isset($errors['no_pendaftaran'])) : ?>
                    <div class="invalid-feedback"><?= $errors['no_pendaftaran'] ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="nisn">NISN</label>
                  <input class="form-control <?= isset($errors['nisn']) ? 'is-invalid' : '' ?>" id="nisn" type="number" placeholder="NISN" name="nisn" value="<?= $oldValues['nisn'] ?? '' ?>">
                  <?php if (isset($errors['nisn'])) : ?>
                    <div class="invalid-feedback"><?= $errors['nisn'] ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="select1">Jurusan</label>
                  <select class="form-control" id="select1" name="jurusan">
                    <?php
                    while ($jurusan = mysqli_fetch_array($tampilJurusan)) :
                      if ($jurusan['id'] == $oldValues['id_jurusan']) : ?>
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
                  <input class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" type="text" placeholder="name" name="name" value="<?= $oldValues['name'] ?? '' ?>">
                  <?php if (isset($errors['name'])) : ?>
                    <div class="invalid-feedback"><?= $errors['name'] ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="gender">Jenis Kelamin</label>
                  <select class="form-control <?= isset($errors['gender']) ? 'is-invalid' : '' ?>" id="gender" name="gender">
                    <option value="L" <?= isset($oldValues['gender']) && $oldValues['gender'] == 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                    <option value="P" <?= isset($oldValues['gender']) && $oldValues['gender'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                  </select>
                  <?php if (isset($errors['gender'])) : ?>
                    <div class="invalid-feedback"><?= $errors['gender'] ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="tanggal_lahir">Tanggal Lahir</label>
                  <input class="form-control <?= isset($errors['tanggal_lahir']) ? 'is-invalid' : '' ?>" id="tanggal_lahir" type="date" name="tanggal_lahir" value="<?= $oldValues['tanggal_lahir'] ?? '' ?>">
                  <?php if (isset($errors['tanggal_lahir'])) : ?>
                    <div class="invalid-feedback"><?= $errors['tanggal_lahir'] ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <input class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat" type="text" placeholder="Alamat" name="alamat" value="<?= $oldValues['alamat'] ?? '' ?>">
                  <?php if (isset($errors['alamat'])) : ?>
                    <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
                  <?php endif; ?>
                </div>
                <hr class="mt-0">
                <div class="form-group">
                  <label for="asal_sekolah">Asal Sekolah</label>
                  <input class="form-control <?= isset($errors['asal_sekolah']) ? 'is-invalid' : '' ?>" id="asal_sekolah" type="text" placeholder="Asal Sekolah" name="asal_sekolah" value="<?= $oldValues['asal_sekolah'] ?? '' ?>">
                  <?php if (isset($errors['asal_sekolah'])) : ?>
                    <div class="invalid-feedback"><?= $errors['asal_sekolah'] ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="nilai_ujian_sekolah">Nilai Ujian Sekolah</label>
                  <input class="form-control <?= isset($errors['nilai_ujian_sekolah']) ? 'is-invalid' : '' ?>" id="nilai_ujian_sekolah" type="number" placeholder="Nilai Ujian Sekolah" name="nilai_ujian_sekolah" value="<?= $oldValues['nilai_ujian_sekolah'] ?? '' ?>">
                  <?php if (isset($errors['nilai_ujian_sekolah'])) : ?>
                    <div class="invalid-feedback"><?= $errors['nilai_ujian_sekolah'] ?></div>
                  <?php endif; ?>
                </div>
                <hr class="mt-0">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" type="email" placeholder="email" name="email" value="<?= $oldValues['email'] ?? '' ?>">
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
                    <a class="btn btn-outline-info btn-lg btn-block" href="<?= BASE_URL_ADMIN ?>/participants">Batal</a>
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
