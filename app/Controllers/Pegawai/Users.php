<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Users extends BaseController
{

    function index()
    {
        $data = [
            'title' => 'Edit User',
            'validation' => \Config\Services::validation()
        ];

        return view('pegawai/users/change_password', $data);
    }

    function update($id)
    {
        $username = session('username');
        $password =  $this->request->getPost('password');
        $id_cabang = session('id_cabang');

        $rules = [
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Baru wajib diisi'
                ]
            ],

        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit User',
                'validation' => \Config\Services::validation()
            ];
            echo view('pegawai/users/change_password', $data);
        } else {
            $usersmodel = new UsersModel();
            $msg = $usersmodel->updateUser($username, $password, $id_cabang, $id);

            echo json_encode($msg);
            
            session()->setFlashdata('berhasil', 'Password Berhasil Diedit');

            return redirect()->to(base_url('pegawai/home'));
        }
    }
}
