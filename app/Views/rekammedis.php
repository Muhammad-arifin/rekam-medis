    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
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
                <h1>Rekam Medis</h1>
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
            <div class="container">
        <!-- Biodata Pasien -->
        <a href="<?= site_url('dashboard/visits') ?>" class="back-link">Kembali ke Data Kunjungan</a>

        <section class="biodata">
            <h2>Biodata Pasien</h2>
            <p><strong>Nama Pasien:</strong> <?= esc($pasien['nama_pasien']) ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= esc($pasien['jenis_kelamin']) ?></p>
            <p><strong>Umur:</strong> <?= esc($pasien['umur']) ?> tahun</p>
        </section>

        <!-- Riwayat Berobat -->
        <section class="riwayat-berobat">
            <h2>Riwayat Berobat</h2>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Berobat</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat as $index => $visit): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($visit['tgl_berobat']) ?></td>
                            <td><?= esc($visit['keluhan_pasien']) ?></td>
                            <td><?= esc($visit['hasil_diagnosa']) ?></td>                        
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        

        <!-- Catatan Rekam Medis -->
        <section class="catatan-rekam-medis">
            <h2>Catatan Rekam Medis</h2>
            <ul>
        <li>
        <form action="<?= base_url('dashboard/updateNote') ?>" method="post">
        <input type="hidden" name="id_berobat" value="<?= esc($visit['id_berobat']) ?>">
        <p><strong>Keluhan:</strong> <input type="text" name="keluhan_pasien" value="<?= esc($visit['keluhan_pasien']) ?>"></p>
        <p><strong>Diagnosa:</strong> <input type="text" name="hasil_diagnosa" value="<?= esc($visit['hasil_diagnosa']) ?>"></p>
        <button type="submit">Update</button>
    </form>

        </li>

            </ul>
        </section>
        <section class="resep-obat">
    <h2>Tambah Resep Obat</h2>
    <form action="<?= site_url('/dashboard/addPrescription/' . $id_berobat); ?>" method="post">
        <label for="id_obat">Nama Obat:</label>
        <select name="id_obat" id="id_obat" required>
            <option value="">Pilih Obat</option>
            <?php foreach ($obat_dropdown as $id => $name): ?>
                <option value="<?= $id; ?>"><?= $name; ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="jumlah">Jumlah:</label>
        <input type="number" name="jumlah" id="jumlah" min="1" required>
        
        <button type="submit">Tambah</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($resep_obat)): ?>
                <?php foreach ($resep_obat as $key => $resep): ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $obat_dropdown[$resep['id_obat']] ?? 'Unknown'; ?></td>
                        <td class="i"><?= $resep['jumlah']; ?></td>
                        <td>
                            <form action="<?= site_url('resep_obat/delete/'.$resep['id_resep']); ?>" method="post" style="display:inline;">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No prescriptions added yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
    <?= $pager->simpleLinks('default', 'default_simple') ?>
    </div>
</section>

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
