<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AttendanceModel;
use App\Models\JobModel;
use App\Models\ReportModel;
use App\Models\UserModel;
use Config\Services;

class ReportController extends BaseController
{
    protected $reportModel, $userModel, $attendanceModel, $jobModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->userModel = new UserModel();
        $this->attendanceModel = new AttendanceModel();
        $this->jobModel = new JobModel();
        helper(['form']);
    }

    public function index()
    {
        $data = [
            'page' => 'report',
            'report' => $this->reportModel
                ->orderBy('DATE(created_report)', 'DESC')
                ->join('users', 'users.userId = reports.user_id')
                ->join('jobs', 'jobs.jobId = reports.job_id')
                ->findAll(),
        ];

        echo view('layouts/pages/admin/report/index', $data);
    }

    public function createSave()
    {
        $rules = [
            'job_id' => 'required',
            'total' => 'required',
            'description' => 'required',
        ];

        if ($this->validate($rules)) {
            $lastData = $this->attendanceModel
            ->where(['user_id' => session()->get('id')])
            ->orderBy('DATE(signin_at)', 'DESC')
            ->first();

            $dataAttendance = [
                'attendanceId' => $lastData['attendanceId'],
                'user_id' => session()->get('id'),
                'is_logged_in' => TRUE,
                'category' => 'hadir',
                'signin_at' => $lastData['signin_at'],
                'signout_at' => date('Y-m-d H:i:s'),
                'created_at' => $lastData['created_at'],
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->attendanceModel->replace($dataAttendance);

            $data = [
                'user_id' => session()->get('id'),
                'job_id' => $this->request->getVar('job_id'),
                'total' => $this->request->getVar('total'),
                'description_report' => $this->request->getVar('description'),
                'created_report' => date('Y-m-d H:i:s'),
            ];

            $this->reportModel->save($data);
            session()->setFlashdata('index', 'Report successfully!');
            return redirect()->to("/user");
        }
    }

    public function detail($id)
    {
        $dataReport = $this->reportModel
            ->where(['reportId' => $id])
            ->join('users', 'users.userId = reports.user_id')
            ->join('jobs', 'jobs.jobId = reports.job_id')
            ->first();

        $data = [
            'page' => 'performance',
            'report' => $dataReport,
        ];

        echo view('layouts/pages/admin/report/detail', $data);
    }

    public function delete($id)
    {
        $this->performanceModel->where(['performanceId' => $id])->delete();
        session()->setFlashdata('success_performance', 'Delete Performance Employee successfully.');
        return redirect()->to('/admin/performance');
    }

    public function reportList()
    {
        $data = [
            'report' => $this->reportModel
                ->orderBy('DATE(created_report)', 'DESC')
                ->where(['reports.user_id' => session()->get('id')])
                ->join('users', 'users.userId = reports.user_id')
                ->join('jobs', 'jobs.jobId = reports.job_id')
                ->findAll(),
        ];

        echo view('layouts/pages/user/report_list/index', $data);
    }

    public function reportDetail($id)
    {
        $dataReport = $this->reportModel
            ->where(['reportId' => $id])
            ->join('users', 'users.userId = reports.user_id')
            ->join('jobs', 'jobs.jobId = reports.job_id')
            ->first();

        $data = [
            'report' => $dataReport,
        ];

        echo view('layouts/pages/user/report_list/detail', $data);
    }
}
