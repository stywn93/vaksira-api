<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeRegistrationEmailNullable extends Migration
{
    public function up(): void
    {
        $this->forge->modifyColumn('registrations', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->modifyColumn('registrations', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
        ]);
    }
}
