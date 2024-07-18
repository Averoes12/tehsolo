<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\HomePegawaiModel;

class Home extends BaseController
{
    public function index()
    {
        $homeModel = new HomePegawaiModel();
        $id_cabang = session('id_cabang');

        $data['totalTransaksi'] = $homeModel->getTotalTransaksi($id_cabang);
        $data['totalIncome'] = $homeModel->getTotalIncome($id_cabang);
        $data['totalOutcome'] = $homeModel->getTotalOutcome($id_cabang);
        $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal($id_cabang);
        $data['transaksiByCabang'] = $homeModel->getTransaksiByCabang($id_cabang);
        $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu($id_cabang);
        $data['laporanKeuangan'] = $homeModel->getLaporanKeuanganPerCabang($id_cabang);
        $data['total_in'] = $homeModel->getTotalPenjualan($id_cabang);
        $data['total_out'] = $homeModel->getTotalPengeluaran($id_cabang);


        return view('pegawai/home', $data);
    }
}
