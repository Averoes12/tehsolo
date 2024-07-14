<?php

namespace App\Controllers;
use App\Models\LoginModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

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

        if(!$this->validate($rules)){
            $data['validation'] = $this->validator;
            return view('login', $data);
        }else{
            $session = session();
            $loginmodel = new LoginModel;

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $cekusername = $loginmodel->where('username', $username)->first();
            
            if ($cekusername) {
                $passsword_db = $cekusername['password'];
                $cek_password = password_verify($password, $passsword_db);
                if ($cek_password) {

                    $session_data = [
                        'logged_in' => TRUE,
                        'role_id' => $cekusername['role'],
                        'username' => $cekusername['username'],
                        'id_user' => $cekusername['id'],
                        'id_cabang' => $cekusername['id_cabang'],
                    ]; 
                    $session->set($session_data);
                    switch($cekusername ['role']){
                        case "owner":
                            return redirect()->to('owner/home');
                        case "pegawai":
                            return redirect()->to('pegawai/home');
                        default:
                        $session->setFlashdata('pesan', 'Akun Anda Belum Terdaftar');
                    return redirect()->to('/');
                    }
                }else { 
                    $session->setFlashdata('pesan', 'Password salah, silakan coba lagi');
                    return redirect()->to('/');
                }
            }else{
                $session->setFlashdata('pesan', 'Username salah, silakan coba lagi');
                return redirect()->to('/');
            }
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
