<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KategoriMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kategori_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kategori_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('kategori_id', true);
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}
