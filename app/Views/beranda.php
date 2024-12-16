<table>
            <thead>
                <tr>
                <th>No</th>
                <th>Tgl Kunjungan</th>
                <th>Nama Pasien</th>
                <th>L/P</th>
                <th>Umur</th>
                <th>Keluhan</th>
                <th>Diagnosa</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($kunjungans as $kunjungan): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($kunjungan['tgl_berobat']) ?></td>
                    <td><?= esc($kunjungan['nama_pasien']) ?></td>
                    <td><?= esc($kunjungan['jenis_kelamin']) ?></td>
                    <td><?= esc($kunjungan['umur']) ?></td>
                    <td><?= esc($kunjungan['keluhan_pasien']) ?></td>
                    <td><?= esc($kunjungan['hasil_diagnosa']) ?></td> 
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>