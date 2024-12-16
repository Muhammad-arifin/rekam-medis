<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/edituser.css') ?>">
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
            <h1>Edit Kunjungan</h1>
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
        <div class="isi">
            <form action="<?= site_url('dashboard/visits/update') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_berobat" value="<?= $kunjungan['id_berobat'] ?>">
                <div>
                    <label for="tgl_berobat">Tanggal Berobat:</label>
                    <input type="date" name="tgl_berobat" id="tgl_berobat" value="<?= $kunjungan['tgl_berobat'] ?>" required>
                </div>
                <div>
                    <label for="id_pasien">Nama Pasien:</label>
                    <select class="o" name="id_pasien" id="id_pasien" required>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?= $patient['id_pasien'] ?>" <?= ($patient['id_pasien'] == $kunjungan['id_pasien']) ? 'selected' : '' ?>>
                                <?= $patient['nama_pasien'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="id_dokter">Dokter:</label>
                    <select class="o" name="id_dokter" id="id_dokter" required>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id_dokter'] ?>" <?= ($doctor['id_dokter'] == $kunjungan['id_dokter']) ? 'selected' : '' ?>>
                                <?= $doctor['nama_dokter'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                    <button type="submit">Simpan</button>
                    <br>
            <a href="<?= site_url('dashboard/visits') ?>" class="back-link">Kembali ke Data Kunjungan</a>
            </form>
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