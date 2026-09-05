<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLastCatchUpColumns extends Migration
{
    public function up()
    {
        $this->forge->addColumn('schedule_master', [
            'min_last_catch_up_months' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'max_last_catch_up_months' => [
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
        $this->forge->dropColumn('schedule_master', ['min_last_catch_up_months', 'max_last_catch_up_months']);
    }
}
