<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];

        return view('login', $data);
    }

    public function login_action()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        // Validate input
        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('login', $data);
        }

        $session = session();
        $loginModel = new LoginModel;

        // Retrieve user from database
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $cekusername = $loginModel->where('username', $username)->first();

        if ($cekusername) {
            // Verify password
            if (password_verify($password, $cekusername['password'])) {

                $session_data = [
                    'username' => $cekusername['username'],
                    'logged_in' => TRUE,
                    'role_id' => $cekusername['role']
                ];
                $session->set($session_data);

                switch ($cekusername['role']) {
                    case 'Admin':
                        return redirect()->to('/admin/home');
                        break;
                    case 'Pegawai':
                        return redirect()->to('/pegawai/home');
                        break;
                    default:
                        $session->setFlashdata('pesan', 'Anda belum terdaftar.');
                        return redirect()->to('/');
                        break;
                }
            } else {
                // Password incorrect
                $session->setFlashdata('pesan', 'Password salah, silahkan coba lagi.');
                return redirect()->to('/');
            }
        } else {
            // User not found
            $session->setFlashdata('pesan', 'Username tidak ditemukan, silahkan coba lagi.');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
