<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function login()
    {
        helper(['form']);
        return view('auth/login'); // Menggunakan return view
    }

    public function loginSubmit()
    {
        $session = session();
        $model = model(UsersModel::class); // Menggunakan model helper

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('email', $email)->first();

        if ($data) {
            if (password_verify($password, $data['password'])) {
                $this->setUserSession($data); // Memanggil fungsi untuk set session

                // Arahkan berdasarkan role
                if ($data['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');  
                } else {
                    return redirect()->to('/user/dashboard');
                }
            } else {
                $session->setFlashdata('msg', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function register()
    {
        helper(['form']);
        return view('auth/register'); // Menggunakan return view
    }

    public function registerSubmit()
    {
        helper(['form']);
        $rules = [
            'nama' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[60]',
            'confpassword' => 'matches[password]',
            'alamat' => 'required|min_length[5]|max_length[255]',  
            'telepon' => 'required|numeric|min_length[10]|max_length[13]'   
        ];

        if ($this->validate($rules)) {
            $model = model(UsersModel::class); // Menggunakan model helper
            $data = [
                'nama' => $this->request->getVar('nama'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'alamat' => $this->request->getVar('alamat'),
                'telepon' => $this->request->getVar('telepon'),
                'role' => 'user'
            ];
            $model->save($data);
            $session = session();
            $session->setFlashdata('success', 'Akun berhasil dibuat! Silakan login.');
            return redirect()->to('/login');
        } else {
            return view('auth/register', ['validation' => $this->validator]);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    private function setUserSession($userData)
    {
        $sessionData = [
            'id_pengguna' => $userData['id_pengguna'],
            'nama' => $userData['nama'],
            'email' => $userData['email'],
            'role' => $userData['role'],
            'logged_in' => TRUE
        ];
        session()->set($sessionData);
    }
}