<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        h4 { font-size: 20px; padding-top:}
        h1 {text-align: center;}
        .d{width: 90px; text-align: center;}
    </style>
</head>
<body>
<h1>Pusat Kesehatan Medis</h1>
    <h4>Data Pasien :</h4>
    <table>
        <thead>
            <tr>
                <th class="d">ID Pasien</th>
                <th>Nama Pasien</th>
                <th class="d">Jenis Kelamin</th>
                <th class="d">Umur</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($pasien as $p): ?>
            <tr>
                <td class="d"><?= $no++ ?></td>
                <td><?= esc($p['nama_pasien']) ?></td>
                <td class="d"><?= esc($p['jenis_kelamin']) ?></td>
                <td class="d"><?= esc($p['umur']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
