<?php
namespace App\Models;

use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table = 'obat';
    protected $primaryKey = 'id_obat';
    protected $allowedFields = ['nama_obat'];

    public function getDropdown()
    {
        $data = $this->findAll();
        $dropdown = [];

        foreach ($data as $item) {
            $dropdown[$item['id_obat']] = $item['nama_obat'];
        }

        return $dropdown;
    }
}
