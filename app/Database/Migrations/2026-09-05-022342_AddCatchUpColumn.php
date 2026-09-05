<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCatchUpColumn extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('schedule_master', [
            'max_interval_months' => [
                'name'       => 'min_interval_months',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ]
        ]);

        $this->forge->addColumn('schedule_master', [
            'min_catch_up_months' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'max_catch_up_months' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('schedule_master', [
            'min_interval_months' => [
                'name'       => 'max_interval_months',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ]
        ]);
        $this->forge->dropColumn('schedule_master', ['min_catch_up_months', 'max_catch_up_months']);
    }
}
