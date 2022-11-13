<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\EvaluationModel;
use App\Models\JobModel;
use App\Models\ReportModel;
use App\Models\UserModel;
use CodeIgniter\Config\Services;

class UserController extends BaseController
{
    protected $userModel, $jobModel, $reportModel, $attendanceModel, $evaluationModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jobModel = new JobModel();
        $this->attendanceModel = new AttendanceModel();
        $this->reportModel = new ReportModel();
        $this->evaluationModel = new EvaluationModel();
        if (session()->get('level') != "employee") {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $id = session()->get('id');

        $isLoggedIn = $this->attendanceModel
            ->where(['user_id' => $id])
            ->where('DATE(signin_at)', date('Y-m-d'))
            ->first();

        $data = [
            'isLoggedIn' => $isLoggedIn
        ];

        echo view('layouts/pages/User/index', $data);
    }

    public function profile()
    {
        helper(['form']);
        $id = session()->get('id');
//        $pointAllJobs = $this->jobModel
//            ->where(['user_id' => $id])
//            ->where(['is_completed' => 1])
//            ->selectSum('point')
//            ->first();
        $pointAllJobs = $this->evaluationModel->where(['evaluationId' => $id])->first();

        $data = [
            'user' => $this->userModel->where(['userId' => $id])->first(),
            'point' => $pointAllJobs
        ];
        return view('layouts/pages/User/profile/index', $data);
    }

    public function absent()
    {
        $id = session()->get('id');

        $isLoggedIn = $this->attendanceModel
            ->where(['user_id' => $id])
            ->where('DATE(signin_at)', date('Y-m-d'))
            ->first();

        $data = [
            'isLoggedIn' => $isLoggedIn
        ];

        echo view('layouts/pages/User/absent/index', $data);
    }

    public function report()
    {
        $id = session()->get('id');
        $dataJob = $this->jobModel->findAll();
        $detail = $this->reportModel
            ->where(['user_id' => $id])
            ->where(['DATE(created_report)' => date('Y-m-d')])
            ->first();

        $data = [
            'job' => $dataJob,
            'report' => $detail,
        ];
        echo view('layouts/pages/User/report/index', $data);
    }

    public function completeReport($id)
    {
        $id_user = session()->get('id');
        $data = [
            'jobId' => $id,
            'user_id' => $id_user,
            'is_completed' => 1,
            'updated_at' => 'Y-m-d H:i:s',
        ];

        $this->jobModel->replace($data);

        session()->setFlashData('index', 'Success Completed your job!');
        return redirect()->to("/logout");
    }

    public function task()
    {
        $jobModel = new JobModel();
        $userId = session()->get('id');
        $job = $jobModel
            ->where('user_id', $userId)
            ->where('DATE(created_at)', date('Y-m-d'))
            ->first();

        $data = [
            'page' => 'job',
            'job' => $job
        ];

        echo view('layouts/pages/User/task/detail', $data);
    }

    public function TaskDetail($id)
    {
        $data = [
            'job' => $this->jobModel->where(['jobId' => $id])->first(),
        ];
        echo view('layouts/pages/User/task/detail', $data);
    }
}
