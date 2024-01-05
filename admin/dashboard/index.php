<?php

include "../../lib/koneksi.php";
include "../templates/header.php";

$stmt = mysqli_prepare($mysqli, "SELECT count(*) as total from peserta");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
$total_peserta = $data['total'];

$stmt = mysqli_prepare($mysqli, "SELECT count(*) as total from admin");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
$total_admin = $data['total'];

$stmt = mysqli_prepare($mysqli, "SELECT count(*) as total from kriteria");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
$total_kriteria = $data['total'];

$stmt = mysqli_prepare($mysqli, "SELECT count(*) as total from jurusan");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
$total_jurusan = $data['total'];
mysqli_stmt_close($stmt);


?>

<main class="main">
  <!-- Breadcrumb-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-6 col-lg-3">
          <div class="card">
            <div class="card-body p-0 d-flex align-items-center">
              <i class="fa fa-users bg-primary p-4 font-2xl mr-3"></i>
              <div>
                <div class="text-value-sm text-primary">
                  <?= $total_peserta; ?>
                </div>
                <div class="text-muted text-uppercase font-weight-bold small">Peserta</div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-->
        <div class="col-6 col-lg-3">
          <div class="card">
            <div class="card-body p-0 d-flex align-items-center">
              <i class="fa fa-graduation-cap bg-info p-4 font-2xl mr-3"></i>
              <div>
                <div class="text-value-sm text-info">
                  <?= $total_jurusan; ?>
                </div>
                <div class="text-muted text-uppercase font-weight-bold small">Jurusan</div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-->
        <div class="col-6 col-lg-3">
          <div class="card">
            <div class="card-body p-0 d-flex align-items-center">
              <i class="fa fa-list-ul bg-warning p-4 font-2xl mr-3"></i>
              <div>
                <div class="text-value-sm text-warning">
                  <?= $total_kriteria; ?>
                </div>
                <div class="text-muted text-uppercase font-weight-bold small">Kriteria</div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-->
        <div class="col-6 col-lg-3">
          <div class="card">
            <div class="card-body p-0 d-flex align-items-center">
              <i class="fa fa-user bg-danger p-4 font-2xl mr-3"></i>
              <div>
                <div class="text-value-sm text-danger">
                  <?= $total_admin; ?>
                </div>
                <div class="text-muted text-uppercase font-weight-bold small">Admin</div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Sistem Pendukung Keputusan</div>
            <div class="card-body">
              <p>Selamat datang di dunia canggih Sistem Pendukung Keputusan (SPK) Penerimaan Siswa Baru SMK! Di tengah gemuruh teknologi, kini hadirlah sahabat setia untuk membantu Anda menjalani proses penerimaan siswa dengan sempurna.</p>
              <p>SPK Penerimaan Siswa Baru SMK adalah senjata rahasia yang akan memudahkan Anda mengambil keputusan terbaik dalam menerima calon siswa yang berbakat dan berpotensi. Dengan sentuhan ajaib teknologi dan kecerdasan buatan, SPK ini akan membantu Anda menyusun strategi pintar, menganalisis beragam data, dan menghadirkan calon-calon terbaik untuk masa depan gemilang SMK Anda.</p>
              <p>Sekarang, Anda tak perlu lagi kebingungan dalam menyaring ribuan calon siswa. SPK Penerimaan Siswa Baru SMK akan membantu menyortir dan memilah berdasarkan kriteria yang Anda tetapkan. Dengan cepat dan efisien, SPK akan menampilkan profil calon siswa yang paling cocok dengan misi dan visi SMK Anda.</p>
              <p>Bukan hanya itu, SPK ini juga sangat mudah digunakan! Antarmuka yang sederhana dan interaktif akan membimbing Anda seperti seorang mentor bijaksana. Anda bisa dengan mudah menjelajahi data, menerapkan kriteria, dan melihat hasil analisis secara langsung. </p>
              <p>Tak hanya berbasis pada angka-angka matematis, SPK ini juga memahami arti penting dari kepribadian dan bakat siswa. Dengan kebijaksanaan yang mendalam, SPK akan membantu Anda menggali potensi tersembunyi dari para calon siswa dan membantu mereka meraih mimpi-mimpi mereka.</p>
              <p>Jadi, tak perlu ragu lagi! SPK Penerimaan Siswa Baru SMK adalah mitra terpercaya Anda dalam menjalani proses penerimaan siswa dengan mulus dan cerdas. Dengan SPK ini, masa depan SMK Anda akan semakin berwarna dan berjaya. Mari kita berlalu lintas menuju keputusan yang tepat dan memberikan kesempatan bagi generasi penerus untuk bersinar terang. Selamat menggunakan SPK Penerimaan Siswa Baru SMK!</p>
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
