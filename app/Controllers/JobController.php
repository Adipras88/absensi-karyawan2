<?php

namespace App\Controllers;

use App\Models\JobModel;
use App\Models\UserModel;
use Config\Services;

class JobController extends BaseController
{
    protected $jobModel, $userModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
        $this->userModel = new UserModel();

        if (session()->get('level') != "admin") {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $pointAllJobs = $this->jobModel->selectSum('point')->first();

        $data = [
            'page' => 'job',
            'job' => $this->jobModel->getJob(),
            'points' => $pointAllJobs,
        ];

        // var_dump($pointAllJobs);
        echo view('layouts/pages/admin/job/index', $data);
    }

    public function form($id = null)
    {
        helper(['form']);
        $dataUser = $this->userModel->findAll();
        $data = [
            'page' => 'job',
            'validation' => Services::validation(),
            'user' => $dataUser,
            'userId' => $id !== null ? $id : '',
        ];

        echo view('layouts/pages/admin/job/create', $data);
    }

    public function save()
    {
        helper(['form']);
        $rules = [
            'user_id' => 'required',
            'type_of_work' => 'required',
            'description' => 'required',
            'point' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'user_id' => $this->request->getVar('user_id'),
                'type_of_work' => $this->request->getVar('type_of_work'),
                'description' => $this->request->getVar('description'),
                'point' => $this->request->getVar('point'),
                'is_completed' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->jobModel->save($data);
            session()->setFlashdata('success_job', 'Create Job successfully.');
            return redirect()->to("/admin/job");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/job/form')->withInput()->with('validation', $validation);
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $dataJob = $this->jobModel
            ->join('users', 'users.userId = jobs.user_id')
            ->where(['jobId' => $id])
            ->first();

        $data = [
            'page' => 'job',
            'validation' => Services::validation(),
            'job' => $dataJob,
            'user' => $this->userModel->findAll(),
            'job_id' => $id
        ];

        echo view('layouts/pages/admin/job/edit', $data);
    }

    public function update($id)
    {
        helper(['form']);
        $rules = [
            'user_id' => 'required',
            'type_of_work' => 'required',
            'description' => 'required',
            'point' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'jobId' => $id,
                'user_id' => $this->request->getVar('user_id'),
                'type_of_work' => $this->request->getVar('type_of_work'),
                'description' => $this->request->getVar('description'),
                'point' => $this->request->getVar('point'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->jobModel->replace($data);
            session()->setFlashdata('success_job', 'Update Job successfully.');
            return redirect()->to("/admin/job");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/job/edit/' . $id)->withInput()->with('validation', $validation);
        }
    }

    public function detail($id)
    {
        helper(['form']);
        $dataJob = $this->jobModel
            ->join('users', 'users.userId = jobs.user_id')
            ->where(['jobId' => $id])
            ->first();

        $data = [
            'page' => 'job',
            'validation' => Services::validation(),
            'job' => $dataJob,
        ];

        echo view('layouts/pages/admin/job/detail', $data);
    }

    public function delete($id)
    {
        $this->jobModel->where(['jobId' => $id])->delete();
        session()->setFlashdata('success_job', 'Delete Job successfully.');
        return redirect()->to('/admin/job');
    }
}
