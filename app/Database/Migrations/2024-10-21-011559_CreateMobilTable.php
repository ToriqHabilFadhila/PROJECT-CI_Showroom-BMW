<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMobilTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mobil' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'merk' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'model' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'harga' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'spesifikasi' => [
                'type' => 'TEXT',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_mobil', true);
        $this->forge->createTable('mobil');
    }

    public function down()
    {
        $this->forge->dropTable('mobil');
    }
}