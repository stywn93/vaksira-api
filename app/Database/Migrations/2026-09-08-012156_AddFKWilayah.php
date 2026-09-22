<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFKWilayah extends Migration
{
    public function up()
    {
        $constraints = [
            'fk_registrations_province',
            'fk_registrations_district',
            'fk_registrations_subdistrict',
            'fk_registrations_village',
        ];

        foreach ($constraints as $constraint) {
            $exists = $this->db->query("SELECT 1
                FROM information_schema.REFERENTIAL_CONSTRAINTS
                WHERE CONSTRAINT_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'registrations'
                  AND CONSTRAINT_NAME = '{$constraint}'
                LIMIT 1")->getRow();

            if ($exists) {
                $this->db->query("ALTER TABLE registrations DROP FOREIGN KEY {$constraint}");
            }
        }

        $this->db->query('
            ALTER TABLE registrations
            ADD CONSTRAINT fk_registrations_province
                FOREIGN KEY (province) REFERENCES wilayah(kode)
                ON DELETE RESTRICT ON UPDATE CASCADE,
            ADD CONSTRAINT fk_registrations_district
                FOREIGN KEY (district) REFERENCES wilayah(kode)
                ON DELETE RESTRICT ON UPDATE CASCADE,
            ADD CONSTRAINT fk_registrations_subdistrict
                FOREIGN KEY (subdistrict) REFERENCES wilayah(kode)
                ON DELETE RESTRICT ON UPDATE CASCADE,
            ADD CONSTRAINT fk_registrations_village
                FOREIGN KEY (village) REFERENCES wilayah(kode)
                ON DELETE RESTRICT ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $constraints = [
            'fk_registrations_province',
            'fk_registrations_district',
            'fk_registrations_subdistrict',
            'fk_registrations_village',
        ];

        foreach ($constraints as $constraint) {
            $exists = $this->db->query("SELECT 1
                FROM information_schema.REFERENTIAL_CONSTRAINTS
                WHERE CONSTRAINT_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'registrations'
                  AND CONSTRAINT_NAME = '{$constraint}'
                LIMIT 1")->getRow();

            if ($exists) {
                $this->db->query("ALTER TABLE registrations DROP FOREIGN KEY {$constraint}");
            }
        }
    }
}
