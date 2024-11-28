<?php

namespace App\Models;

use CodeIgniter\Model;

class MobilModel extends Model
{
    protected $table = 'mobil';
    protected $primaryKey = 'id_mobil';
    protected $allowedFields = ['merk', 'model', 'harga', 'spesifikasi', 'gambar', 'created_at', 'updated_at'];

    // Mengaktifkan timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at'; 
    protected $updatedField  = 'updated_at'; 
    // Validasi data
    protected $validationRules = [
        'merk' => 'required|min_length[1]|max_length[50]',
        'model' => 'required|min_length[1]|max_length[50]',
        'harga' => 'required|decimal',
        'spesifikasi' => 'permit_empty', // Menghapus batasan panjang
        'gambar' => 'permit_empty|max_length[255]'
    ];

    protected $validationMessages = [
        'merk' => [
            'required' => 'Merk harus diisi.',
            'min_length' => 'Merk minimal 1 karakter.',
            'max_length' => 'Merk maksimal 50 karakter.',
        ],
        'model' => [
            'required' => 'Model harus diisi.',
            'min_length' => 'Model minimal 1 karakter.',
            'max_length' => 'Model maksimal 50 karakter.',
        ],
        'harga' => [
            'required' => 'Harga harus diisi.',
            'decimal' => 'Harga harus berupa angka desimal.',
        ],
    ];
}