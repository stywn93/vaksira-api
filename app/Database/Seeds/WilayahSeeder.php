<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WilayahSeeder extends Seeder
{
    // Ukuran batch insert. 500-1000 aman untuk default max_allowed_packet MySQL.
    private int $chunkSize = 1000;

    public function run()
    {
        $csvPath = APPPATH . 'Database/Seeds/data/wilayah.csv';

        if (! is_file($csvPath)) {
            echo "File wilayah.csv tidak ditemukan di app/Database/Seeds/data/\n";
            return;
        }

        // Kosongkan dulu supaya seeder aman dijalankan berulang (idempotent)
        $this->db->table('wilayah')->truncate();

        $handle = fopen($csvPath, 'r');
        if ($handle === false) {
            echo "Gagal membuka file wilayah.csv\n";
            return;
        }

        // Lewati baris header (kode,nama)
        fgetcsv($handle);

        $batch     = [];
        $totalRows = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 2) {
                continue;
            }

            $batch[] = [
                'kode' => $row[0],
                'nama' => $row[1],
            ];

            if (count($batch) >= $this->chunkSize) {
                $this->db->table('wilayah')->insertBatch($batch);
                $totalRows += count($batch);
                echo "Insert {$totalRows} baris...\n";
                $batch = [];
            }
        }

        // Sisa baris terakhir yang belum genap satu chunk
        if (! empty($batch)) {
            $this->db->table('wilayah')->insertBatch($batch);
            $totalRows += count($batch);
        }

        fclose($handle);

        echo "Selesai. Total {$totalRows} baris wilayah ter-insert.\n";
    }
}
