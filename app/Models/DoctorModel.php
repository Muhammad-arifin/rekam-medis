<?php
namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table = 'doctors';
    protected $primaryKey = 'id_dokter';
    protected $allowedFields = ['nama_dokter']; // Ensure this matches your table's fields

    // Optional: Add validation rules and other configurations
}
