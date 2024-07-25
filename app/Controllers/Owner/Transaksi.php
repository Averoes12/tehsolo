<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\Modelmenuminuman;
use App\Models\CabangModel;
use App\Models\TransaksiOwner;
use Dompdf\Dompdf;

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
    $filter = $this->request->getPost('filter');
    if (isset($tombolCari) || isset($filter)) {
      $cari = $this->request->getPost('caritransaksi');
      $branch_id = $this->request->getPost('branch_id');
      $type = $this->request->getPost('type');
      session()->set('caritransaksi', $cari);
      session()->set('branch_id', $branch_id);
      session()->set('type', $type);
      return redirect()->to(base_url('owner/transaksi/data'));
    } else {
      $cari = session()->get('caritransaksi');
      $branch_id = session()->get('branch_id');
      $type = session()->get('type');
    }

    $currentPage = $this->request->getVar('page') ? (int) $this->request->getVar('page') : 1;
    $perPage = 15;

    if ($cari || $branch_id || $type) {
      $datatrx = $this->transaksimodel->cariData($cari, $branch_id, $type, $perPage, $currentPage);
      $total = $this->transaksimodel->getTotalData($cari, $branch_id, $type);
    } else {
      $datatrx = $this->transaksimodel->getAllData($perPage, $currentPage);
      $total = $this->transaksimodel->getTotalData();
    }

    $cabang = $this->cabangmodel->findAll();
    $menu = $this->menuminuman->findAll();

    // dd($datatrx);
    $data = [
      'datatrx' => $datatrx,
      'cabang' => $cabang,
      'menu' => $menu,
      'cari' => $cari,
      'selectedCabang' => $branch_id,
      'selectedType' => $type,
      'pager' => $this->transaksimodel->pager,
      'currentPage' => $currentPage,
      'perPage' => $perPage,
      'total' => $total,
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
      $cabang = $this->cabangmodel->findAll();
      $msg = [
        'data' => view('owner/transaksi/modalformpengeluaran', ['cabang' => $cabang])
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
      $menus = $this->request->getVar('menus');
      $barang = $this->request->getVar('barang');
      $cabang = $this->request->getVar('cabang');

      $msg = $this->transaksimodel->addTransaksi($type, $nominal, $quantity, $menus, $barang, $cabang);

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
      'trx' => $this->transaksimodel->find($id_trx),
      'menus' => $this->menuminuman->groupStart()
        ->where('id_cabang', 0)
        ->orWhere('id_cabang', session('id_cabang'))
        ->groupEnd()
        ->findAll(),
      'menu' => $this->menuminuman->find($id_menu),
      'cabang' => $this->cabangmodel->findAll(),
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
      'trx' => $this->transaksimodel->find($id_trx),
      'cabang' => $this->cabangmodel->findAll(),
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
    $old_qty = $this->request->getVar('old_qty');
    $cabang = $this->request->getVar('cabang');

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
          'rules' => 'required|greater_than[0]',
          'errors' => [
            'required' => 'Harga wajib diisi',
            'greater_than' => 'Harga tidak boleh 0'
          ]
        ],
        'qty' => [
          'rules' => 'required|greater_than[0]',
          'errors' => [
            'required' => 'Quantity wajib diisi',
            'greater_than' => 'Quantity tidak boleh 0'
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
          'rules' => 'required|greater_than[0]',
          'errors' => [
            'required' => 'Quantity wajib diisi',
            'greater_than' => 'Quantity tidak boleh 0'
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
        'trx' => $this->transaksimodel->find($id_trx),
        'menus' => $this->menuminuman->groupStart()
          ->where('id_cabang', 0)
          ->orWhere('id_cabang', session('id_cabang'))
          ->groupEnd()
          ->findAll(),
        'menu' => $this->menuminuman->find($id_menu),
        'cabang' => $this->cabangmodel->findAll(),
        'validation' => \Config\Services::validation()
      ];

      if ($type == "in") {
        echo view('owner/transaksi/edit', $data);
      } else {
        echo view('owner/transaksi/editpengeluaran', $data);
      }
    } else {
      $msg = $this->transaksimodel->updateTransaksi($id_trx, $type, $nominal, $quantity, $id_menu, $barang, $old_qty, $cabang);

      echo json_encode($msg);

      session()->setFlashdata('berhasil', 'Data Transaksi Berhasil Diedit');
      return redirect()->to(base_url('owner/transaksi/data'));
    }
  }

  function hapus($id_menu)
  {
    if ($this->request->isAJAX()) {
      $cekdata = $this->transaksimodel->find($id_menu);

      if ($cekdata) {
        $this->transaksimodel->delete($id_menu);

        $json = [
          'sukses' => 'Data Transaksi Berhasil Dihapus'
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
  public function getMenuByCabang()
  {
    $menuModel = new Modelmenuminuman();
    $idCabang = $this->request->getGet('id');
    $menus = $menuModel->where('id_cabang', $idCabang)->findAll();

    return $this->response->setJSON($menus);
  }

  public function getAllCabang()
  {
    $cabangs = $this->cabangmodel->findAll();

    return $this->response->setJSON($cabangs);
  }

  public function print()
  {

    return view('owner/transaksi/print');
  }

  public function cancelTrx($id)
  {
    $msg = $this->transaksimodel->cancelTrx($id);

    echo json_encode($msg);

    return $msg;

  }

  public function getDetailTransaksi($id)
  {
    $trx = $this->transaksimodel->getTrxById($id);

    return $this->response->setJSON($trx);
  }

  public function generate($id)
  {
    $data = $this->transaksimodel->getTrxById($id);
    $filename = 'invoice-' . date('y-m-d-H-i-s');

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    // load HTML content
    $dompdf->loadHtml(view('owner/transaksi/print', ['trx' => $data]));

    // (optional) setup the paper size and orientation

    // render html as PDF
    $dompdf->render();

    // output the generated pdf
    $dompdf->stream($filename);
  }
}
