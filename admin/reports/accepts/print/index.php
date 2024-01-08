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

$stmtPeserta = $mysqli->prepare("SELECT no_pendaftaran, p.name as nama_peserta, j.name as nama_jurusan, asal_sekolah, nilai_akhir FROM peserta p join jurusan j on p.id_jurusan=j.id where p.id_jurusan = ? ORDER BY nilai_akhir DESC");
$stmtPeserta->bind_param("s", $id_jurusan);
$stmtPeserta->execute();
$tampilpeserta = $stmtPeserta->get_result();
$stmtPeserta->close();

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=Laporan_Diterima_Jurusan_$name.xls");

?>
<table border="1">
    <thead>
        <tr>
            <th>Ranking</th>
            <th>No Pendaftaran</th>
            <th>Nama Peserta</th>
            <th>Jurusan</th>
            <th>Asal Sekolah</th>
            <th>Nilai Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        while ($peserta = mysqli_fetch_array($tampilpeserta)) :
        ?>
            <tr>
                <td><?= $rank; ?></td>
                <td><?= $peserta['no_pendaftaran']; ?></td>
                <td><?= $peserta['nama_peserta']; ?></td>
                <td><?= $peserta['nama_jurusan']; ?></td>
                <td><?= $peserta['asal_sekolah']; ?></td>
                <td><?= $peserta['nilai_akhir']; ?></td>
            </tr>
        <?php
            $rank++;
        endwhile
        ?>
    </tbody>
</table>
