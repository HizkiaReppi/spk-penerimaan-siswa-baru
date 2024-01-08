<?php
include_once "../../lib/koneksi.php";

$title = "Laporan";

include_once "../templates/header.php";

$tampiljurusan = mysqli_query($mysqli, "SELECT * from jurusan");

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN; ?>/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan</li>
    <!-- Breadcrumb Menu-->
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <i class="fa icon-doc"></i> Laporan Diterima
            </div>
            <div class="card-body">
              <div class="list-group">
                <?php while ($jurusan = mysqli_fetch_array($tampiljurusan)) : ?>
                  <a class="list-group-item list-group-item-action list-group-item-info" href="<?= BASE_URL_ADMIN; ?>/reports/accepts/<?= $jurusan['id']; ?>">
                    <?= $jurusan['name']; ?>
                  </a>
                <?php endwhile; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <i class="fa icon-doc"></i> Laporan Pendaftar
            </div>
            <div class="card-body">
              <div class="list-group">
                <?php
                $tampiljurusan = mysqli_query($mysqli, "SELECT * from jurusan");
                while ($jurusan = mysqli_fetch_array($tampiljurusan)) :
                ?>
                  <a class="list-group-item list-group-item-action list-group-item-info" href="<?= BASE_URL_ADMIN; ?>/reports/registered/<?= $jurusan['id']; ?>">
                    <?= $jurusan['name']; ?>
                  </a>
                <?php endwhile; ?>
                <a class="list-group-item list-group-item-action list-group-item-info" href="<?= BASE_URL_ADMIN; ?>/reports/registered/all/">Semua Jurusan</a>
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
<?php include_once "../templates/footer.php"; ?>
