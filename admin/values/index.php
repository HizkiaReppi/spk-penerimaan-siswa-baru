<?php
include_once "../../lib/koneksi.php";

$title = "Manajemen Nilai";

include_once "../templates/header.php";

$session_admin = $_SESSION['admin'];

$stmt = $mysqli->prepare("SELECT p.no_pendaftaran, p.name AS participant_name, j.name AS major_name, C1, C2, C3, C4, C5 FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id INNER JOIN nilai n ON p.no_pendaftaran = n.no_pendaftaran");
$stmt->execute();
$result = $stmt->get_result();

$tampilkriteria = $mysqli->query("SELECT * FROM kriteria");

?>
<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>/dashboard">Home</a></li>
    <li class="breadcrumb-item active">Nilai</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Data Nilai Peserta</div>
            <div class="card-body">
              <table class="table table-responsive-sm table-striped" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Jurusan</th>
                    <?php while ($kriteria = $tampilkriteria->fetch_assoc()) : ?>
                      <th><?= $kriteria['name']; ?></th>
                    <?php endwhile ?>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  while ($peserta = $result->fetch_assoc()) :
                  ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= $peserta['participant_name']; ?></td>
                      <td><?= $peserta['major_name']; ?></td>
                      <td><?= $peserta['C1']; ?></td>
                      <td><?= $peserta['C2']; ?></td>
                      <td><?= $peserta['C3']; ?></td>
                      <td><?= $peserta['C4']; ?></td>
                      <td><?= $peserta['C5']; ?></td>
                      <td>
                        <a href="<?= BASE_URL_ADMIN ?>/values/<?= $peserta['no_pendaftaran']; ?>/edit">
                          <button class="btn btn-success" type="button">
                            <i class="fa fa-pencil"></i>
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php
                    $i++;
                  endwhile;
                  $stmt->close();
                  $mysqli->close();
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

<?php include_once "../templates/footer.php"; ?>
