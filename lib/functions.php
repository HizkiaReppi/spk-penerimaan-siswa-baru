<?php
function isDataAvailable($mysqli, $tableName, $column, $value)
{
  $count = 0;
  $stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM $tableName WHERE $column = ?");
  $stmt->bind_param('s', $value);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  return $count == 0;
}

function generateCSRFToken()
{
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function validateCSRFToken($token)
{
  if (empty($_SESSION['csrf_token'])) {
    return false;
  }

  if (hash_equals($_SESSION['csrf_token'], $token)) {
    return true;
  }

  return false;
}

function csrf($token)
{
  return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function isUserLoggedIn()
{
  if (empty($_SESSION['admin'])) {
    return false;
  }

  return true;
}

function createSlug($text)
{
  // Menghapus karakter non-alfanumerik
  $text = preg_replace('/[^a-zA-Z0-9]/', ' ', $text);

  // Mengganti spasi dengan tanda hubung
  $text = str_replace(' ', '-', $text);

  // Mengubah menjadi huruf kecil semua
  $text = strtolower($text);

  // Menghapus tanda hubung berulang
  $text = preg_replace('/-+/', '-', $text);

  // Menghapus tanda hubung di awal dan akhir
  $text = trim($text, '-');

  return $text;
}

function generateUuid(): string
{
  return sprintf(
    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0x0fff) | 0x4000,
    mt_rand(0, 0x3fff) | 0x8000,
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
  );
}

function generateKodePeserta($mysqli): string
{
  $max_kode_pendaftaran = null;
  $stmt = $mysqli->prepare("SELECT MAX(no_pendaftaran) as max_kode_pendaftaran FROM peserta");
  $stmt->execute();
  $stmt->bind_result($max_kode_pendaftaran);
  $stmt->fetch();
  $stmt->close();

  if (empty($max_kode_pendaftaran)) {
    return 'S-0001';
  }

  $max_kode_pendaftaran = (int)substr($max_kode_pendaftaran, 2);
  $max_kode_pendaftaran++;

  return 'S-' . str_pad($max_kode_pendaftaran, 4, '0', STR_PAD_LEFT);
}

function getAllJurusan($mysqli)
{
  $stmt = $mysqli->prepare("SELECT * FROM jurusan");
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  return $result;
}

function dd($variable)
{
  var_dump($variable);
  die;
}
