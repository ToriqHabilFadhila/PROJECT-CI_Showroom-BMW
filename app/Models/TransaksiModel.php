<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = ['id_pengguna', 'id_mobil', 'tanggal', 'total_harga', 'status'];

    // Mengaktifkan timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi data
    protected $validationRules = [
        'id_pengguna' => 'required|is_not_unique[users.id_pengguna]',
        'id_mobil' => 'required|is_not_unique[mobil.id_mobil]',
        'tanggal' => 'required|valid_date',
        'total_harga' => 'required|decimal',
        'status' => 'required|in_list[Pending,Completed,Cancelled]',
    ];

    protected $validationMessages = [
        'id_pengguna' => [
            'required' => 'ID Pengguna harus diisi.',
            'is_not_unique' => 'ID Pengguna tidak valid.',
        ],
        'id_mobil' => [
            'required' => 'ID Mobil harus diisi.',
            'is_not_unique' => 'ID Mobil tidak valid.',
        ],
        'tanggal' => [
            'required' => 'Tanggal harus diisi.',
            'valid_date' => 'Tanggal tidak valid.',
        ],
        'total_harga' => [
            'required' => 'Total harga harus diisi.',
            'decimal' => 'Total harga harus berupa angka desimal.',
        ],
        'status' => [
            'required' => 'Status harus diisi.',
            'in_list' => 'Status harus salah satu dari Pending, Completed, atau Cancelled.',
        ],
    ];
}