<?php

namespace App\Controllers;

use App\Models\QueryAuth;

class Login extends BaseController
{
    protected $qAuth;

    public function __construct()
    {
        $this->qAuth = new QueryAuth();
    }

    public function index()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('auth/login', $data);
    }

    public function auth()
    {
        if (!$this->validate([
            'email' => 'required',
            'password' => 'required'
        ])) {
            return redirect()->back()->withInput();
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $row_login = $this->qAuth->getLogin($email)->getRowArray();

        if ($row_login) {
            $pass = $row_login['password'];
            if (md5($password) === $pass) {
                $ses_data = [
                    'user_id'   => $row_login['id'],
                    'user_name' => $row_login['nama'],
                    'user_cabang' => $row_login['m_cabang'],
                    'logged_in' => TRUE
                ];
                session()->set($ses_data);
                $data_access = $this->qAuth->getAccess($row_login['id'])->getResultArray();
                session()->set('data_access', $data_access);
                return redirect()->to('/');
            } else {
                session()->setFlashdata('msg', 'Password Salah.');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('msg', 'Data User Tidak Ada.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
