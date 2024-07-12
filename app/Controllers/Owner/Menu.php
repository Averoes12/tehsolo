<?php

namespace App\Controllers\Owner;

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
            return redirect()->to(base_url('owner/menu/data'));
        } else {
            $cari = session()->get('carimenu');
        }

        $noHalaman = $this->request->getVar('page_menuminuman') ? $this->request->getVar('page_menuminuman') : 1;
        $limit = 5; // Jumlah data per halaman
        $offset = ($noHalaman - 1) * $limit;
        $totalRows = $this->menuminuman->getCount();

        $dataMenu = $cari ? $this->menuminuman->cariData($cari) : $this->menuminuman->getAllData($limit, $offset);
        $cabang = $this->cabangmodel->findAll();
        $pager = \Config\Services::pager();
        $pager->makeLinks($noHalaman, $limit, $totalRows, 'default_full', 3);

        $data = [
            'datamenu' => $dataMenu,
            'cabang' => $cabang,
            'pager' => $pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];
        return view('owner/menu/data', $data);
    }


    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $cabang = $this->cabangmodel->findAll();
            $msg = [
                'data' => view('owner/menu/modalformtambah', ['cabang' => $cabang])
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
            'cabang' => $this->cabangmodel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('owner/menu/edit', $data);
    }


    function update($id_menu)
    {
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
            'id_cabang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Cabang wajib diisi',
                    'numeric' => 'Cabang harus berupa angka'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Menu',
                'menu' => $this->menuminuman->find($id_menu),
                'validation' => \Config\Services::validation()
            ];
            echo view('owner/menu/edit', $data);
        } else {
            $this->menuminuman->update($id_menu, [
                'nama_menu' => $this->request->getPost('namamenu'),
                'harga' => $this->request->getPost('harga'),
                'stok' => $this->request->getPost('stok'),
                'id_cabang'=> $this->request->getPost('id_cabang'),
            ]);

            session()->setFlashdata('berhasil', 'Data Menu Berhasil Diedit');
            return redirect()->to(base_url('owner/menu/data'));
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
