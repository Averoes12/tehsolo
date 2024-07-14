<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\Modelmenuminuman;
use App\Models\CabangModel;
use App\Models\TransaksiPegawai;

class Transaksi extends BaseController
{
  protected $menuminuman;
  protected $cabangmodel;
  protected $transaksimodel;

  public function __construct()
  {
    $this->menuminuman = new Modelmenuminuman();
    $this->cabangmodel = new CabangModel();
    $this->transaksimodel = new TransaksiPegawai();
  }

  public function data()
  {
    $tombolCari = $this->request->getPost('tomboltransaksi');
    if (isset($tombolCari)) {
      $cari = $this->request->getPost('caritransaksi');
      session()->set('caritransaksi', $cari);
      return redirect()->to(base_url('pegawai/transaksi/data'));
    } else {
      $cari = session()->get('caritransaksi');
    }

    $noHalaman = $this->request->getVar('page_transaksi') ? $this->request->getVar('page_transaksi') : 1;
    $limit = 5; // Jumlah data per halaman
    $offset = ($noHalaman - 1) * $limit;
    $totalRows = $this->transaksimodel->getCount();

    $datatrx = $cari ? $this->transaksimodel->cariData($cari, $limit, $offset) : $this->transaksimodel->getAllData($limit, $offset);
    $cabang = $this->cabangmodel->findAll();
    $menu = $this->menuminuman->findAll();
    $pager = \Config\Services::pager();
    $pager->makeLinks($noHalaman, $limit, $totalRows, 'default_full', 3);

    $data = [
      'datatrx' => $datatrx,
      'cabang' => $cabang,
      'menu' => $menu,
      'pager' => $pager,
      'nohalaman' => $noHalaman,
      'cari' => $cari
    ];
    return view('pegawai/transaksi/data', $data);
  }


  function formTambah()
  {
    if ($this->request->isAJAX()) {
      $cabang = $this->cabangmodel->findAll();
      $menu = $this->menuminuman->findAll();
      $msg = [
        'data' => view('pegawai/transaksi/modalformtambah', ['cabang' => $cabang, 'menu' => $menu])
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


      $msg = $this->transaksimodel->addTransaksi($type, $nominal, $quantity, $id_menu, session('id_cabang'));


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
      'menus' => $this->menuminuman->findAll(),
      'menu' => $this->menuminuman->find($id_menu),
      'validation' => \Config\Services::validation(),
    ];

    return view('pegawai/transaksi/edit', $data);
  }


  function update($id_trx)
  {

    $type = $this->request->getVar('type');
    $nominal = $this->request->getVar('nominal');
    $quantity = $this->request->getVar('qty');
    $id_menu = $this->request->getVar('menu');

    $rules = [
      'harga' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Harga wajib diisi',
          'numeric' => 'Harga harus berupa angka'
        ]
      ],
      'qty' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Quantity wajib diisi',
          'numeric' => 'Quantity harus berupa angka'
        ]
      ],
      'nominal' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Nominal wajib diisi',
          'numeric' => 'Nominal harus berupa angka'
        ]
      ],
    ];

    if (!$this->validate($rules)) {
      $data = [
        'title' => 'Edit Transaksi',
        'trx' =>  $this->transaksimodel->find($id_trx),
        'menus' => $this->menuminuman->findAll(),
        'menu' => $this->menuminuman->find($id_menu),
        'validation' => \Config\Services::validation()
      ];
      echo view('pegawai/transaksi/edit', $data);
    } else {
      $msg = $this->transaksimodel->updateTransaksi($id_trx, $type, $nominal, $quantity, $id_menu);

      echo json_encode($msg);

      session()->setFlashdata('berhasil', 'Data Transaksi Berhasil Diedit');
      return redirect()->to(base_url('pegawai/transaksi/data'));
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
