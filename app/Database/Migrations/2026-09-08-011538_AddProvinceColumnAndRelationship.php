<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProvinceColumnAndRelationship extends Migration
{
    public function up()
    {
        // -----------------------------------------------------------------
        // Prasyarat: FK tidak bisa dibuat ke tabel MyISAM. Ubah wilayah jadi
        // InnoDB dulu. Hapus blok ini kalau kamu sengaja mau tetap MyISAM
        // dan menangani validasi relasi di level aplikasi saja.
        // -----------------------------------------------------------------
        $this->db->query('ALTER TABLE wilayah ENGINE = InnoDB');
        $this->forge->dropColumn('registrations', 'province');
 
        // 1. Tambah kolom province
        $this->forge->addColumn('registrations', [
            'province' => [
                'type'       => 'VARCHAR',
                'constraint' => 13,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);
 
        // 2. Pastikan tipe 3 kolom lokasi lain sama persis dengan wilayah.kode
        //    (VARCHAR(13)) — FK mensyaratkan tipe & panjang kolom identik.
        //    PENTING: kalau kolom ini sudah berisi data yang formatnya BUKAN
        //    kode wilayah (misal masih nama teks bebas "Kab. Sukabumi"),
        //    MODIFY ini bisa memotong/merusak data lama, dan ADD CONSTRAINT
        //    di langkah berikutnya akan GAGAL karena nilainya tidak akan
        //    cocok dengan wilayah.kode manapun. Backup & migrasikan datanya
        //    ke format kode dulu sebelum menjalankan ini di data production.
        $this->db->query('
            ALTER TABLE registrations
            MODIFY COLUMN district    VARCHAR(13) NULL,
            MODIFY COLUMN subdistrict VARCHAR(13) NULL,
            MODIFY COLUMN village     VARCHAR(13) NULL
        ');
 
        // 3. Tambah FK untuk keempat kolom lokasi -> wilayah.kode
        //    ON DELETE RESTRICT: cegah hapus baris wilayah yang masih dipakai
        //    ON UPDATE CASCADE : kalau kode wilayah pernah direvisi, ikut terupdate
        // $this->db->query('
        //     ALTER TABLE registrations
        //     ADD CONSTRAINT fk_registrations_province
        //         FOREIGN KEY (province) REFERENCES wilayah(kode)
        //         ON DELETE RESTRICT ON UPDATE CASCADE,
        //     ADD CONSTRAINT fk_registrations_district
        //         FOREIGN KEY (district) REFERENCES wilayah(kode)
        //         ON DELETE RESTRICT ON UPDATE CASCADE,
        //     ADD CONSTRAINT fk_registrations_subdistrict
        //         FOREIGN KEY (subdistrict) REFERENCES wilayah(kode)
        //         ON DELETE RESTRICT ON UPDATE CASCADE,
        //     ADD CONSTRAINT fk_registrations_village
        //         FOREIGN KEY (village) REFERENCES wilayah(kode)
        //         ON DELETE RESTRICT ON UPDATE CASCADE
        // ');
    }

    public function down()
    {
        $this->db->query('
            ALTER TABLE registrations
            DROP FOREIGN KEY fk_registrations_province,
            DROP FOREIGN KEY fk_registrations_district,
            DROP FOREIGN KEY fk_registrations_subdistrict,
            DROP FOREIGN KEY fk_registrations_village
        ');
 
        $this->forge->dropColumn('registrations', 'province');
 
        // Catatan: sengaja tidak mengembalikan wilayah ke MyISAM di sini,
        // karena kalau ada tabel lain yang sudah terlanjur FK ke wilayah,
        // rollback ini bisa gagal. Kembalikan manual kalau memang perlu.
    }
}
