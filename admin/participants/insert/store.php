<?php
session_start();
include "../../../lib/koneksi.php";
include "../../../lib/functions.php";

if (empty($_SESSION['admin'])) {
	echo "<center> Untuk mengakses modul, Anda harus Login<br>";
	echo "<a href=../login><b>LOGIN</b></a></center>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (!isset($_POST['csrf_token'])) {
		header("HTTP/1.1 403 Forbidden");
		echo "403 Forbidden";
		exit;
	}
	// Validasi CSRF token
	$csrf_token = $_POST['csrf_token'];
	if (!validateCSRFToken($csrf_token)) {
		header("HTTP/1.1 403 Forbidden");
		echo "403 Forbidden";
		exit;
	}

	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordConfirm = $_POST['passwordConfirm'];
	$nisn = (int)$_POST['nisn'];
	$nama = $_POST['name'];
	$jurusan = $_POST['jurusan'];
	$asalSekolah = $_POST['asal-sekolah'];
	$uas = (int)$_POST['uas'];
	$gender = $_POST['gender'];
	$birthday = $_POST['birthday'];
	$alamat = $_POST['alamat'];

	// validate data
	$errors = array();

	// validate email
	if (empty($email)) {
		$errors['email'] = "Email harus diisi";
	} elseif (!isDataAvailable($mysqli, 'peserta', 'email', $email)) {
		$errors['email'] = "Email sudah terdaftar, silakan gunakan email lain";
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Format email tidak valid";
	} elseif (!preg_match("/@gmail.com/", $email)) {
		$errors['email'] = "Email harus menggunakan domain @gmail.com";
	}

	// validate password
	if (empty($password)) {
		$errors['password'] = "Password harus diisi";
	} else if (strlen($password) <= 5 || strlen($password) >= 50) {
		$errors['password'] = "Password harus memiliki panjang 5 hingga 50 karakter";
	} else if ($password !== $passwordConfirm) {
		$errors['password'] = "Password dan konfirmasi password tidak cocok";
	}

	if (empty($nisn)) {
		$errors['nisn'] = "NISN harus diisi";
	} elseif (!is_numeric($nisn)) {
		$errors['nisn'] = "NISN harus berupa angka";
	} elseif (!isDataAvailable($mysqli, 'peserta', 'nisn', $nisn)) {
		$errors['nisn'] = "NISN sudah terdaftar, silakan gunakan NISN lain";
	}

	if (empty($nama)) {
		$errors['name'] = "Nama lengkap harus diisi";
	} else if (strlen($nama) <= 2 || strlen($nama) >= 50) {
		$errors['name'] = "Nama lengkap harus memiliki panjang 2 hingga 50 karakter";
	} else if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
		$errors['name'] = "Nama lengkap hanya boleh mengandung huruf";
	}

	// get jurusan using mysqli_prepare

	$tampilJurusan = getAllJurusan($mysqli);
	$jurusanIds = array();
	while ($j = mysqli_fetch_array($tampilJurusan)) {
		array_push($jurusanIds, $j['id']);
	}

	// validate jurusan
	if (empty($jurusan)) {
		$errors['jurusan'] = "Jurusan harus diisi";
	} else if (!in_array($jurusan, $jurusanIds)) {
		$errors['jurusan'] = "Jurusan tidak valid";
	}

	// validate asal sekolah
	if (empty($asalSekolah)) {
		$errors['asal-sekolah'] = "Asal sekolah harus diisi";
	} else if (strlen($asalSekolah) <= 2 || strlen($asalSekolah) >= 50) {
		$errors['asal-sekolah'] = "Asal sekolah harus memiliki panjang 2 hingga 50 karakter";
	}

	// validate nilai ujian nasional
	if (empty($uas)) {
		$errors['uas'] = "Nilai ujian nasional harus diisi";
	} else if (!is_numeric($uas)) {
		$errors['uas'] = "Nilai ujian nasional harus berupa angka";
	} else if ($uas < 0 || $uas > 100) {
		$errors['uas'] = "Nilai ujian nasional harus berada di antara 0 hingga 100";
	}

	// validate jenis kelamin
	if (empty($gender)) {
		$errors['gender'] = "Jenis kelamin harus diisi";
	} else if ($gender != 'L' && $gender != 'P') {
		$errors['gender'] = "Jenis kelamin tidak valid";
	}

	function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	// validate tanggal lahir
	if (empty($birthday)) {
		$errors['birthday'] = "Tanggal lahir harus diisi";
	} else if (!validateDate($birthday)) {
		$errors['birthday'] = "Tanggal lahir tidak valid";
	} else if (strtotime($birthday) > strtotime(date('Y-m-d'))) {
		$errors['birthday'] = "Tanggal lahir tidak boleh lebih dari hari ini";
	} else if (strtotime($birthday) < strtotime(date('Y-m-d', strtotime('-100 years')))) {
		$errors['birthday'] = "Tanggal lahir tidak valid";
	}

	// validate alamat
	if (empty($alamat)) {
		$errors['alamat'] = "Alamat harus diisi";
	} else if (strlen($alamat) <= 2 || strlen($alamat) >= 50) {
		$errors['alamat'] = "Alamat harus memiliki panjang 2 hingga 50 karakter";
	}

	if (!empty($errors)) {
		$_SESSION['errors'] = $errors;

		$_SESSION['old_input'] = array(
			'email' => $email,
			'password' => $password,
			'nisn' => $nisn,
			'name' => $nama,
			'jurusan' => $jurusan,
			'asal-sekolah' => $asalSekolah,
			'uas' => $uas,
			'gender' => $gender,
			'birthday' => $birthday,
			'alamat' => $alamat
		);

		header("Location: " . BASE_URL_ADMIN . "/participants/insert/");
		exit;
	}

	$password = password_hash($password, PASSWORD_DEFAULT);
	$kodePeserta = generateKodePeserta($mysqli);

	// Proses penyimpanan data ke database
	$querySimpan = mysqli_prepare($mysqli, "INSERT INTO peserta (no_pendaftaran, email, password, nisn, id_jurusan, name, jenis_kelamin, tanggal_lahir, alamat, asal_sekolah, nilai_ujian_sekolah) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	mysqli_stmt_bind_param($querySimpan, "sssissssssi", $kodePeserta, $email, $password, $nisn, $jurusan, $nama, $gender, $birthday, $alamat, $asalSekolah, $uas);

	if (mysqli_stmt_execute($querySimpan)) {
		$querynilai = mysqli_prepare($mysqli, "INSERT INTO nilai (no_pendaftaran, C1, C2, C3, C4, C5) VALUES (?, ?, 0, 0, 0, 0)");
		mysqli_stmt_bind_param($querynilai, "si", $kodePeserta, $uas);
		mysqli_stmt_execute($querynilai);
		mysqli_stmt_close($querynilai);

		$querynormalisasi = mysqli_prepare($mysqli, "INSERT INTO normalisasi (no_pendaftaran, C1, C2, C3, C4, C5) VALUES (?, 0, 0, 0, 0, 0)");
		mysqli_stmt_bind_param($querynormalisasi, "s", $kodePeserta);
		mysqli_stmt_execute($querynormalisasi);
		mysqli_stmt_close($querynormalisasi);

		$_SESSION['flash_message'] = 'Data Peserta Berhasil Disimpan!';
		header("Location: " . BASE_URL_ADMIN . "/participants");
	} else {
		$_SESSION['flash_message'] = 'Data Peserta Gagal Disimpan!';
		header("Location: " . BASE_URL_ADMIN . "/participants");
	}
}
