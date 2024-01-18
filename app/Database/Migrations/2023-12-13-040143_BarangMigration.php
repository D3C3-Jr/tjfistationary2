<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'barang_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'barang_kode' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'barang_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'barang_id_kategori' => [
                'type'       => 'INT',
            ],
            'barang_id_satuan' => [
                'type'       => 'INT',
            ],
            'barang_stok' => [
                'type'       => 'INT',
            ],
            'barang_harga' => [
                'type'       => 'INT',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('barang_id', true);
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
