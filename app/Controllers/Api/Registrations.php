<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\RegistrationModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\

class Registrations extends BaseController
{
    public function store(): ResponseInterface
    {
        $json  = $this->request->getJSON(true);
        $input = is_array($json) ? $json : $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rules(), $this->messages());

        if (! $validation->run($input)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Validasi gagal',
                    'errors'  => $validation->getErrors(),
                ]);
        }

        $data = [
            'mother_name'  => $input['motherName'],
            'dob_baby'     => $input['dobBaby'],
            'gender_baby'  => $input['genderBaby'],
            'district'     => $input['district'],
            'subdistrict'  => $input['subdistrict'],
            'village'      => $input['village'],
            'whatsapp'     => $input['whatsapp'],
            'email'        => $input['email'],
        ];

        $model = model(RegistrationModel::class);
        $id    = $model->insert($data);

        if ($id === false) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal menyimpan data',
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => 'success',
                'message' => 'Registrasi berhasil disimpan',
                'data'    => $model->find($id),
            ]);
    }

    public function checkRedundancy(): ResponseInterface
    {
        $json  = $this->request->getJSON(true);
        $input = is_array($json) ? $json : $this->request->getPost();

        $model = model(RegistrationModel::class);
        $id    = $model->checkRedundancy(
            $input['motherName'],
            $input['dobBaby'],
            $input['whatsapp']
        );

        if ($id === false) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal mengambil data',
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => 'success',
                'message' => 'Data Registrasi berhasil diambil',
                'data'    => $id,
            ]);
    }


    // ===========================
    // Rules and Validation Messages

    /**
     * @return array<string, string>
     */
    private function rules(): array
    {
        return [
            'motherName'  => 'required|max_length[100]',
            'dobBaby'     => 'required|valid_date[Y-m-d]',
            'genderBaby'  => 'required|in_list[L,P]',
            'district'    => 'required|max_length[100]',
            'subdistrict' => 'required|max_length[100]',
            'village'     => 'required|max_length[100]',
            'whatsapp'    => 'required|regex_match[/^\+?[0-9]{9,15}$/]',
            'email'       => 'required|valid_email|max_length[150]',
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function messages(): array
    {
        return [
            'motherName'  => ['required' => 'Nama ibu wajib diisi.'],
            'dobBaby'     => ['required' => 'Tanggal lahir bayi wajib diisi.', 'valid_date' => 'Format tanggal lahir bayi harus YYYY-MM-DD.'],
            'genderBaby'  => ['required' => 'Jenis kelamin bayi wajib diisi.', 'in_list' => 'Jenis kelamin bayi harus L atau P.'],
            'district'    => ['required' => 'Kabupaten/Kota wajib diisi.'],
            'subdistrict' => ['required' => 'Kecamatan wajib diisi.'],
            'village'     => ['required' => 'Desa/Kelurahan wajib diisi.'],
            'whatsapp'    => ['required' => 'Nomor WhatsApp wajib diisi.', 'regex_match' => 'Nomor WhatsApp tidak valid.'],
            'email'       => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.'],
        ];
    }

}
