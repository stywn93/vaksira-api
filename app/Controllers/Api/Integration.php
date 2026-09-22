<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ScheduleRegistrationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Integration extends BaseController
{
    public function schedule(string $token): ResponseInterface
    {
        $schedules = model(ScheduleRegistrationModel::class)->getByRegistrationToken($token);

        if ($schedules === []) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Registrasi tidak ditemukan.',
                ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => ['schedules' => $schedules],
        ]);
    }
}
