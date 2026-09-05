<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationModel extends Model
{
    protected $table         = 'registrations';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'mother_name',
        'dob_baby',
        'gender_baby',
        'district',
        'subdistrict',
        'village',
        'whatsapp',
        'email',
    ];
}
