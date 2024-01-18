<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CostCentreMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cost_centre_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cost_centre_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('cost_centre_id', true);
        $this->forge->createTable('cost_centre');
    }

    public function down()
    {
        $this->forge->dropTable('cost_centre');
    }
}
