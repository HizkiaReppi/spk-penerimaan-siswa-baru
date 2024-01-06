<?php
session_start();

if (isset($_SESSION['flash_message'])) {
  $message = $_SESSION['flash_message'];
  unset($_SESSION['flash_message']);
}

if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
  $errors = $_SESSION['errors'];
  unset($_SESSION['errors']);
}

if (isset($_SESSION['old_input']) && !empty($_SESSION['old_input'])) {
  $old_input = $_SESSION['old_input'];
  unset($_SESSION['old_input']);
}

$title = isset($title) ? $title : 'Sistem Pendukung Keputusan';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <base href="./">
  <title>Sistem Pendukung Keputusan | <?= $title; ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Sistem Pendukung Keputusan">
  <meta name="keywords" content="Sistem Pendukung Keputusan">
  <meta name="author" content="Hizkia Reppi">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL_ADMIN; ?>/assets/vendors/@coreui/icons/css/coreui-icons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL_ADMIN; ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?= BASE_URL_ADMIN; ?>/assets/vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= BASE_URL_ADMIN; ?>/assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?= BASE_URL_ADMIN; ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL_ADMIN; ?>/assets/vendors/pace-progress/css/pace.min.css">
  <link href="<?= BASE_URL_ADMIN; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>/assets/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>/assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>/assets/plugins/OwlCarousel2-2.2.1/animate.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>/assets/styles/main_styles.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>/assets/styles/responsive.css">
  <script src="<?= BASE_URL_ADMIN; ?>/assets/js/sweetalert2.all.min.js"></script>
</head>

<body>
  <div class="super_container">
    <header class="header">
      <div class="top_bar">
        <div class="top_bar_container">
          <div class="container">
            <div class="row">
              <div class="col">
                <div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
                  <ul class="top_bar_contact_list ml-auto">
                    <li>
                      <i class="fa fa-phone" aria-hidden="true"></i>
                      <div>0823-4513-8501</div>
                    </li>
                    <li>
                      <i class="fa fa-envelope-o" aria-hidden="true"></i>
                      <div>hizkiareppi@gmail.com</div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="header_container">
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="header_content d-flex flex-row align-items-center justify-content-start">
                <nav class="main_nav_contaner">
                  <ul class="main_nav">
                    <li class="<?= $title === 'Beranda' ? 'active' : ''; ?>"><a href="<?= BASE_URL; ?>/">Beranda</a></li>
                    <li class="<?= $title === 'Detail Persyaratan' ? 'active' : ''; ?>"><a href="<?= BASE_URL; ?>/information">Info</a></li>
                    <li class="<?= $title === 'Jadwal Ujian' ? 'active' : ''; ?>"><a href="<?= BASE_URL; ?>/schedule">Jadwal</a></li>
                    <li class="<?= $title === 'Hasil Seleksi' ? 'active' : ''; ?>"><a href="<?= BASE_URL; ?>/results">Hasil Seleksi</a></li>
                  </ul>
                  <div class="hamburger menu_mm">
                    <i class="fa fa-bars menu_mm" aria-hidden="true"></i>
                  </div>
                </nav>
                <nav class="ml-auto">
                  <ul class="secondary_nav">
                    <?php if (isset($_SESSION['user'])) : ?>
                      <li class="signup_button"><a href="<?= BASE_URL; ?>/users">Akun Saya</a></li>
                      <li class="login_button"><a href="<?= BASE_URL; ?>/logout">Keluar</a></li>
                    <?php else : ?>
                      <li class="login_button"><a href="<?= BASE_URL; ?>/login">Masuk</a></li>
                      <li class="signup_button"><a href="<?= BASE_URL; ?>/register">Daftar</a></li>
                    <?php endif; ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
      <div class="menu_close_container">
        <div class="menu_close">
          <div></div>
          <div></div>
        </div>
      </div>
      <nav class="menu_nav">
        <ul class="menu_mm">
          <li class="menu_mm"><a href="<?= BASE_URL; ?>/">Beranda</a></li>
          <li class="menu_mm"><a href="<?= BASE_URL; ?>/information">Info</a></li>
          <li class="menu_mm"><a href="<?= BASE_URL; ?>/schedule">Jadwal</a></li>
          <li class="menu_mm"><a href="<?= BASE_URL; ?>/results">Hasil Seleksi</a></li>
        </ul>
      </nav>
    </div>
