<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class SigninController extends BaseController
{
    public function index()
    {
        echo view('layouts/pages/login/index');
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $userModel->where('email', $email)->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $data['userId'],
                    'fullname' => $data['fullname'],
                    'position' => $data['position'],
                    'email' => $data['email'],
                    'level' => $data['level'],
                    'isLoggedIn' => TRUE
                ];

                $session->set($ses_data);

                if ($data['level'] == 'employee') {
                    return redirect()->to(base_url('/user'));
                } else {
                    return redirect()->to(base_url('/admin/dashboard'));
                }
            } else {
                $session->setFlashdata('failed', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('failed', 'Email does not exist.');
            return redirect()->to('/login');
        }
    }

    function logout()
    {
        $session = session();
        $session->set(array(
            'id' => '',
            'fullname' => '',
            'email' => '',
            'level' => '',
            'isLoggedIn' => FALSE
        ));
        $session->destroy();
        return redirect()->to('/login');
    }

    public function register() {
        $data = [
            'validation' => Services::validation(),
        ];
        echo view('layouts/pages/register/index', $data);
    }

    function append_string($str1, $str2)
    {
        $str1 .= $str2;
        return $str1;
    }

    public function registerSubmit()
    {
        helper(['form']);
        $userModel = new UserModel();
        $dataUser = $userModel->findAll();
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
                'registration_at' => date('Y-m-d H:i:s'),
            ];

            $userModel->save($data);
            session()->setFlashdata('success', 'Registration Successfully.');
            return redirect()->to("/login");
        } else {
            $validation = Services::validation();
            return redirect()->to('/register')->withInput()->with('validation', $validation);
        }
    }
}