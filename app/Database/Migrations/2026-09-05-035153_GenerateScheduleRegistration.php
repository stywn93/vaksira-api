<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GenerateScheduleRegistration extends Migration
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
            'id_registration' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_schedule' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'ideal_start_date' => [
                'type' => 'DATE',
            ],
            'ideal_end_date' => [
                'type'       => 'DATE',
            ],
            'catchup_start_date' => [
                'type'       => 'DATE',
            ],
            'catchup_end_date' => [
                'type'       => 'DATE',
            ],
            'last_catchup_start_date' => [
                'type'       => 'DATE',
            ],
            'last_catchup_end_date' => [
                'type'       => 'DATE',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'completed', 'missed'],
            ],
            'reminder_sent_at' => [
                'type'       => 'DATETIME',
                'null' => true,
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
        $this->forge->addForeignKey('id_registration', 'registrations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_schedule', 'schedule_master', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('schedule_registrations');
    }

    public function down()
    {
        $this->forge->dropTable('schedule_registrations');
    }
}
