<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/users.css') ?>">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="sidebar">
    <h2>Dashboard</h2>
    <ul>
        <li>
            <!-- Icon for Beranda -->
            <a href="<?= site_url('dashboard') ?>">
                <i class="fas fa-home"></i> Beranda
            </a>
        </li>

        <li class="dropdown">
            <!-- Icon for Master Data -->
            <a href="javascript:void(0)" class="dropbtn">
                <i class="fas fa-database"></i> Master Data
            </a>
            <div class="dropdown-content">
                <a href="<?= site_url('dashboard/users') ?>">
                    <i class="fas fa-user"></i> Data Users
                </a>
                <a href="<?= site_url('dashboard/doctors') ?>">
                    <i class="fas fa-user-md"></i> Data Dokter
                </a>
                <a href="<?= site_url('dashboard/patient') ?>">
                    <i class="fas fa-procedures"></i> Data Pasien
                </a>
                <a href="<?= site_url('dashboard/medications') ?>">
                    <i class="fas fa-pills"></i> Data Obat
                </a>
            </div>
        </li>

        <li>
            <!-- Icon for Kunjungan/Berobat -->
            <a href="<?= site_url('dashboard/visits') ?>">
                <i class="fas fa-hospital"></i> Kunjungan/Berobat
            </a>
        </li>

        <li>
            <!-- Icon for Laporan -->
            <a href="<?= site_url('dashboard/reportVisits') ?>">
                <i class="fas fa-file-alt"></i> Laporan
            </a>
        </li>
    </ul>
</div>

    <div class="content">
        <div class="header">
            <h1>Resep Obat</h1>
            <div class="profile">
                <img src="<?= base_url('images/orang.png') ?>" alt="Profile Photo">
                <div>
                    <a href="<?= site_url('profile') ?>">Profil</a>
                    <form action="<?= base_url('/logout') ?>" method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="logout-button">Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <?php if (isset($groupedPrescriptions) && !empty($groupedPrescriptions)): ?>
        <?php foreach ($groupedPrescriptions as $patient): ?>
            <div class="prescription-info">
                <div class="bro">
                    <div class="label-container">
                        <label for="nama_pasien">Nama Pasien:</label>
                        <span class="value"><?= esc($patient['nama_pasien']); ?></span>
                    </div>
                    <div class="label-container">
                        <label for="umur">Umur:</label>
                        <span class="value"><?= esc($patient['umur']); ?></span>
                    </div>
                </div>
                <div class="actions">
                    <a class="m" href="<?= site_url('dashboard/exportToExcel/' . $id_berobat) ?>" class="btn btn-primary">Export to Excel</a>
                    <a class="pdf" href="<?= site_url('dashboard/exportToPdf/' . $id_berobat) ?>" class="btn btn-primary">Export to PDF</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="e">No</th>
                            <th>Nama Obat</th>
                            <th class="e">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($patient['prescriptions'])): ?>
                            <?php foreach ($patient['prescriptions'] as $index => $prescription): ?>
                                <tr>
                                    <td class="e"><?= $index + 1; ?></td>
                                    <td><?= esc($prescription['nama_obat']); ?></td>
                                    <td class="e"><?= esc($prescription['jumlah']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No prescriptions found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <br>
            </div>
        <?php endforeach; ?>
        <div class="pagination">
        <?= $pager->simpleLinks('default', 'default_simple') ?>
        </div>
    <?php else: ?>
        <p>No prescriptions available.</p>
    <?php endif; ?>

    <a class="bau" href="<?= site_url('dashboard/reportVisits'); ?>">Back to Visits Report</a>
</div>
<script>
        // JavaScript for toggling dropdown
        document.querySelector('.dropbtn').addEventListener('click', function() {
            var dropdownContent = this.nextElementSibling;
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</body>
</html>
