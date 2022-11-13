<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "fullname",
        "ID_PKL",
        "date_of_birth",
        "phone_number",
        "position",
        "level",
        "email",
        "password",
        "school_origin",
        "internship_length",
        "registration_at",
        "created_at",
        "updated_at",
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

    public function getUsersJob($id)
    {
        $jobDetail = $this
        ->join('users', 'users.id = jobs.user_id')
        ->find($id);
        
        return $jobDetail;
    }

    public function findJobByUserId($id)
    {
        $jobDetailByUserId = $this->select('id')->where("user_id", $id)->findAll();
        return $jobDetailByUserId;
    }
}