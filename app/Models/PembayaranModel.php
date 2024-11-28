<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = ['id_transaksi', 'jumlah', 'metode_pembayaran', 'tanggal_pembayaran', 'status', 'bukti_pembayaran'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at'; 
    protected $updatedField  = 'updated_at'; 

    protected $validationRules = [
        'id_transaksi' => 'required|is_not_unique[transaksi.id_transaksi]',
        'jumlah' => 'required|decimal',
        'metode_pembayaran' => 'required|max_length[60]',
        'tanggal_pembayaran' => 'required|valid_date' 
    ];

    public function updateStatusByTransaksi($id_transaksi, $status) {
        $existingPayment = $this->where('id_transaksi', $id_transaksi)->first();
        if (!$existingPayment) {
            throw new \Exception("Pembayaran dengan ID Transaksi $id_transaksi tidak ditemukan.");
        }
        return $this->where('id_transaksi', $id_transaksi)
                    ->set(['status' => $status])
                    ->update();
    }

    protected $validationMessages = [
        'id_transaksi' => [
            'required' => 'ID Transaksi harus diisi.',
            'is_not_unique' => 'ID Transaksi tidak valid.',
        ],
        'jumlah' => [
            'required' => 'Jumlah harus diisi.',
            'decimal' => 'Jumlah harus berupa angka desimal.',
        ],
        'metode_pembayaran' => [
            'required' => 'Metode pembayaran harus diisi.',
            'max_length' => 'Metode pembayaran maksimal 60 karakter.',
        ],
        'tanggal_pembayaran' => [
            'required' => 'Tanggal pembayaran harus diisi.',
            'valid_date' => 'Tanggal tidak valid.',
        ],
    ];
}