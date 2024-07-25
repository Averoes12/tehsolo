<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\ReportModel;
use CodeIgniter\I18n\Time;

class Report extends BaseController
{
    public function index($id_cabang)
    {
        $reportModel = new ReportModel();
        $cabangModel = new CabangModel();
        $filter = $this->request->getPost('filter');
        $date = $this->request->getPost('date');

        if (isset($filter)) {
            session()->set('date', $date);

            $part = explode('-', (string)$date);
            $start_dt = str_replace('/', '-', $part[0]);
            $end_dt = str_replace('/', '-', $part[1]);

            $data['totalTransaksi'] = $reportModel->getTotalTransaksi($id_cabang, $start_dt, $end_dt);
            $data['totalIncome'] = $reportModel->getTotalIncome($id_cabang, $start_dt, $end_dt);
            $data['totalOutcome'] = $reportModel->getTotalOutcome($id_cabang, $start_dt, $end_dt);
            $data['transaksiByTanggal'] = $reportModel->getTransaksiByTanggal($id_cabang, $start_dt, $end_dt);
            $data['transaksiByCabang'] = $reportModel->getTransaksiByCabang($id_cabang, $start_dt, $end_dt);
            $data['transaksiByMenu'] = $reportModel->getTransaksiByMenu($id_cabang, $start_dt, $end_dt);
            $data['laporanKeuangan'] = $reportModel->getLaporanKeuanganPerCabang($id_cabang, $start_dt, $end_dt);
            $data['total_in'] = $reportModel->getTotalPenjualan($id_cabang, $start_dt, $end_dt);
            $data['total_out'] = $reportModel->getTotalPengeluaran($id_cabang, $start_dt, $end_dt);

            $data['date_range'] = $date;
        } else {

            $start_date = Time::parse('first day of this month');
            $end_date = Time::parse('last day of this month');

            $data['totalTransaksi'] = $reportModel->getTotalTransaksi($id_cabang);
            $data['totalIncome'] = $reportModel->getTotalIncome($id_cabang);
            $data['totalOutcome'] = $reportModel->getTotalOutcome($id_cabang);
            $data['transaksiByTanggal'] = $reportModel->getTransaksiByTanggal($id_cabang);
            $data['transaksiByCabang'] = $reportModel->getTransaksiByCabang($id_cabang);
            $data['transaksiByMenu'] = $reportModel->getTransaksiByMenu($id_cabang);
            $data['laporanKeuangan'] = $reportModel->getLaporanKeuanganPerCabang($id_cabang);
            $data['total_in'] = $reportModel->getTotalPenjualan($id_cabang);
            $data['total_out'] = $reportModel->getTotalPengeluaran($id_cabang);

            $data['date_range'] = $start_date->format('Y/m/d H:i:s') . ' - ' . $end_date->format('Y/m/d H:i:s');
        }

        $data['cabang'] = $cabangModel->findAll();
        $data['nama_cabang'] = $cabangModel->find($id_cabang)['nama_cabang'];
        $data['id_cabang'] = $id_cabang;


        return view('owner/report/report', $data);
    }
}
