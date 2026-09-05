<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegistrations extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'mother_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'dob_baby' => [
                'type' => 'DATE',
            ],
            'gender_baby' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'district' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'subdistrict' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'village' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'whatsapp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
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
        $this->forge->createTable('registrations');
    }

    public function down(): void
    {
        $this->forge->dropTable('registrations');
    }
}
