<?php
$databaseHost = 'localhost';
$databaseName = 'db_spk_penerimaan_siswa';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);

define('BASE_URL', 'http://localhost:8080/spk-metode-saw-penerimaan-siswa');
define('BASE_URL_ADMIN', 'http://localhost:8080/spk-metode-saw-penerimaan-siswa/admin');
