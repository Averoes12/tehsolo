<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\CabangModel;

class Users extends BaseController
{
    protected $usersmodel;
    protected $cabangmodel;

    public function __construct()
    {
        $this->usersmodel = new UsersModel();
        $this->cabangmodel = new CabangModel();
    }

    public function data()
    {
        $tombolCari = $this->request->getPost('tombolusers');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('cariusers');
            session()->set('cariusers', $cari);
            return redirect()->to(base_url('owner/users/data'));
        } else {
            $cari = session()->get('cariusers');
        }

        $noHalaman = $this->request->getVar('page_users') ? $this->request->getVar('page_users') : 1;
        $limit = 5; // Jumlah data per halaman
        $offset = ($noHalaman - 1) * $limit;
        $totalRows = $this->usersmodel->getCount();

        $dataUsers = $cari ? $this->usersmodel->cariData($cari, $limit, $offset) : $this->usersmodel->getAllData($limit, $offset);
        $cabang = $this->cabangmodel->findAll();
        $pager = \Config\Services::pager();
        $pager->makeLinks($noHalaman, $limit, $totalRows, 'default_full', 3);

        $data = [
            'datausers' => $dataUsers,
            'pager' => $pager,
            'nohalaman' => $noHalaman,
            'cabang' => $cabang,
            'cari' => $cari,
        ];
        return view('owner/users/data', $data);
    }

    public function detail($id_users)
    {
        $userModel = new UsersModel();
        $user = $userModel->detailUsers($id_users);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data = [
            'user' => $user,
        ];

        return view('owner/users/detail', $data);
    }

    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $cabang = new CabangModel();
            $msg = [
                'data' => view('owner/users/modalformtambah')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }
    function simpandata()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $role = $this->request->getVar('role');
            $id_cabang = $this->request->getVar('id_cabang');


            $msg = $this->usersmodel->addUser($username, $password, $role, $id_cabang);
            echo json_encode($msg);
        } else {
            return redirect()->back();
        }
    }

    function hapus($id_user)
    {
        if ($this->request->isAJAX()) {
            $cekdata = $this->usersmodel->find($id_user);

            if ($cekdata) {
                $this->usersmodel->delete($id_user);

                $json = [
                    'sukses' => 'Data User Berhasil Dihapus'
                ];
                echo json_encode($json);
            }
        }
    }

    function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'user' =>  $this->usersmodel->find($id),
            'cabang' => $this->cabangmodel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('owner/users/edit', $data);
    }

    function update($id)
    {
        $username = $this->request->getPost('username');
        $password =  $this->request->getPost('password');
        $id_cabang = $this->request->getPost('id_cabang');

        $rules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Baru wajib diisi'
                ]
            ],
            'id_cabang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Cabang wajib diisi',
                ]
            ],

        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit User',
                'user' => $this->usersmodel->find($id),
                'cabang' => $this->cabangmodel->findAll(),
                'validation' => \Config\Services::validation()
            ];
            echo view('owner/users/edit', $data);
        } else {
            
            $msg = $this->usersmodel->updateUser($username, $password, $id_cabang, $id);

            echo json_encode($msg);
            
            return redirect()->to(base_url('owner/users/data'));
        }
    }
}
