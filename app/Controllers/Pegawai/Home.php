<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\HomePegawaiModel;

class Home extends BaseController
{
    public function index()
    {
        $homeModel = new HomePegawaiModel();

        $data['totalTransaksi'] = $homeModel->getTotalTransaksi();
        $data['totalIncome'] = $homeModel->getTotalIncome();
        $data['totalOutcome'] = $homeModel->getTotalOutcome();
        $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal();
        $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu();

        return view('pegawai/home', $data);
    }
}
