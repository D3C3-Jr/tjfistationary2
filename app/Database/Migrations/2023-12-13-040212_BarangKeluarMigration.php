<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangKeluarMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'barang_keluar_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'barang_keluar_kode' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'barang_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'barang_keluar_jumlah' => [
                'type'           => 'INT',
            ],
            'barang_keluar_tanggal' => [
                'type'           => 'DATE',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
            ],
            'barang_keluar_tanggal' => [
                'type'           => 'DATETIME',
            ],

        ]);
        $this->forge->addKey('barang_keluar_id', true);
        $this->forge->addForeignKey('barang_id', 'barang', 'barang_id');
        $this->forge->createTable('barang_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('barang_keluar');
    }
}
