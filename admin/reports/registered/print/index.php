<?php

include "../../../../lib/koneksi.php";

$id_jurusan = $_GET['id_jurusan'];

$stmt = $mysqli->prepare("SELECT name FROM jurusan WHERE id = ?");
$stmt->bind_param("s", $id_jurusan);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
if ($id_jurusan == 0) {
    header("Content-Disposition: attachment; filename=Laporan_Pendaftar_Semua_Jurusan.xls");
} else {
    header("Content-Disposition: attachment; filename=Laporan_Pendaftar_Jurusan_$name.xls");
}
?>
<table border="1">
    <thead>
        <tr>
            <th>No Pendaftaran</th>
            <th>NISN</th>
            <th>Nama Peserta</th>
            <th>Email</th>
            <th>Asal Sekolah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        if ($id_jurusan == 0) {
            $tampilpeserta = mysqli_query($mysqli, "SELECT no_pendaftaran, nisn, p.name as nama_peserta, asal_sekolah FROM peserta p join jurusan j on p.id_jurusan=j.id");
        } else {
            $tampilpeserta = mysqli_query($mysqli, "SELECT no_pendaftaran, nisn, p.name as nama_peserta, asal_sekolah FROM peserta p join jurusan j on p.id_jurusan=j.id where p.id_jurusan = '$id_jurusan'");
        }
        while ($peserta = mysqli_fetch_array($tampilpeserta)) : ?>
            <tr>
                <td><?= $peserta['no_pendaftaran']; ?></td>
                <td><?= $peserta['nisn']; ?></td>
                <td><?= $peserta['nama_peserta']; ?></td>
                <td><?= $peserta['email']; ?></td>
                <td><?= $peserta['asal_sekolah']; ?></td>
            </tr>
        <?php
            $rank++;
        endwhile;
        ?>
    </tbody>
</table>
