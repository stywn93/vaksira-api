<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCatchupFlag extends Migration
{
    public function up()
    {
        $this->forge->addColumn('schedule_master', [
            'has_catch_up' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
                'null'       => false,
                'default'    => 0,
                'after'      => 'multidose'
            ],
            'has_last_catch_up' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
                'null'       => false,
                'default'    => 0,
                'after'      => 'max_catch_up_months'
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('schedule_master', ['has_catch_up', 'has_last_catch_up']);
    }
}
