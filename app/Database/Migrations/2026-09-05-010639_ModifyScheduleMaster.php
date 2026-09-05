<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyScheduleMaster extends Migration
{
    public function up()
    {
        // 1. Rename column `mutlidose` -> `multidose`
        //    and set its default value to FALSE (0)
        $this->forge->modifyColumn('schedule_master', [
            'mutlidose' => [
                'name'       => 'multidose',
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0, // FALSE
            ],
        ]);
 
        // 2. Set default value NULL for min_age_days, max_age_days, min_interval_days
        $this->forge->modifyColumn('schedule_master', [
            'min_age_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'max_age_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'min_interval_days' => [
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
        // Revert min_age_days, max_age_days, min_interval_days
        // (adjust default back to whatever it originally was, e.g. 0, if needed)
        $this->forge->modifyColumn('schedule_master', [
            'min_age_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'max_age_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'min_interval_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
        ]);
 
        // Revert column name back to `mutlidose`
        $this->forge->modifyColumn('schedule_master', [
            'multidose' => [
                'name'       => 'mutlidose',
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
        ]);
    }
}
