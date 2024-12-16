<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctors List</title>
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
    <h4>Data Dokter :</h1>
    <table>
        <thead>
            <tr>
                <th class="d">ID Dokter</th> <!-- Adding No column -->
                <th>Nama Dokter</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?> <!-- Initialize the counter -->
            <?php foreach ($doctors as $doctor): ?>
            <tr>
                <td class="d"><?= $no++ ?></td> <!-- Display the sequential number -->
                <td><?= esc($doctor['nama_dokter']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
