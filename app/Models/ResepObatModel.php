<?php
namespace App\Models;

use CodeIgniter\Model;

class ResepObatModel extends Model
{
    protected $table = 'resep_obat';
    protected $primaryKey = 'id_resep';

    // Specify all fields that can be inserted or updated
    protected $allowedFields = ['id_obat', 'jumlah', 'id_berobat'];

    // Disable timestamps for now
    protected $useTimestamps = false;

    // Define the timestamp fields (if enabled in the future)
  
}
