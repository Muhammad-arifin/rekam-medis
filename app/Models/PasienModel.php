<?php namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';
    protected $allowedFields = ['nama_pasien', 'jenis_kelamin', 'umur'];

    protected $validationRules = [
        'nama_pasien' => 'required|min_length[3]|max_length[255]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'umur' => 'required|integer'
    ];

    protected $validationMessages = [
        'nama_pasien' => [
            'required' => 'Nama pasien harus diisi',
            'min_length' => 'Nama pasien terlalu pendek',
            'max_length' => 'Nama pasien terlalu panjang'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin harus diisi',
            'in_list' => 'Jenis kelamin tidak valid'
        ],
        'umur' => [
            'required' => 'Umur harus diisi',
            'integer' => 'Umur harus berupa angka'
        ]
    ];
}
