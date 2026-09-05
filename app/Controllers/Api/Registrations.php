<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\RegistrationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Registrations extends BaseController
{
    /**
     * POST /api/registrations
     *
     * Body (JSON or form):
     * {
     *   "motherName":  "Fulan",
     *   "dobBaby":     "2010-01-01",
     *   "genderBaby":  "L",
     *   "district":    "Situbondo",
     *   "subdistrict": "Patokan",
     *   "village":     "Dawuhan",
     *   "whatsapp":    "08123456789",
     *   "email":       "user@example.com"
     * }
     */
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
                'data'    => $this->camelCase($model->find($id)),
            ]);
    }

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

    /**
     * Convert snake_case DB columns back to the camelCase API field names.
     *
     * @param array<string, mixed>|null $row
     * @return array<string, mixed>|null
     */
    private function camelCase(?array $row): ?array
    {
        if ($row === null) {
            return null;
        }

        $map = [
            'id'          => 'id',
            'mother_name' => 'motherName',
            'dob_baby'    => 'dobBaby',
            'gender_baby' => 'genderBaby',
            'district'    => 'district',
            'subdistrict' => 'subdistrict',
            'village'     => 'village',
            'whatsapp'    => 'whatsapp',
            'email'       => 'email',
            'created_at'  => 'createdAt',
            'updated_at'  => 'updatedAt',
        ];

        $result = [];
        foreach ($map as $column => $field) {
            if (array_key_exists($column, $row)) {
                $result[$field] = $column === 'id' ? (int) $row[$column] : $row[$column];
            }
        }

        return $result;
    }
}
