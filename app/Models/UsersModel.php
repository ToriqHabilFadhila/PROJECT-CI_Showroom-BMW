<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_pengguna';
    protected $allowedFields = ['nama', 'email', 'password', 'alamat', 'telepon', 'role'];

    // Mengaktifkan timestamps
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi data
    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[50]',
        'email' => 'required|valid_email|is_unique[users.email,id_pengguna]',
        'password' => 'required|min_length[8]|max_length[60]',
        'alamat' => 'required|min_length[5]|max_length[255]',
        'telepon' => 'required|numeric|min_length[10]|max_length[13]',
        'role' => 'required|in_list[admin,user]',
    ];    

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama harus diisi.',
            'min_length' => 'Nama minimal terdiri dari 3 karakter.',
            'max_length' => 'Nama maksimal terdiri dari 50 karakter.'
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email sudah terdaftar.'
        ],
        'password' => [
            'required' => 'Password harus diisi.',
            'min_length' => 'Password minimal terdiri dari 8 karakter.',
            'max_length' => 'Password maksimal terdiri dari 60 karakter.'
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi.',
            'min_length' => 'Alamat minimal terdiri dari 5 karakter.',
            'max_length' => 'Alamat maksimal terdiri dari 255 karakter.'
        ],
        'telepon' => [
            'required' => 'Telepon harus diisi.',
            'numeric' => 'Telepon harus berupa angka.',
            'min_length' => 'Telepon minimal terdiri dari 10 karakter.',
            'max_length' => 'Telepon maksimal terdiri dari 13 karakter.'
        ],
        'role' => [
            'required' => 'Role harus diisi.',
            'in_list' => 'Role harus salah satu dari admin atau user.'
        ],
    ];
}