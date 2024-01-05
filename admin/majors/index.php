<?php

include "../../lib/koneksi.php";
include "../templates/header.php";

$stmt = mysqli_prepare($mysqli, "SELECT * FROM jurusan");
mysqli_stmt_execute($stmt);
$tampiljurusan = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

?>

<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item active">Jurusan</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Data Jurusan</div>
            <div class="card-body">
              <div class="col-6 col-sm-4 col-md mb-3 mb-xl-0">
                <a href="<?= BASE_URL_ADMIN ?>/majors/insert" class="btn btn-primary">
                  <i class="fa fa-plus-circle"></i> Tambah Jurusan
                </a>
              </div>
              <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Kuota</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  while ($jurusan = mysqli_fetch_array($tampiljurusan)) :
                  ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= $jurusan['name']; ?></td>
                      <td><?= $jurusan['quota']; ?></td>
                      <td>
                        <a href="<?= BASE_URL_ADMIN ?>/majors/<?= $jurusan['slug']; ?>/edit" class="btn btn-success" role="button">
                          <i class="fa fa-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('<?= BASE_URL_ADMIN ?>/majors/<?= $jurusan['slug']; ?>/destroy')">
                          <i class="fa fa-trash"></i> Hapus
                        </button>
                      </td>
                    </tr>
                  <?php
                    $i++;
                  endwhile;
                  ?>
                </tbody>
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
