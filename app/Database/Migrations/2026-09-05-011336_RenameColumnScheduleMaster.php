<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameColumnScheduleMaster extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('schedule_master', [
            'min_age_days' => [
                'name'       => 'min_age_months',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'max_age_days' => [
                'name'       => 'max_age_months',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'min_interval_days' => [
                'name'       => 'max_interval_months',
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
            'min_age_months' => [
                'name'       => 'min_age_days',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'max_age_months' => [
                'name'       => 'max_age_days',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'max_interval_months' => [
                'name'       => 'min_interval_days',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
        ]);
    }
}
