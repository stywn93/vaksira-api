<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFKWilayah extends Migration
{
    public function up()
    {
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
        //
    }
}
