<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_pengguna' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'id_mobil' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
            ],
            'total_harga' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Completed', 'Cancelled'],
                'default' => 'Pending',
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
        $this->forge->addKey('id_transaksi', true);
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}