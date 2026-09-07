<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Wilayah extends BaseController
{
    use ResponseTrait;

    protected WilayahModel $wilayahModel;

    public function __construct()
    {
        $this->wilayahModel = new WilayahModel();
    }

    /**
     * GET /api/wilayah/provinsi
     */
    public function provinsi(): ResponseInterface
    {
        return $this->respond([
            'status' => 'success',
            'data'   => $this->wilayahModel->getProvinsi(),
        ]);
    }

    /**
     * GET /api/wilayah/anak?kode=32
     * GET /api/wilayah/anak?kode=32.73
     * GET /api/wilayah/anak?kode=32.73.01
     *
     * Satu endpoint generik untuk kabupaten/kecamatan/desa — levelnya
     * ditentukan otomatis dari panjang (jumlah titik) kode induk yang dikirim,
     * jadi tidak perlu endpoint terpisah per level.
     */
    public function anak(): ResponseInterface
    {
        $kode = $this->request->getGet('kode');

        if (empty($kode) || ! $this->wilayahModel->isValidKode($kode)) {
            return $this->failValidationErrors(
                'Parameter "kode" wajib diisi dan harus berupa kode wilayah yang valid.'
            );
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $this->wilayahModel->getChildren($kode),
        ]);
    }
}
