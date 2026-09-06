<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVaccineSequence extends Migration
{
    public function up()
    {
        $this->forge->addColumn('schedule_master', [
            'vaccine_sequence' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'     => 'antigen_name',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('schedule_master', ['vaccine_sequence']);
    }
}
