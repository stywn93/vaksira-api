<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWilayahDB extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode' => [
                'type'       => 'VARCHAR',
                'constraint' => 13,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);
 
        $this->forge->addPrimaryKey('kode');
 
        // ENGINE=MyISAM sesuai skema asal (data referensi statis, tanpa FK/transaksi)
        $this->forge->createTable('wilayah', true, ['ENGINE' => 'MyISAM']);
 
        // Index tambahan untuk pencarian berdasarkan nama (dibuat terpisah,
        // sama seperti statement CREATE INDEX pada SQL asal)
        $this->db->query('CREATE INDEX wilayah_name_idx ON wilayah (nama)');
    }

    public function down()
    {
        $this->forge->dropTable('wilayah', true);
    }
}
