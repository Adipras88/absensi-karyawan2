<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AttendanceModel;
use App\Models\CategoryModel;
use App\Models\QRModel;
use CodeIgniter\Config\Services;
use http\Params;

class AttendanceController extends BaseController
{
    protected $attendanceModel, $categoryModel, $qrModel, $session, $today;

    public function __construct()
    {
        helper(['form']);
        $this->attendanceModel = new AttendanceModel();
        $this->categoryModel = new CategoryModel();
        $this->qrModel = new QRModel();
        $this->session = session();
        $this->today = date('Y-m-d');
    }

    public function index()
    {
        $attedance = $this->attendanceModel
            ->join('users', 'users.userId = attendances.user_id', 'left')
            ->findAll();

        $entry_absent = $attedance ? date_format(date_create($attedance[0]['signin_at']), 'Hi') : null;
        $late = (int)$entry_absent <= 8000;

        $data = [
            'page' => 'attendance',
            'attendance' => $attedance,
            'late' => $late,
        ];

        echo view('layouts/pages/attendance/index', $data);
    }

    public function getQrCode()
    {
        $qrToday = $this->qrModel->where('DATE(created_at)', $this->today)->first();
        $data = [
            'qrToday' => $qrToday ? $qrToday['file'] : null
        ];

        echo view('layouts/pages/User/qrcode/index', $data);
    }

    public function permission()
    {
        $user = $this->attendanceModel->where(['DATE(signin_at)' => $this->today, 'user_id' => session()->get('id')])->first();

        $data = [
            'validation' => Services::validation(),
            'category' => $this->categoryModel->findAll(),
            'status' => $user['status'] ?? null
        ];

        echo view('layouts/pages/User/permission/index', $data);
    }

    public function permissionSave()
    {
        helper(['form']);
        $rules = [
            'category' => 'required',
            'description' => 'required',
        ];

        if ($this->validate($rules)) {

            $dataUserProofFile = $this->request->getFile('user_proof_file');
            $fileName = $dataUserProofFile->getRandomName();
            $dataUserProofFile->move('assets/media/berkas', $fileName);

            $data = [
                'user_id' => session()->get('id'),
                'category' => $this->request->getVar('category'),
                'description' => $this->request->getVar('description'),
                'user_proof_file' => $fileName,
                'is_logged_in' => TRUE,
                'status' => 'PENDING',
                'signin_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->attendanceModel->save($data);

            // TBD
            session()->setFlashdata('success_absent', 'Permission submit successfully!');
            return redirect()->to('/user/absent');
        } else {
            $validation = Services::validation();
            return redirect()->to('/user/permission')->withInput()->with('validation', $validation);
        }
    }

    public function scanner()
    {
        $today = date('Y-m-d');
        $qrToday = $this->qrModel->where('DATE(created_at)', $today)->first();

        $data = [
            'qrToday' => $qrToday['content'] ?? null,
        ];

        echo view('layouts/pages/User/scan/index', $data);
    }

    public function scannerSave()
    {
        helper(['form']);
        $data = [
            'user_id' => session()->get('id'),
            'is_logged_in' => TRUE,
            'category' => 'hadir',
            'signin_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->attendanceModel->save($data);

        session()->setFlashdata('success_absent', 'Scan QR Code successfully!');
        return redirect()->to('/user');
    }

    public function changeStatus($id, $status)
    {
        $currentData = $this->attendanceModel->where(['attendanceId' => $id])->first();

        $data = [
            'attendanceId' => $id,
            'user_id' => $currentData['user_id'],
            'category' => $currentData['category'],
            'description' => $currentData['description'],
            'user_proof_file' => $currentData['user_proof_file'],
            'is_logged_in' => TRUE,
            'status' => $status === 'approved' ? 'APPROVED' : 'REJECTED',
            'signin_at' => $currentData['signin_at'],
            'created_at' => $currentData['created_at'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->attendanceModel->replace($data);

        if ($status === 'approved') {
            session()->setFlashdata('success_change_status', "Approve Data successfully.");
        } else {
            session()->setFlashdata('success_change_status', "Reject Data successfully.");
        }

        return redirect()->to("/admin/attendance");
    }

    public function delete($id)
    {
        $this->attendanceModel->where(['attendanceId' => $id])->delete();
        session()->setFlashdata('success_change_status', 'Delete Attendance successfully.');
        return redirect()->to('/admin/attendance');
    }

    public function presence()
    {
        $presence = $this->attendanceModel
            ->where(['user_id' => session()->get('id')])
            ->orderBy('DATE(created_at)', 'DESC')
            ->findAll();

        $data = [
            'presence' => $presence,
        ];

        echo view('layouts/pages/user/presence/index', $data);
    }
}
