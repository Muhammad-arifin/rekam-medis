<?php
namespace App\Models;

use CodeIgniter\Model;

class KunjunganModel extends Model
{
    protected $table = 'kunjungan';
    protected $primaryKey = 'id_berobat';
    protected $allowedFields = ['id_pasien', 'tgl_berobat', 'keluhan_pasien', 'hasil_diagnosa', 'penatalaksanaan'];

    public function getRiwayat($id_pasien)
    {
        return $this->where('id_pasien', $id_pasien)
                    ->findAll();
    }
}
