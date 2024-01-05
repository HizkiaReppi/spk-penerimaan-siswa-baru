<?php
include "../../lib/koneksi.php";
include "../templates/header.php";

$session_admin = $_SESSION['admin'];
?>
  <main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
      <li class="breadcrumb-item active">Normalisasi</li>
      <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row justify-content-center">
          <div class="col-sm-12 col-xl-6">
            <div class="card">
              <div class="card-header">
                <i class="fa icon-graduation"></i> Jurusan
              </div>
              <div class="card-body">
                <div class="list-group">
                  <?php
                  $tampiljurusan = mysqli_query($mysqli, "SELECT * from jurusan");
                  while ($jurusan = mysqli_fetch_array($tampiljurusan)) {
                  ?>
                    <a class="list-group-item list-group-item-action list-group-item-info" href="<?= BASE_URL_ADMIN . "/normalization/" . $jurusan['id']; ?>">
                      <?= $jurusan['name']; ?>
                    </a>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-->
        </div>
        <!-- /.row-->
      </div>
    </div>
  </main>
<?php
  include "../templates/footer.php";
?>
