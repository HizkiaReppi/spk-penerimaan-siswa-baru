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

header("Content-type: application/vnd-ms-excel");

if ($id_jurusan == 'all') {
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
            <th>Jurusan Yang Didaftar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        if ($id_jurusan == 'all') {
            $tampilpeserta = mysqli_query($mysqli, "SELECT no_pendaftaran, nisn, email, name AS nama_peserta, asal_sekolah, id_jurusan FROM peserta");
        } else {
            $stmt = mysqli_prepare($mysqli, "SELECT no_pendaftaran, nisn, email, p.name AS nama_peserta, asal_sekolah, j.name AS nama_jurusan FROM peserta p INNER JOIN jurusan j ON p.id_jurusan=j.id WHERE p.id_jurusan = ?");
            mysqli_stmt_bind_param($stmt, "s", $id_jurusan);
            mysqli_stmt_execute($stmt);
            $tampilpeserta = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
        }
        while ($peserta = mysqli_fetch_array($tampilpeserta)) :
            if ($id_jurusan == 'all') :
                $jurusan_peserta = '';
                $tampiljurusan = mysqli_query($mysqli, "SELECT id, name FROM jurusan");
                while ($jurusan = mysqli_fetch_array($tampiljurusan)) {
                    if ($peserta['id_jurusan'] == $jurusan['id']) {
                        $jurusan_peserta = $jurusan['name'];
                    }
                }
        ?>
                <tr>
                    <td><?= $peserta['no_pendaftaran']; ?></td>
                    <td><?= $peserta['nisn']; ?></td>
                    <td><?= $peserta['nama_peserta']; ?></td>
                    <td><?= $peserta['email']; ?></td>
                    <td><?= $peserta['asal_sekolah']; ?></td>
                    <td><?= $jurusan_peserta; ?></td>
                </tr>
            <?php else : ?>
                <tr>
                    <td><?= $peserta['no_pendaftaran']; ?></td>
                    <td><?= $peserta['nisn']; ?></td>
                    <td><?= $peserta['nama_peserta']; ?></td>
                    <td><?= $peserta['email']; ?></td>
                    <td><?= $peserta['asal_sekolah']; ?></td>
                    <td><?= $peserta['nama_jurusan']; ?></td>
                </tr>
        <?php endif;
            $rank++;
        endwhile;
        ?>
    </tbody>
</table>
