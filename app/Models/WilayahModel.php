<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    protected $table         = 'wilayah';
    protected $primaryKey    = 'kode';
    protected $useAutoIncrement = false;
    protected $returnType    = 'array';
    protected $allowedFields = ['kode', 'nama'];

    /**
     * Ambil semua provinsi (level teratas = kode tanpa titik sama sekali).
     */
    public function getProvinsi(): array
    {
        return $this->notLike('kode', '.')
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil anak langsung dari sebuah kode wilayah, level apa pun
     * (kabupaten dari provinsi, kecamatan dari kabupaten, desa dari kecamatan).
     *
     * Hierarki disimpan implisit lewat format kode (dipisah titik), jadi
     * "anak langsung" = kode yang diawali "{induk}." DAN jumlah titiknya
     * persis satu lebih banyak dari induknya (bukan cucu/cicit).
     */
    public function getChildren(string $parentKode): array
    {
        $sql = "SELECT kode, nama
                FROM wilayah
                WHERE kode LIKE CONCAT(?, '.%')
                  AND (CHAR_LENGTH(kode) - CHAR_LENGTH(REPLACE(kode, '.', '')))
                      = (CHAR_LENGTH(?) - CHAR_LENGTH(REPLACE(?, '.', '')) + 1)
                ORDER BY nama ASC";

        return $this->db->query($sql, [$parentKode, $parentKode, $parentKode])
                         ->getResultArray();
    }

    /**
     * Validasi format kode wilayah sebelum dipakai di query (angka & titik saja).
     */
    public function isValidKode(string $kode): bool
    {
        return (bool) preg_match('/^[0-9]{1,13}(\.[0-9]+){0,3}$/', $kode);
    }
}
