<?php
session_start();

include "../../lib/koneksi.php";
include "../../lib/functions.php";

$username = htmlspecialchars(trim($_POST['username']));
$password = htmlspecialchars(trim($_POST['password']));

// Gunakan prepared statements untuk mencegah SQL injection
$stmt = mysqli_prepare($mysqli, "SELECT username, password, fullname, role FROM admin WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$checkRows = mysqli_stmt_num_rows($stmt);

if ($checkRows >= 1) {
    mysqli_stmt_bind_result($stmt, $username, $hashed_password, $fullname, $role);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $hashed_password)) {
        $_SESSION['admin'] = array(
            'username' => $username,
            'fullname' => $fullname,
            'role' => $role,
        );

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        $_SESSION['csrf_token'] = generateCSRFToken();

        $_SESSION['flash_message'] = "Hallo, Selamat Datang $fullname";
        header("location:" . BASE_URL_ADMIN . "/dashboard");
    } else {
        $_SESSION['flash_message'] = "Username atau password salah!";
        header("location:" . BASE_URL_ADMIN . "/login");
        exit;
    }
} else {
    $_SESSION['flash_message'] = "Username atau password salah!";
    header("location:" . BASE_URL_ADMIN . "/login");
    exit;
}
