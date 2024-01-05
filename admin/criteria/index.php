<?php
include "../../lib/koneksi.php";
include "../templates/header.php";

$stmt = mysqli_prepare($mysqli, "SELECT * from kriteria");
mysqli_stmt_execute($stmt);
$tampilkriteria = mysqli_stmt_get_result($stmt);

$stmt = mysqli_prepare($mysqli, "SELECT sum(bobot) as Total from kriteria");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$totalBobot = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

?>

<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item active">Kriteria</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Data Kriteria</div>
            <div class="card-body">
              <!-- <div class="col-6 col-sm-4 col-md mb-3 mb-xl-0">
                <a href="<?= BASE_URL_ADMIN ?>/criteria/insert" class="btn btn-primary">
                  <i class="fa fa-plus-circle"> Tambah Kriteria</i>
                </a>
              </div> -->
              <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  while ($kriteria = mysqli_fetch_array($tampilkriteria)) :
                  ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= $kriteria['name']; ?></td>
                      <td><?= $kriteria['bobot']; ?></td>
                      <td><?= ucfirst($kriteria['jenis']); ?></td>
                      <td>
                        <a href="<?= BASE_URL_ADMIN ?>/criteria/<?= $kriteria['id']; ?>/edit">
                          <button class="btn btn-success" type="button">
                            <i class="fa fa-pencil"></i>
                          </button>
                        </a>
                        <!--<a href="<?= BASE_URL_ADMIN ?>/criteria/<?= $kriteria['id']; ?>/destroy" onClick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>-->
                      </td>
                    </tr>
                  <?php
                    $i++;
                  endwhile;
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="2">Total bobot</th>
                    <th><?= $totalBobot['Total']; ?></th>
                    <th colspan="2"></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- /.row-->
    </div>
  </div>
</main>

<?php include "../templates/footer.php"; ?>
