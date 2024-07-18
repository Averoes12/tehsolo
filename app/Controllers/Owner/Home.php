<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\HomeModel;

class Home extends BaseController
{
    public function index()
    {
        $homeModel = new HomeModel();
        $cabangModel = new CabangModel();

        $data['totalTransaksi'] = $homeModel->getTotalTransaksi();
        $data['totalIncome'] = $homeModel->getTotalIncome();
        $data['totalOutcome'] = $homeModel->getTotalOutcome();
        $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal();
        $data['transaksiByCabang'] = $homeModel->getTransaksiByCabang();
        $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu();
        $data['laporanKeuangan'] = $homeModel->getLaporanKeuanganPerCabang();
        $data['total_in'] = $homeModel->getTotalPenjualan();
        $data['total_out'] = $homeModel->getTotalPengeluaran();
        $data['cabang'] = $cabangModel->findAll();


        return view('owner/home', $data);
    }
}
