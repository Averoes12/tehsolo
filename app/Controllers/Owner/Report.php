<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\ReportModel;

class Report extends BaseController
{
    public function index($id_cabang)
    {
        $reportModel = new ReportModel();
        $cabangModel = new CabangModel();

        $data['totalTransaksi'] = $reportModel->getTotalTransaksi($id_cabang);
        $data['totalIncome'] = $reportModel->getTotalIncome($id_cabang);
        $data['totalOutcome'] = $reportModel->getTotalOutcome($id_cabang);
        $data['transaksiByTanggal'] = $reportModel->getTransaksiByTanggal($id_cabang);
        $data['transaksiByCabang'] = $reportModel->getTransaksiByCabang($id_cabang);
        $data['transaksiByMenu'] = $reportModel->getTransaksiByMenu($id_cabang);
        $data['laporanKeuangan'] = $reportModel->getLaporanKeuanganPerCabang($id_cabang);
        $data['total_in'] = $reportModel->getTotalPenjualan($id_cabang);
        $data['total_out'] = $reportModel->getTotalPengeluaran($id_cabang);
        $data['cabang'] = $cabangModel->findAll();
        $data['nama_cabang'] =$cabangModel->find($id_cabang)['nama_cabang'];


        return view('owner/report/report', $data);
    }
}
