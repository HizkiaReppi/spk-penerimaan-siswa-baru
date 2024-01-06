<?php

include "../../lib/koneksi.php";

$title = 'Manajemen User';

include "../templates/header.php";

$session_admin = $_SESSION['admin'];

$stmt = $mysqli->prepare("SELECT * FROM admin");
$stmt->execute();
$tampiladmin = $stmt->get_result();

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item active">Pengguna</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Data Pengguna</div>
            <div class="card-body">
              <?php if ($session_admin['role'] === 'admin') : ?>
                <div class="col-6 col-sm-4 col-md mb-3 mb-xl-0">
                  <a href="<?= BASE_URL_ADMIN ?>/users/insert/" class="btn btn-primary">
                    <i class="fa fa-plus-circle mr-1"></i>
                    Tambah Pengguna
                  </a>
                </div>
              <?php endif; ?>
              <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Jabatan</th>
                    <?php if ($session_admin['role'] === 'admin') : ?>
                      <th>Aksi</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  while ($admin = $tampiladmin->fetch_array()) :
                  ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= $admin['fullname']; ?></td>
                      <td><?= $admin['username']; ?></td>
                      <td><?= ucfirst($admin['role']); ?></td>
                      <?php if ($session_admin['role'] === 'admin') : ?>
                        <td>
                          <a href="<?= BASE_URL_ADMIN ?>/users/<?= $admin['username']; ?>/edit">
                            <button class="btn btn-success" type="button">
                              <i class="fa fa-pencil"></i>
                            </button>
                          </a>
                          <button type="button" class="btn btn-danger" onclick="confirmDelete('<?= BASE_URL_ADMIN ?>/users/<?= $admin['username']; ?>/destroy')">
                            <i class="fa fa-trash"></i> Hapus
                          </button>
                        </td>
                      <?php endif; ?>
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
<?php
include "../templates/footer.php";
?>
