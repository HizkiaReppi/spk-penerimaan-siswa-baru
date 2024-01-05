<?php
session_start();

include "./lib/koneksi.php";

unset($_SESSION['user']);
session_destroy();


header("location: " . BASE_URL . "/login");
