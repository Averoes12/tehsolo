<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\HomeModel;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{
    public function index()
    {
        $homeModel = new HomeModel();
        $cabangModel = new CabangModel();

        $filter = $this->request->getPost('filter');
        $date = $this->request->getPost('date');

        if (isset($filter)) {
            session()->set('date', $date);

            $part = explode('-', (string)$date);
            $start_dt = str_replace('/', '-', $part[0]);
            $end_dt = str_replace('/', '-', $part[1]);

            $data['totalTransaksi'] = $homeModel->getTotalTransaksi($start_dt, $end_dt);
            $data['totalIncome'] = $homeModel->getTotalIncome($start_dt, $end_dt);
            $data['totalOutcome'] = $homeModel->getTotalOutcome($start_dt, $end_dt);
            $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal($start_dt, $end_dt);
            $data['transaksiByCabang'] = $homeModel->getTransaksiByCabang($start_dt, $end_dt);
            $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu($start_dt, $end_dt);
            $data['laporanKeuangan'] = $homeModel->getLaporanKeuanganPerCabang($start_dt, $end_dt);
            $data['total_in'] = $homeModel->getTotalPenjualan($start_dt, $end_dt);
            $data['total_out'] = $homeModel->getTotalPengeluaran($start_dt, $end_dt);

            $data['date_range'] = $date;
        } else {

            $start_date = Time::parse('first day of this month');
            $end_date = Time::parse('last day of this month');

            $data['totalTransaksi'] = $homeModel->getTotalTransaksi();
            $data['totalIncome'] = $homeModel->getTotalIncome();
            $data['totalOutcome'] = $homeModel->getTotalOutcome();
            $data['transaksiByTanggal'] = $homeModel->getTransaksiByTanggal();
            $data['transaksiByCabang'] = $homeModel->getTransaksiByCabang();
            $data['transaksiByMenu'] = $homeModel->getTransaksiByMenu();
            $data['laporanKeuangan'] = $homeModel->getLaporanKeuanganPerCabang();
            $data['total_in'] = $homeModel->getTotalPenjualan();
            $data['total_out'] = $homeModel->getTotalPengeluaran();

            $data['date_range'] = $start_date->format('Y/m/d H:i:s') . ' - ' . $end_date->format('Y/m/d H:i:s');
        }

        $data['cabang'] = $cabangModel->findAll();


        return view('owner/home', $data);
    }
}
