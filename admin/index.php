<?php
session_start();
include "../lib/koneksi.php";

if (isset($_SESSION['admin'])) {
  header("location: " . BASE_URL_ADMIN . "/dashboard");
}

header("location: " . BASE_URL_ADMIN . "/login");
