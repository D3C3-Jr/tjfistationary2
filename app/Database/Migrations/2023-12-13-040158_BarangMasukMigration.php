<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangMasukMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'barang_masuk_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'barang_masuk_kode' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'barang_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'barang_masuk_jumlah' => [
                'type'           => 'INT',
            ],
            'barang_masuk_tanggal' => [
                'type'           => 'DATE',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
            ],
            'barang_masuk_tanggal' => [
                'type'           => 'DATETIME',
            ],

        ]);
        $this->forge->addKey('barang_masuk_id', true);
        $this->forge->addForeignKey('barang_id', 'barang', 'barang_id');
        $this->forge->createTable('barang_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('barang_masuk');
    }
}
