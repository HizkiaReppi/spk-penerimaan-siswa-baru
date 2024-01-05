<?php
session_start();

include "../../../lib/koneksi.php";
include "../../../lib/functions.php";

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

	$no_pendaftaran = $_POST['no_pendaftaran'];
	$email = $_POST['email'];
	$password = $_POST['passwordOld'];
	$passwordNew = $_POST['passwordNew'];
	$passwordConfirm = $_POST['passwordConfirm'];
	$nisn = (int)$_POST['nisn'];
	$nama = $_POST['name'];
	$jurusan = $_POST['jurusan'];
	$asalSekolah = $_POST['asal_sekolah'];
	$uas = (int)$_POST['nilai_ujian_sekolah'];
	$gender = $_POST['jenis_kelamin'];
	$birthday = $_POST['tanggal_lahir'];
	$alamat = $_POST['alamat'];

	// validate data
	$errors = array();

	$stmt = $mysqli->prepare("SELECT no_pendaftaran, password FROM peserta where nisn = ?");
	$stmt->bind_param('i', $nisn);
	$stmt->execute();
	$results = $stmt->get_result();
	$peserta = $results->fetch_assoc();
	$stmt->close();

	if ($no_pendaftaran !== $peserta['no_pendaftaran']) {
		$errors['no_pendaftaran'] = "Nomor Pendaftaran tidak dapat diubah";
	}

	// validate email
	if ($email !== $peserta['email']) {
		if (empty($email)) {
			$errors['email'] = "Email harus diisi";
		} elseif (!isDataAvailable($mysqli, 'peserta', 'email', $email)) {
			$errors['email'] = "Email sudah terdaftar, silakan gunakan email lain";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "Format email tidak valid";
		} elseif (!preg_match("/@gmail.com/", $email)) {
			$errors['email'] = "Email harus menggunakan domain @gmail.com";
		}
	}

	// validate password
	if (empty($passwordOld)) {
		$errors['password'] = "Password Lama harus diisi";
	} else if (empty($passwordNew)) {
		$errors['password'] = "Password Baru harus diisi";
	} else if ($passwordOld !== $peserta['password']) {
		$errors['password'] = "Password Lama tidak sesuai!";
	} else if (strlen($passwordNew) <= 5 || strlen($passwordNew) >= 50) {
		$errors['password'] = "Password harus memiliki panjang 5 hingga 50 karakter";
	} else if ($passwordNew !== $passwordConfirm) {
		$errors['password'] = "Password dan konfirmasi password tidak cocok";
	}

	if ($nisn !== $peserta['nisn']) {
		if (empty($nisn)) {
			$errors['nisn'] = "NISN harus diisi";
		} elseif (!is_numeric($nisn)) {
			$errors['nisn'] = "NISN harus berupa angka";
		} elseif (!isDataAvailable($mysqli, 'peserta', 'nisn', $nisn)) {
			$errors['nisn'] = "NISN sudah terdaftar, silakan gunakan NISN lain";
		}
	}

	if (empty($nama)) {
		$errors['name'] = "Nama lengkap harus diisi";
	} else if (strlen($nama) <= 2 || strlen($nama) >= 50) {
		$errors['name'] = "Nama lengkap harus memiliki panjang 2 hingga 50 karakter";
	} else if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
		$errors['name'] = "Nama lengkap hanya boleh mengandung huruf";
	}

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

		header("Location: " . BASE_URL . "/users/edit");
		exit;
	}

	$password = password_hash($passwordNew, PASSWORD_DEFAULT);

	// Proses penyimpanan data ke database
	$querySimpan = mysqli_prepare($mysqli, "UPDATE peserta SET email = ?, password = ?, nisn = ?, id_jurusan = ?, name = ?, jenis_kelamin = ?, tanggal_lahir = ?, alamat = ?, asal_sekolah = ?, nilai_ujian_sekolah = ?");
	mysqli_stmt_bind_param($querySimpan, "ssissssssi", $email, $password, $nisn, $jurusan, $nama, $gender, $birthday, $alamat, $asalSekolah, $uas);

	if (mysqli_stmt_execute($querySimpan)) {
		$id = generateUuid();
		$querynilai = mysqli_prepare($mysqli, "INSERT INTO nilai (id, no_pendaftaran, C1, C2, C3, C4, C5) VALUES (?, ?, ?, 0, 0, 0, 0)");
		mysqli_stmt_bind_param($querynilai, "ssi", $id, $kodePeserta, $uas);
		mysqli_stmt_execute($querynilai);
		mysqli_stmt_close($querynilai);

		$id = generateUuid();
		$querynormalisasi = mysqli_prepare($mysqli, "INSERT INTO normalisasi (id, no_pendaftaran, C1, C2, C3, C4, C5) VALUES (?, ?, 0, 0, 0, 0, 0)");
		mysqli_stmt_bind_param($querynormalisasi, "ss", $id, $kodePeserta);
		mysqli_stmt_execute($querynormalisasi);
		mysqli_stmt_close($querynormalisasi);

		$_SESSION['flash_message'] = 'Data Peserta Berhasil Diubah!';
		header("Location: " . BASE_URL . "/users");
	} else {
		$_SESSION['flash_message'] = 'Data Peserta Gagal Diubah!';
		header("Location: " . BASE_URL . "/users/edit");
	}
}
