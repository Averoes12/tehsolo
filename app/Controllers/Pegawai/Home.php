<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\HomePegawaiModel;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{
    public function index()
    {
        $homeModel = new HomePegawaiModel();
        $id_cabang = session('id_cabang');

        $filter = $this->request->getPost('filter');
        $date = $this->request->getPost('date');

        if (isset($filter)) {
            session()->set('date', $date);

            $part = explode('-', (string)$date);
            $start_dt = str_replace('/', '-', $part[0]);
            $end_dt = str_replace('/', '-', $part[1]);

            $data['totalTransaksi'] = $homeModel->getTotalTransaksi($id_cabang, $start_dt, $end_dt);
            $data['totalIncome'] = $homeModel->getTotalIncome($id_cabang, $start_dt, $end_dt);
            $data['totalOutcome'] = $homeModel->getTotalOutcome($id_cabang, $start_dt, $end_dt);
            $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal($id_cabang, $start_dt, $end_dt);
            $data['transaksiByCabang'] = $homeModel->getTransaksiByCabang($id_cabang, $start_dt, $end_dt);
            $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu($id_cabang, $start_dt, $end_dt);
            $data['laporanKeuangan'] = $homeModel->getLaporanKeuanganPerCabang($id_cabang, $start_dt, $end_dt);
            $data['total_in'] = $homeModel->getTotalPenjualan($id_cabang, $start_dt, $end_dt);
            $data['total_out'] = $homeModel->getTotalPengeluaran($id_cabang, $start_dt, $end_dt);

            $data['date_range'] = $date;
        } else {

            $start_date = Time::parse('first day of this month');
            $end_date = Time::parse('last day of this month');

            $data['totalTransaksi'] = $homeModel->getTotalTransaksi($id_cabang);
            $data['totalIncome'] = $homeModel->getTotalIncome($id_cabang);
            $data['totalOutcome'] = $homeModel->getTotalOutcome($id_cabang);
            $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal($id_cabang);
            $data['transaksiByCabang'] = $homeModel->getTransaksiByCabang($id_cabang);
            $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu($id_cabang);
            $data['laporanKeuangan'] = $homeModel->getLaporanKeuanganPerCabang($id_cabang);
            $data['total_in'] = $homeModel->getTotalPenjualan($id_cabang);
            $data['total_out'] = $homeModel->getTotalPengeluaran($id_cabang);

            $data['date_range'] = $start_date->format('Y/m/d H:i:s') . ' - ' . $end_date->format('Y/m/d H:i:s');
        }

        return view('pegawai/home', $data);
    }
}
