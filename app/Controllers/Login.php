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

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('login', $data);
        } else {
            $session = session();
            $LoginModel = new LoginModel;

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $cekusername = $LoginModel->where('username', $username)->first();

            if ($cekusername) {
                $password_db = $cekusername['password'];
                $cek_password = password_verify($password, $password_db);
                if ($cek_password) {
                    switch ($cekusername['role']) {
                        case "Admin":
                            return redirect()->to('admin/home');
                        case "Pegawai":
                            return redirect()->to('pegawai/home');
                        default:
                            $session->setFlashdata('pesan', 'Akun anda belum terdaftar');
                            return redirect()->to('/');
                    }
                } else {
                    $session->setFlashdata('pesan', 'Password salah, silahkan cobalagi');
                    return redirect()->to('/');
                }
            } else {
                $session->setFlashdata('pesan', 'Username salah, silahkan cobalagi');
                return redirect()->to('/');
            }
        }
    }
}
