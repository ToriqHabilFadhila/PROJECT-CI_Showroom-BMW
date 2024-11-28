<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        // Menambahkan kolom-kolom untuk tabel pembayaran
        $this->forge->addField([
            'id_pembayaran' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'jumlah' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'metode_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
            ],
            'tanggal_pembayaran' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Completed', 'Cancelled'],
                'default' => 'Pending',
            ],
            'bukti_pembayaran' => [ 
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Menambahkan primary key pada id_pembayaran
        $this->forge->addKey('id_pembayaran', true);

        // Membuat tabel pembayaran
        $this->forge->createTable('pembayaran');

        // Menambahkan foreign key pada kolom id_transaksi
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        // Menghapus tabel pembayaran beserta foreign key yang ada
        $this->forge->dropForeignKey('pembayaran', 'pembayaran_id_transaksi_foreign');
        $this->forge->dropTable('pembayaran');
    }
}