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
            <h1>Laporan</h1>
            <div class="profile">
                <img src="<?= base_url('images/orang.png') ?>" alt="Profile Photo" class="profile-photo">
                <div>
                    <a href="<?= site_url('profile') ?>">Profil</a>
                    <form action="<?= base_url('/logout') ?>" method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="logout-button">Logout</button>
                    </form>
                </div>
            </div>
        </div>

       

        <!-- Search Form -->
        <div class="pain">
    <form action="<?= site_url('dashboard/reportVisits') ?>" method="get">
    <input type="text" name="search" placeholder="Cari Data Laporan..." value="<?= esc($searchTerm) ?>">
    <button type="submit">Cari</button>
        <input type="date" name="start_date" value="<?= esc($startDate) ?>">
        <input type="date" name="end_date" value="<?= esc($endDate) ?>">

    </form> 
</div>


        <!-- Action Buttons -->
        <div class="actions">
            <a class="m" href="<?= site_url('dashboard/exportVisitsToExcel') ?>">Ekspor ke Excel</a>
            <a class="pdf" href="<?= site_url('dashboard/exportVisitsToPdf') ?>">Tampilan PDF</a>
        </div>

        <table class="report-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Tgl Kunjungan</th>
            <th>Nama Pasien</th>
            <th>L/P</th>
            <th>Umur</th>
            <th>Keluhan</th>
            <th>Diagnosa</th>
            <th class="button-container">Resep Obat</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
        <?php foreach ($kunjungans as $kunjungan): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($kunjungan['tgl_berobat']) ?></td>
                <td><?= esc($kunjungan['nama_pasien']) ?></td>
                <td><?= esc($kunjungan['jenis_kelamin']) ?></td>
                <td><?= esc($kunjungan['umur']) ?></td>
                <td><?= esc($kunjungan['keluhan_pasien']) ?></td>
                <td><?= esc($kunjungan['hasil_diagnosa']) ?></td>
                <td>
                    <?php if (isset($kunjungan['id_berobat'])): ?>
                        <a href="<?= site_url('dashboard/viewPrescriptions/' . $kunjungan['id_berobat']) ?>" class="export-button">Lihat Resep</a>
                    <?php else: ?>
                        <span>Data tidak tersedia</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <div class="pagination">
        <?= $pager->simpleLinks('default', 'default_simple') ?>
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
