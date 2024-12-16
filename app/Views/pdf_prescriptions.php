<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescriptions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            padding-bottom:30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .label-container {
            margin-bottom: 10px;
        }
        .label-container label {
            font-weight: bold;
        }
        .label-container .value {
            font-weight: normal;
        }
        .value{
            font-weight: bold;

        }
        .a{
            text-align: center;
            width: 100px;
        }
    </style>
</head>
<body>
    <h1>Pusat Kesehatan Medis</h1>
    <?php if (isset($groupedPrescriptions) && !empty($groupedPrescriptions)): ?>
        <?php foreach ($groupedPrescriptions as $patient): ?>
            <h3>Nama Pasien: <?= esc($patient['nama_pasien']); ?></h3>
            <div class="label-container">
                <label>Umur Pasien:  <?= esc($patient['umur']); ?></label>
               
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="a">No</th>
                        <th>Nama Obat</th>
                        <th class="a">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patient['prescriptions'] as $index => $prescription): ?>
                        <tr>
                            <td class="a"><?= $index + 1; ?></td>
                            <td><?= esc($prescription['nama_obat']); ?></td>
                            <td class="a"><?= esc($prescription['jumlah']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No prescriptions available.</p>
    <?php endif; ?>
</body>
</html>
