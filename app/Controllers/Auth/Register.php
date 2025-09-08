<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class Register extends BaseController
{
    public function index()
    {
        helper(['form']);
        echo view('auth/register');
    }

    public function register()
    {
        $plainPassword = $this->request->getPost('password');
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password_hash' => $hashedPassword,
        ];

        $userModel = new User();
        $userModel->save($data);
        return redirect()->to('/login')->with('message', 'Registrasi berhasil!');
    }
}
