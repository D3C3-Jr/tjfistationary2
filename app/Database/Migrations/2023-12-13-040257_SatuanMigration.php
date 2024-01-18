<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SatuanMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'satuan_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'satuan_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('satuan_id', true);
        $this->forge->createTable('satuan');
    }

    public function down()
    {
        $this->forge->dropTable('satuan');
    }
}
