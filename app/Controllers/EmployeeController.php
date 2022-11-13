<?php

namespace App\Controllers;

use App\Models\JobModel;
use App\Models\UserModel;
use Config\Services;

class EmployeeController extends BaseController
{
    protected $userModel, $jobModel, $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jobModel = new JobModel();

        if (session()->get('level') != "admin") {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $user = $this->userModel->findAll();
        $data = [
            'page' => 'employee',
            'user' => $user
        ];

        return view('layouts/pages/admin/employee/index', $data);
    }

    function append_string($str1, $str2)
    {

        // Using Concatenation assignment
        // operator (.=)
        $str1 .= $str2;

        // Returning the result
        return $str1;
    }

    public function create()
    {
        helper(['form']);
        $data = [
            'page' => 'employee',
            'validation' => Services::validation(),
        ];

        echo view('layouts/pages/admin/employee/create', $data);
    }

    public function save()
    {
        helper(['form']);
        $dataUser = $this->userModel->findAll();
        $currentData = end($dataUser);

        $number = substr($currentData['ID_PKL'], strpos($currentData['ID_PKL'], "L") + 1);
        $id = (int)$number + 1;

        $IDPKL = null;
        if ((int)$number < 10) {
            $IDPKL = $this->append_string('PKL0000', (string)$id);
        } else if ((int)$number < 100) {
            $IDPKL = $this->append_string('PKL000', (string)$id);
        } else if ((int)$number < 1000) {
            $IDPKL = $this->append_string('PKL00', (string)$id);
        } else {
            $IDPKL = $this->append_string('PKL0', (string)$id);
        }

        $rules = [
            'fullname' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[4]|max_length[50]',
            'date_of_birth' => 'required',
            'phone_number' => 'required',
            'position' => 'required',
            'school_origin' => 'required',
            'internship_length' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'ID_PKL' => $IDPKL,
                'fullname' => $this->request->getVar('fullname'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'date_of_birth' => $this->request->getVar('date_of_birth'),
                'phone_number' => $this->request->getVar('phone_number'),
                'school_origin' => $this->request->getVar('school_origin'),
                'internship_length' => $this->request->getVar('internship_length'),
                'position' => $this->request->getVar('position'),
                'level' => 'employee',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            d($data);

            $this->userModel->save($data);
            session()->setFlashdata('success', 'Create Employee successfully.');
            return redirect()->to("/admin/employee");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/employee/form')->withInput()->with('validation', $validation);
        }
    }

    public function edit($id)
    {
        helper(['form']);

        $data = [
            'page' => 'employee',
            'validation' => Services::validation(),
            'user' => $this->userModel->where(['userId' => $id])->first(),
        ];

        echo view('layouts/pages/admin/employee/edit', $data);
    }

    public function update($id)
    {
        helper(['form']);
        $currentData = $this->userModel->where(['userId' => $id])->first();
        $rules = [
            'fullname' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|min_length[4]|max_length[100]|valid_email',
            'date_of_birth' => 'required',
            'position' => 'required',
            'phone_number' => 'required',
            'school_origin' => 'required',
            'internship_length' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'userId' => $id,
                'ID_PKL' => $currentData['ID_PKL'],
                'fullname' => $this->request->getVar('fullname'),
                'email' => $this->request->getVar('email'),
                'date_of_birth' => $this->request->getVar('date_of_birth'),
                'phone_number' => $this->request->getVar('phone_number'),
                'position' => $this->request->getVar('position'),
                'password' => $currentData['password'],
                'school_origin' => $currentData['school_origin'],
                'internship_length' => $currentData['internship_length'],
                'level' => $currentData['level'],
                'registration_at' => $currentData['registration_at'],
                'created_at' => $currentData['created_at'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->userModel->replace($data);
            session()->setFlashdata('success', 'Update Employee successfully.');
            return redirect()->to("/admin/employee");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/employee/edit/' . $id)->withInput()->with('validation', $validation);
        }
    }

    public function detail($id)
    {
        helper(['form']);
        $data = [
            'page' => 'employee',
            'validation' => Services::validation(),
            'user' => $this->userModel->where(['userId' => $id])->first(),
        ];

        echo view('layouts/pages/admin/employee/detail', $data);
    }

    public function delete($id)
    {
        $queryUserExist = $this->userModel->find();
        $queryJobExistInUser = $this->jobModel->findJobByUserId($id);

        if ($queryUserExist) {
            if ($queryJobExistInUser) {
                foreach ($queryJobExistInUser as $job) {
                    $this->jobModel->delete($job);
                }
                session()->setFlashdata('success', 'Delete Employee successfully.');
                return redirect()->to('/admin/employee');
            } else {
                $this->userModel->delete($id);
                session()->setFlashdata('success', 'Delete Employee successfully.');
                return redirect()->to('/admin/employee');
            }
            $this->userModel->delete($id);
        } else {
            return "User Not Found!";
            die();
        }
    }
}
