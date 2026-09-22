<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPublicTokenToRegistrations extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('registrations', [
            'public_token' => [
                'type'       => 'CHAR',
                'constraint' => 32,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);

        $rows = $this->db->table('registrations')
            ->select('id')
            ->where('public_token IS NULL', null, false)
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $this->db->table('registrations')
                ->where('id', $row['id'])
                ->update(['public_token' => bin2hex(random_bytes(16))]);
        }

        $this->forge->addUniqueKey('public_token');
        $this->forge->processIndexes('registrations');
    }

    public function down(): void
    {
        $this->forge->dropColumn('registrations', 'public_token');
    }
}
