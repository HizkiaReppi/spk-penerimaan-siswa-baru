<?php

include_once "../../lib/koneksi.php";

$title = 'Manajemen Peserta';

include_once "../templates/header.php";

$query = "SELECT p.no_pendaftaran, p.nisn, p.name AS nama_peserta, p.asal_sekolah, j.name AS nama_jurusan
          FROM peserta p
          INNER JOIN jurusan j ON p.id_jurusan = j.id";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$tampilpeserta = $stmt->get_result();
$stmt->close();
$mysqli->close();

?>

<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
    <li class="breadcrumb-item active">Peserta</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Data Peserta</div>
            <div class="card-body">
              <div class="col-6 col-sm-4 col-md mb-3 mb-xl-0">
                <a href="<?= BASE_URL_ADMIN ?>/participants/insert/" class="btn btn-primary">
                  <i class="fa fa-plus-circle"></i> Tambah Peserta
                </a>
              </div>
              <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Asal Sekolah</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($peserta = mysqli_fetch_array($tampilpeserta)) : ?>
                    <tr>
                      <td><?= $peserta['no_pendaftaran']; ?></td>
                      <td><?= $peserta['nisn']; ?></td>
                      <td><?= $peserta['nama_peserta']; ?></td>
                      <td><?= $peserta['asal_sekolah']; ?></td>
                      <td><?= $peserta['nama_jurusan']; ?></td>
                      <td>
                        <a href="<?= BASE_URL_ADMIN . "/participants/" . $peserta['no_pendaftaran']; ?>">
                          <button class="btn btn-primary" type="button">
                            <i class="fa fa-file-text"></i>
                          </button>
                        </a>
                        <a href="<?= BASE_URL_ADMIN . "/participants/" . $peserta['no_pendaftaran']; ?>/edit">
                          <button class=" btn btn-success" type="button">
                            <i class="fa fa-pencil"></i>
                          </button>
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('<?= BASE_URL_ADMIN ?>/participants/<?= $peserta['no_pendaftaran']; ?>/destroy')">
                          <i class="fa fa-trash"></i> Hapus
                        </button>
                      </td>
                    </tr>
                  <?php endwhile; ?>
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

<?php include_once "../templates/footer.php"; ?>
