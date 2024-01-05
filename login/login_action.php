<?php
session_start();

include "../lib/koneksi.php";
include "../lib/functions.php";

$email = htmlspecialchars($_POST['email']);
$inputPassword = htmlspecialchars($_POST['password']);

// Gunakan prepared statements untuk mencegah SQL injection
$stmt = $mysqli->prepare("SELECT no_pendaftaran, name, nisn, password FROM peserta WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$checkRows = $result->num_rows;

if ($checkRows > 0 && $checkRows < 2) {
    $data = $result->fetch_assoc();

    // Memverifikasi password dengan password_verify()
    if (password_verify($inputPassword, $data['password'])) {
        $_SESSION['user'] = array(
            'no_pendaftaran' => $data['no_pendaftaran'],
            'name' => $data['name'],
            'nisn' => $data['nisn'],
            'email' => $data['email'],
        );

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        $_SESSION['csrf_token'] = generateCSRFToken();
        $_SESSION['flash_message'] = "Login Berhasil!";
        header("location: " . BASE_URL . "/");
    } else {
        $_SESSION['flash_message'] = "Username atau password salah!";
        header("location:" . BASE_URL . "/login");
        exit;
    }
} else {
    $_SESSION['flash_message'] = "Username atau password salah!";
    header("location:" . BASE_URL . "/login");
    exit;
}
