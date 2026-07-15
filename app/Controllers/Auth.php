<?php 

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController 
{
    public function login() 
    { 
        return view('login_view'); 
    }
    
    public function loginProcess() 
    {
        $model = new UserModel();
        $user = $model->where('email', $this->request->getPost('email'))->first();
        if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
            session()->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ]);
            return redirect()->to('/' . $user['role'] . '/dashboard');
        }
        return redirect()->back()->withInput()->with('error', 'Email atau Password salah.');
    }

    public function register()
    {
        return view('register_view');
    }

    public function registerProcess()
    {
        $model = new UserModel();

        // Ambil data dari form input
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            // Password di-hash agar aman di database
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            // Role diambil langsung dari dropdown di form register_view.php
            'role'     => $this->request->getPost('role'),
            'no_telp'  => $this->request->getPost('no_telp'),
            'alamat'   => $this->request->getPost('alamat'),
        ];

        // Validasi cek apakah email sudah terdaftar
        $cekEmail = $model->where('email', $data['email'])->first();
        if ($cekEmail) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar! Gunakan email lain.');
        }

        // Simpan ke tabel users
        if ($model->save($data)) {
            // Tidak auto-login. Setelah daftar berhasil, user diarahkan
            // ke halaman LOGIN terlebih dahulu untuk masuk secara manual
            // menggunakan akun yang baru dibuat.
            return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mendaftar, coba lagi.');
    }
    
    public function logout() 
    { 
        session()->destroy(); 
        return redirect()->to('/login'); 
    }
}