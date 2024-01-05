<?php
session_start();
include "../../lib/koneksi.php";
$session_admin = $_SESSION['admin'];
if (isset($_SESSION['admin'])) {
  include "../template/header.php";
?>
  <main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
      <li class="breadcrumb-item"><a href="../akun">Akun</a></li>
      <li class="breadcrumb-item active">Ubah</li>
    </ol>
    <?php
    $tampiladmin = mysqli_query($mysqli, "SELECT * FROM admin where Id_Admin = $session_admin");
    $admin = mysqli_fetch_assoc($tampiladmin)
    ?>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row justify-content-center">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">Foto</div>
              <form action="edit_akun_action.php" method="post">
                <div class="card-body">
                  <!--
                      <div class="row justify-content-center">
                        <div class="col-md-12">
                          <img class="profil" src="../asset/img/avatars/hmmm.png" alt="">
                        </div>
                      </div>
                    -->
                </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">Ubah Data Pengguna</div>
              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" name="id_admin" value="<?php echo $session_admin; ?>">
                  <label for="company">name</label>
                  <input class="form-control" id="company" type="text" name="nama" value="<?php echo $admin['name']; ?>">
                </div>
                <div class="form-group">
                  <label for="company">Username</label>
                  <input class="form-control" id="company" type="text" value="<?php echo $admin['Username']; ?>" name="user">
                </div>
                <div class="form-group">
                  <label for="company">password</label>
                  <input class="form-control" id="company" type="password" value="<?php echo $admin['password']; ?>" name="pass">
                </div>
                <div class="row align-items-center mt-3">
                  <div class="col-sm-6">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Simpan</button>
                  </div>
                  <div class="col-sm-6">
                    <a class="btn btn-outline-info btn-lg btn-block" href="edit_akun.php">Batal</a>
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
<?php
  include "../template/footer.php";
} else {
  header("location: ../login/");
}
?>
