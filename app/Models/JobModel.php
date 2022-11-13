<?php

namespace App\Models;

use CodeIgniter\Model;

class JobModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "user_id",
        "type_of_work",
        "description",
        "point",
        "is_completed",
        "created_at",
        "updated_at",
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getJob()
    {
        return $this->join('users', 'users.userId = jobs.user_id')->get()->getResultArray();
    }

    public function findJobByUserId($id)
    {
        return $this->select('id')->where("user_id", $id)->findAll();
    }

}