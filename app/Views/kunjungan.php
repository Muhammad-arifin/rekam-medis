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
            <h1>Data Kunjungan</h1>
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
         <!-- Search Form -->
         <div class="search-bar">
         <form action="<?= site_url('dashboard/visits') ?>" method="get" class="search-form">
            <input type="bar" name="search" placeholder="Cari Data Kunjungan..." value="<?= esc($search) ?>">
            <button type="submit">Cari</button>
        </form>
</div>
        <div class="actions">
            <a href="<?= site_url('dashboard/visits/add') ?>" class="button">Tambah Kunjungan</a>
        </div>
        
        
        <!-- Table -->
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Umur</th>
                    <th>Dokter</th>
                    <th>Rekam Medis</th>
                    <th class="u">Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php $no = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
    <?php if (empty($kunjungans)): ?>
        <tr>
            <td colspan="7">No records found</td>
        </tr>
    <?php else: ?>
        <?php foreach ($kunjungans as $kunjungan): ?>
            <tr>
                <td><?= $no++ ?></td> <!-- Increment nomor urut di sini -->
                <td><?= date('d-m-Y', strtotime($kunjungan['tgl_berobat'])) ?></td>
                <td><?= $patients[$kunjungan['id_pasien']]['nama_pasien'] ?? 'N/A' ?></td>
                <td><?= $patients[$kunjungan['id_pasien']]['umur'] ?? 'N/A' ?></td>
                <td><?= $doctors[$kunjungan['id_dokter']] ?? 'N/A' ?></td>
                <td class="gabut"><a class="l" href="<?= site_url('dashboard/visits/medical_record/' . $kunjungan['id_berobat']) ?>" class="rekam-medis">Rekam Medis</a></td>
                <td>
                    <div class="gabut">
                        <a class="edit" href="<?= site_url('dashboard/visits/edit/' . $kunjungan['id_berobat']) ?>">Edit</a> |
                        <a class="delete" href="<?= site_url('dashboard/visits/delete/' . $kunjungan['id_berobat']) ?>" onclick="return confirm('Are you sure you want to delete this visit?')">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>

        </table>

        <!-- Pagination Links -->
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
                        