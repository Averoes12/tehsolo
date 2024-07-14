<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\HomeModel;

class Home extends BaseController
{
    public function index()
    {
        $homeModel = new HomeModel();

        $data['totalTransaksi'] = $homeModel->getTotalTransaksi();
        $data['totalIncome'] = $homeModel->getTotalIncome();
        $data['totalOutcome'] = $homeModel->getTotalOutcome();
        $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal();
        $data['transaksiByCabang'] = $homeModel->getTransaksiByCabang();
        $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu();
        $data['laporanKeuangan'] = $homeModel->getLaporanKeuanganPerCabang();


        return view('owner/home', $data);
    }
}
