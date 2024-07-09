<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'validation' => service('validation')
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
            $data = [
                'validation' => $this->validator
            ];
            return view('login', $data);
        } else {
            // Logic for successful validation
        }
    }
}
