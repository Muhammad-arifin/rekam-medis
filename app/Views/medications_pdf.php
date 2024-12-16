<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Obat</title>
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
    <h4>Data Obat :</h4>
    <table>
        <thead>
            <tr>
                <th class="d">ID Obat</th>
                <th>Nama Obat</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($obats as $obat): ?>
            <tr>
                <td class="d"><?= $no++ ?></td>
                <td><?= esc($obat['nama_obat']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
