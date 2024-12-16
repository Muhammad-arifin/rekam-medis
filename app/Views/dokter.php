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
            <h1>Data Dokter</h1>
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
        <div class="search-bar">
        <form action="<?= site_url('dashboard/doctors') ?>" method="get" class="search-form">
            <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Cari Nama Dokter...">
            <button  type="submit">Cari</button>
        </form>
</div>
<div class="actions">
    <a class="button" href="<?= site_url('dashboard/addDoctor') ?>">Tambah Dokter</a>
    <a class="m" href="<?= site_url('dashboard/exportDoctorsToExcel') ?>">Ekspor Ke Excel</a>
    <a class="pdf" href="<?= site_url('dashboard/doctorsPdf') ?>">Tampilkan PDF</a> <!-- Link to PDF generation -->
</div>

        
        <!-- Search Form -->
        
        
        <!-- Doctors Table -->
        <table border="1">
            <thead>
                <tr>
                    <th class="e">ID Dokter</th>
                    <th>Nama Dokter</th>
                    <th class="u">Actions</th> <!-- Kolom untuk tombol edit dan delete -->
                </tr>
            </thead>
            <tbody>
            <?php $no = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
                <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td class="e"><?= $no++ ?></td>
                    <td><?= esc($doctor['nama_dokter']) ?></td>
                    <td>
                        <div class="gabut">
                            <a class="edit" href="<?= site_url('dashboard/editDoctor/' . $doctor['id_dokter']) ?>">Edit</a> |
                            <a class="delete" href="<?= site_url('dashboard/deleteDoctor/' . $doctor['id_dokter']) ?>" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="pagination">
    <?= $pager->simpleLinks('default', 'default_simple') ?>
</div>
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
