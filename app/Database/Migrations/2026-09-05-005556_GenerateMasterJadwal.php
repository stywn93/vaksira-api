<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GenerateMasterJadwal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'antigen_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'min_age_days' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'max_age_days' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'min_interval_days' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'mutlidose' => [
                'type'       => 'boolean',
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('schedule_master');
    }

    public function down()
    {
        $this->forge->dropTable('schedule_master');
    }
}
