<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use CodeIgniter\HTTP\ResponseInterface;

class Cabang extends BaseController
{
    protected $cabangmodel;

    public function __construct()
    {
        $this->cabangmodel = new CabangModel();
    }

    public function data()
    {
        $tombolCari = $this->request->getPost('tombolcabang');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('caricabang');
            session()->set('caricabang', $cari);
            return redirect()->to(base_url('owner/cabang/data'));
        } else {
            $cari = session()->get('caricabang');
        }

        $currentPage = $this->request->getVar('page') ? (int) $this->request->getVar('page') : 1;
        $perPage = 15;
        $dataCabang = $cari ? $this->cabangmodel->cariData($cari, $perPage, $currentPage) : $this->cabangmodel->getAll($perPage, $currentPage);
        $total = count($dataCabang);


        $data = [
            'cabang' => $dataCabang,
            'cari' => $cari,
            'pager' => $this->cabangmodel->pager,
            'currentPage' => $currentPage,
            'perPage' => $perPage,
            'total' => $total,
        ];
        return view('owner/cabang/data', $data);
    }

    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('owner/cabang/modalformtambah')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    function simpandata()
    {
        if ($this->request->isAJAX()) {
            $namacabang = $this->request->getVar('namacabang');
            $alamatcabang = $this->request->getVar('alamatcabang');
            $teleponcabang = $this->request->getVar('teleponcabang');

            $this->cabangmodel->insert([
                'nama_cabang' => $namacabang,
                'alamat' => $alamatcabang,
                'telepon' => $teleponcabang
            ]);

            $msg = [
                'sukses' => 'Tambah Cabang Berhasil'
            ];
            echo json_encode($msg);
        } else {
            return redirect()->back();
        }
    }


    function edit($id_cabang)
    {
        $data = [
            'title' => 'Edit Cabang',
            'cabang' => $this->cabangmodel->find($id_cabang),
            'validation' => \Config\Services::validation()
        ];

        return view('owner/cabang/edit', $data);
    }


    function update($id_cabang)
    {
        $rules = [
            'namacabang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Cabang wajib diisi'
                ]
            ],
            'alamatcabang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat wajib diisi',
                ]
            ],
            'teleponcabang' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'telepon wajib diisi',
                    'numeric' => 'Telepon harus berupa angka'
                ]
            ]

        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Cabang',
                'cabang' => $this->cabangmodel->find($id_cabang),
                'validation' => \Config\Services::validation()
            ];
            echo view('owner/cabang/edit', $data);
        } else {
            $this->cabangmodel->update($id_cabang, [
                'nama_cabang' => $this->request->getPost('namacabang'),
                'alamat' => $this->request->getPost('alamatcabang'),
                'telepon' => $this->request->getPost('teleponcabang')
            ]);

            session()->setFlashdata('berhasil', 'Data Cabang Berhasil Diedit');
            return redirect()->to(base_url('owner/cabang/data'));
        }
    }

    function hapus($id_cabang)
    {
        if ($this->request->isAJAX()) {
            $cekdata = $this->cabangmodel->find($id_cabang);

            if ($cekdata) {
                $this->cabangmodel->delete($id_cabang);

                $json = [
                    'sukses' => 'Data Cabang Berhasil Dihapus'
                ];
                echo json_encode($json);
            }
        }
    }
}
