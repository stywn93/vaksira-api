<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleRegistrationModel extends Model
{
    protected $table            = 'schedule_registrations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    // protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id_registration',
        'id_schedule',
        'ideal_start_date',
        'ideal_end_date',
        'catchup_start_date',
        'catchup_end_date',
        'last_catchup_start_date',
        'last_catchup_end_date',
        'status',
        'reminder_sent_at'

    ];

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    public function getByRegistrationId(int $idRegistration): array
{
    $query = $this->select([
        'sr.id_registration',
        'sm.antigen_name',
        "DATE_FORMAT(sr.ideal_start_date, '%d %M %Y') AS ideal_start_date",
        "DATE_FORMAT(sr.ideal_end_date, '%d %M %Y') AS ideal_end_date",
        "DATE_FORMAT(sr.catchup_start_date, '%d %M %Y') AS catchup_start_date",
        "DATE_FORMAT(sr.catchup_end_date, '%d %M %Y') AS catchup_end_date",
        "DATE_FORMAT(sr.last_catchup_start_date, '%d %M %Y') AS last_catchup_start_date",
        "DATE_FORMAT(sr.last_catchup_end_date, '%d %M %Y') AS last_catchup_end_date",
        "DATE_FORMAT(sr.reminder_sent_at, '%d %M %Y') AS reminder_sent_at",
        'w_province.nama AS province_name',
        'r.mother_name',
        "DATE_FORMAT(r.dob_baby, '%d %M %Y') AS dob_baby",
        'r.gender_baby',
        'w_district.nama AS district_name',
        'w_subdistrict.nama AS subdistrict_name',
        'w_village.nama AS village_name',
        'r.whatsapp',
        'r.email',
    ])
        ->from('schedule_registrations sr', true)
        ->join('registrations r', 'r.id = sr.id_registration', 'left')
        ->join('schedule_master sm', 'sm.id = sr.id_schedule', 'left')
        ->join('wilayah w_province', 'w_province.kode = r.province', 'left')
        ->join('wilayah w_district', 'w_district.kode = r.district', 'left')
        ->join('wilayah w_subdistrict', 'w_subdistrict.kode = r.subdistrict', 'left')
        ->join('wilayah w_village', 'w_village.kode = r.village', 'left')
        ->where('sr.id_registration', $idRegistration)
        ->get();

    log_message('debug', 'ScheduleRegistrationModel query: ' . (string) $this->db->getLastQuery());

    return $query->getResultArray();
}

}
