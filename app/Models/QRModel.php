<?php

namespace App\Models;

use CodeIgniter\Model;

class QRModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'qr';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["content", "file", "created_at"];

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

    var $tbl_qr = 'qr';

    /*
    |-------------------------------------------------------------------
    | Fetch All QR Data
    |-------------------------------------------------------------------
    |
    */
    public function fetch_datas()
    {
        $query = $this->get($this->tbl_qr);

        return;
    }

    /*
    |-------------------------------------------------------------------
    | Fetch QR Row Data
    |-------------------------------------------------------------------
    |
    */
    public function fetch_data($id)
    {
        $this->where('id', $id);
        $query = $this->get($this->tbl_qr);

        return;
    }

    /*
    |-------------------------------------------------------------------
    | Insert Data
    |-------------------------------------------------------------------
    |
    | @param $qr  Array QR Data
    |
    */
    public function insert_data($qr)
    {
        $this->insert($qr);
        return;
    }

    /*
    |-------------------------------------------------------------------
    | Update Data
    |-------------------------------------------------------------------
    |
    | @param $id          ID Data
    | @param $old_file    Old QR Image File Path
    | @param $qr          Array New QR Data
    |
    */
    public function update_data($id, $old_file, $qr)
    {
        /* Delete Old QR Image from Directory */
        unlink($old_file);

        /* Update Data from Database */
        $this->trans_start();
        $this->where('id', $id);
        $this->update($this->tbl_qr, $qr);
        $this->trans_complete();
        return;
    }

    /*
    |-------------------------------------------------------------------
    | Delete Data
    |-------------------------------------------------------------------
    |
    | @param $id        ID Data
    | @param $qr_file   QR Image File Path
    |
    */
    public function delete_data($id, $qr_file)
    {
        /* Delete QR Code Image from Directory */
        unlink($qr_file);

        /* Delete QR Code from Database  */
        $this->where('id', $id);
        $this->delete($this->tbl_qr);

        return;
    }

}
