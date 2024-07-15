<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\Modelmenuminuman;
use App\Models\CabangModel;
use App\Models\TransaksiOwner;

class Transaksi extends BaseController
{
  protected $menuminuman;
  protected $cabangmodel;
  protected $transaksimodel;

  public function __construct()
  {
    $this->menuminuman = new Modelmenuminuman();
    $this->cabangmodel = new CabangModel();
    $this->transaksimodel = new TransaksiOwner();
  }

  public function data()
  {
    $tombolCari = $this->request->getPost('tomboltransaksi');
    if (isset($tombolCari)) {
      $cari = $this->request->getPost('caritransaksi');
      session()->set('caritransaksi', $cari);
      return redirect()->to(base_url('owner/transaksi/data'));
    } else {
      $cari = session()->get('caritransaksi');
    }

    $datatrx = $cari ? $this->transaksimodel->cariData($cari) : $this->transaksimodel->getAllData();
    $cabang = $this->cabangmodel->findAll();
    $menu = $this->menuminuman->findAll();

    $data = [
      'datatrx' => $datatrx,
      'cabang' => $cabang,
      'menu' => $menu,
      'cari' => $cari
    ];
    return view('owner/transaksi/data', $data);
  }


  function formTambah()
  {
    if ($this->request->isAJAX()) {
      $cabang = $this->cabangmodel->findAll();
      $menu = $this->menuminuman
        ->groupStart()
        ->where('id_cabang', 0)
        ->orWhere('id_cabang', session('id_cabang'))
        ->groupEnd()
        ->findAll();
      $msg = [
        'data' => view('owner/transaksi/modalformtambah', ['cabang' => $cabang, 'menu' => $menu])
      ];

      echo json_encode($msg);
    } else {
      exit('Maaf tidak ada halaman yang bisa ditampilkan');
    }
  }

  function formPengeluaran()
  {
    if ($this->request->isAJAX()) {
      $msg = [
        'data' => view('owner/transaksi/modalformpengeluaran')
      ];

      echo json_encode($msg);
    } else {
      exit('Maaf tidak ada halaman yang bisa ditampilkan');
    }
  }

  function simpandata()
  {
    if ($this->request->isAJAX()) {
      $type = $this->request->getVar('type');
      $nominal = $this->request->getVar('nominal');
      $quantity = $this->request->getVar('qty');
      $id_menu = $this->request->getVar('menu');
      $barang = $this->request->getVar('barang');

      $msg = $this->transaksimodel->addTransaksi($type, $nominal, $quantity, $id_menu, $barang);


      echo json_encode($msg);
    } else {
      return redirect()->back();
    }
  }


  function edit($data)
  {

    $decode = base64_decode($data);
    $id_trx = explode('*', $decode)[0];
    $id_menu = explode('*', $decode)[1];

    $data = [
      'title' => 'Edit Transaksi',
      'trx' =>  $this->transaksimodel->find($id_trx),
      'menus' => $this->menuminuman->groupStart()
        ->where('id_cabang', 0)
        ->orWhere('id_cabang', session('id_cabang'))
        ->groupEnd()
        ->findAll(),
      'menu' => $this->menuminuman->find($id_menu),
      'validation' => \Config\Services::validation(),
    ];

    return view('owner/transaksi/edit', $data);
  }

  function editPengeluaran($data)
  {

    $decode = base64_decode($data);
    $id_trx = explode('*', $decode)[0];

    $data = [
      'title' => 'Edit Transaksi',
      'trx' =>  $this->transaksimodel->find($id_trx),
      'validation' => \Config\Services::validation(),
    ];

    return view('owner/transaksi/editpengeluaran', $data);
  }

  function update($id_trx)
  {

    $type = $this->request->getVar('type');
    $nominal = $this->request->getVar('nominal');
    $quantity = $this->request->getVar('qty');
    $id_menu = $this->request->getVar('menu');
    $barang = $this->request->getVar('barang');

    $rules = [];
    if ($type == "out") {
      $rules = [
        'barang' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Barang wajib diisi',
          ]
        ],
        'harga' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Harga wajib diisi',
          ]
        ],
        'qty' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Quantity wajib diisi',
          ]
        ],
        'nominal' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Nominal wajib diisi',
          ]
        ],
      ];
    } else {

      $rules = [
        'harga' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Harga wajib diisi',
          ]
        ],
        'qty' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Quantity wajib diisi',
          ]
        ],
        'nominal' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Nominal wajib diisi',
          ]
        ],
      ];
    }

    if (!$this->validate($rules)) {
      $data = [
        'title' => 'Edit Transaksi',
        'trx' =>  $this->transaksimodel->find($id_trx),
        'menus' => $this->menuminuman->groupStart()
          ->where('id_cabang', 0)
          ->orWhere('id_cabang', session('id_cabang'))
          ->groupEnd()
          ->findAll(),
        'menu' => $this->menuminuman->find($id_menu),
        'validation' => \Config\Services::validation()
      ];

      if ($type == "in") {
        echo view('owner/transaksi/edit', $data);
      } else {
        echo view('owner/transaksi/editpengeluaran', $data);
      }
    } else {
      $msg = $this->transaksimodel->updateTransaksi($id_trx, $type, $nominal, $quantity, $id_menu, $barang);

      echo json_encode($msg);

      session()->setFlashdata('berhasil', 'Data Transaksi Berhasil Diedit');
      return redirect()->to(base_url('owner/transaksi/data'));
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

  public function getMenuById($id)
  {
    $menuModel = new Modelmenuminuman();
    $menu = $menuModel->find($id);

    if ($menu) {
      return $this->response->setJSON(['menu' => $menu]);
    } else {
      return $this->response->setJSON(['error' => 'Menu tidak ditemukan'], 404);
    }
  }
}
