<?php
session_start();
$admin = $_SESSION['admin'];

if (!isset($_SESSION['admin'])) {
  header("Location: " . BASE_URL_ADMIN . "/login");
  exit;
}

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Management</title>
  <!-- Icons-->

  <link href="<?= BASE_URL_ADMIN; ?>/assets/vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
  <link href="<?= BASE_URL_ADMIN; ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
  <link href="<?= BASE_URL_ADMIN; ?>/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?= BASE_URL_ADMIN; ?>/assets/vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
  <!-- Main styles for this application-->
  <link href="<?= BASE_URL_ADMIN; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= BASE_URL_ADMIN; ?>/assets/css/style.css" rel="stylesheet">
  <link href="<?= BASE_URL_ADMIN; ?>/assets/css/custom.css" rel="stylesheet">
  <link href="<?= BASE_URL_ADMIN; ?>/assets/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
  <!-- Global site tag (gtag.js) - Google Analytics-->
  <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>

  <script src="<?= BASE_URL_ADMIN; ?>/assets/js/sweetalert2.all.min.js"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    // Shared ID
    gtag('config', 'UA-118965717-3');
    // Bootstrap ID
    gtag('config', 'UA-118965717-5');
  </script>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
  <header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <img class="navbar-brand-full" src="<?= BASE_URL_ADMIN; ?>/assets/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
      <img class="navbar-brand-minimized" src="<?= BASE_URL_ADMIN; ?>/assets/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item d-md-down-none nama_admin">
        Halo, <?= $admin['fullname']; ?>
      </li>
      <li class="nav-item dropdown" style="margin-right: 25px">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <img class="img-avatar" src="<?= BASE_URL_ADMIN; ?>/assets/img/avatars/no-profile-picture.png" alt="admin@bootstrapmaster.com">
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header text-center">
            <strong>Account</strong>
          </div>
          <a class="dropdown-item" href="<?= BASE_URL_ADMIN; ?>/users/<?= $admin['username']; ?>/edit">
            <i class="fa fa-user"></i>Profile</a>
          <a class="dropdown-item" href="<?= BASE_URL_ADMIN; ?>/logout">
            <i class="fa fa-lock"></i>Logout</a>
        </div>
      </li>
    </ul>
  </header>
  <div class="app-body">
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/dashboard">
              <i class="nav-icon icon-speedometer"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/users">
              <i class="nav-icon icon-user"></i> Data Pengguna
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/majors">
              <i class="nav-icon icon-graduation"></i> Data Jurusan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/criteria">
              <i class="nav-icon icon-list"></i> Data Kriteria
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/participants">
              <i class="nav-icon icon-people"></i> Data Peserta
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/values">
              <i class="nav-icon icon-pencil"></i> Data Nilai
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/normalization">
              <i class="nav-icon icon-calculator"></i> Normalisasi
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL_ADMIN ?>/reports">
              <i class="nav-icon icon-doc"></i> Laporan
            </a>
          </li>
        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
