<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        h4 { font-size: 20px; padding-top:}
        h1 {text-align: center;}
        .d{width: 90px; text-align: center;}
        .a{width: 150px; text-align: center;}
        .i{ text-align: center;}
        .e{width: 20px; text-align: center;}


    </style>
</head>
<body>
<h1>Pusat Kesehatan Medis</h1>
    <h4>Laporan Kunjungan :</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="d">Tgl Kunjungan</th>
                <th class="a">Nama Pasien</th>
                <th class="i">L/P</th>
                <th class="e">Umur</th>
                <th class="i">Keluhan</th>
                <th class="i">Diagnosa</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($kunjungans as $kunjungan): ?>
            <tr>
                <td class="i"><?= $no++ ?></td>
                <td><?= esc($kunjungan['tgl_berobat']) ?></td>
                <td><?= esc($kunjungan['nama_pasien']) ?></td>
                <td class="i"><?= esc($kunjungan['jenis_kelamin']) ?></td>
                <td class="e"><?= esc($kunjungan['umur']) ?></td>
                <td><?= esc($kunjungan['keluhan_pasien']) ?></td>
                <td><?= esc($kunjungan['hasil_diagnosa']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
