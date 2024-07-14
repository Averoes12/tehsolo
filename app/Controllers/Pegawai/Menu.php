<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\Modelmenuminuman;
use App\Models\CabangModel;

class Menu extends BaseController
{
    protected $menuminuman;
    protected $cabangmodel;

    public function __construct()
    {
        $this->menuminuman = new Modelmenuminuman();
        $this->cabangmodel = new CabangModel();
    }

    public function data()
    {
        $tombolCari = $this->request->getPost('tombolmenu');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('carimenu');
            session()->set('carimenu', $cari);
            return redirect()->to(base_url('pegawai/menu/data'));
        } else {
            $cari = session()->get('carimenu');
        }


        $dataMenu = $cari ? $this->menuminuman->cariData($cari) : $this->menuminuman->getAllData();
        $cabang = $this->cabangmodel->findAll();

        $data = [
            'datamenu' => $dataMenu,
            'cabang' => $cabang,
            'cari' => $cari
        ];
        return view('pegawai/menu/data', $data);
    }


    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $cabang = $this->cabangmodel->find(session('id_cabang'));
            $msg = [
                'data' => view('pegawai/menu/modalformtambah', ['cabang' => $cabang])
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    function simpandata()
    {
        if ($this->request->isAJAX()) {
            $namamenu = $this->request->getVar('namamenu');
            $hargamenu = $this->request->getVar('hargamenu');
            $stok = $this->request->getVar('stok');
            $id_cabang = $this->request->getVar('cabang');


            $msg = $this->menuminuman->addMenu($namamenu, $hargamenu, $stok, $id_cabang);


            echo json_encode($msg);
        } else {
            return redirect()->back();
        }
    }


    function edit($id_menu)
    {
        $data = [
            'title' => 'Edit Menu',
            'menu' =>  $this->menuminuman->find($id_menu),
            'cabang' => $this->cabangmodel->find(session('id_cabang')),
            'validation' => \Config\Services::validation()
        ];

        return view('pegawai/menu/edit', $data);
    }


    function update($id_menu)
    {

        $namamenu = $this->request->getVar('namamenu');
        $hargamenu = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');
        $id_cabang = $this->request->getVar('cabang');

        $rules = [
            'namamenu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Menu wajib diisi'
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga wajib diisi',
                    'numeric' => 'Harga harus berupa angka'
                ]
            ],
            'stok' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Stok wajib diisi',
                    'numeric' => 'Stok harus berupa angka'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Menu',
                'menu' => $this->menuminuman->find($id_menu),
                'cabang' => $this->cabangmodel->findAll(),
                'validation' => \Config\Services::validation()
            ];
            echo view('pegawai/menu/edit', $data);
        } else {
            $msg = $this->menuminuman->updateMenu($id_menu, $namamenu, $hargamenu, $stok, $id_cabang);

            echo json_encode($msg);

            session()->setFlashdata('berhasil', 'Data Menu Berhasil Diedit');
            return redirect()->to(base_url('pegawai/menu/data'));
        }
    }

    function hapus($id_menu)
    {
        if ($this->request->isAJAX()) {
            $cekdata = $this->menuminuman->find($id_menu);

            if ($cekdata) {
                $this->menuminuman->delete($id_menu);

                $json = [
                    'sukses' => 'Data Menu Berhasil Dihapus'
                ];
                echo json_encode($json);
            }
        }
    }
}
