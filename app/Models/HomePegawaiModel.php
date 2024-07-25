<?php

namespace App\Models;

use CodeIgniter\Model;

class HomePegawaiModel extends Model
{
  protected $table = 'transaksi';
  protected $primaryKey = 'id';

  public function getTotalTransaksi($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->select('COUNT(*) as total')
      ->where('id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->get()->getRow()->total;
  }

  public function getTotalIncome($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->where('type', 'in')
      ->where('id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N')
      ->selectSum('nominal');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->get()->getRow()->nominal;
  }

  public function getTotalOutcome($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->where('type', 'out')
      ->where('id_cabang', $id_cabang)
      ->selectSum('nominal');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->get()->getRow()->nominal;
  }

  public function getTransaksiByTanggal($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->select('DATE(trx_date) as tanggal, COUNT(id) as total_transaksi')
      ->where('type', 'in')
      ->where('id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N')
      ->groupBy('DATE(trx_date)');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->findAll();
  }

  public function getTransaksiByCabang($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->select('id_cabang, cabang.nama_cabang, COUNT(transaksi.id) as total_transaksi')
      ->join('cabang', 'cabang.id = '.$id_cabang)
      ->where('type', 'in')
      ->where('transaksi.cancelInd', 'N');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->findAll();
  }

  public function getTransaksiByMenu($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->select('a.id_menu, menu.nama_menu, SUM(a.qty) as total_transaksi')
      ->join('transaksi_menu a', 'a.id_transaksi = transaksi.id')
      ->join('menu', 'menu.id = a.id_menu')
      ->where('transaksi.id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N')
      ->groupBy('a.id_menu');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->findAll();
  }

  public function getLaporanKeuanganPerCabang($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->select(
      'cabang.nama_cabang,
      SUM(CASE WHEN transaksi.type = "in" THEN transaksi.nominal ELSE 0 END) as total_income,
      SUM(CASE WHEN transaksi.type = "out" THEN transaksi.nominal ELSE 0 END) as total_outcome,
      SUM(CASE WHEN transaksi.type = "in" THEN transaksi.nominal ELSE 0 END) - 
      SUM(CASE WHEN transaksi.type = "out" THEN transaksi.nominal ELSE 0 END) as profit'
    )
      ->join('menu', 'transaksi.id_menu = menu.id', 'left')
      ->join('cabang', 'transaksi.id_cabang = cabang.id')
      ->where('transaksi.id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->findAll();
  }

  public function getTotalPenjualan($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->select('COUNT(*) as total_in')
      ->where('type', 'in')
      ->where('id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N');

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->get()->getRow()->total_in;
  }

  public function getTotalPengeluaran($id_cabang, $start_dt = null, $end_dt = null)
  {
    $builder = $this->select('COUNT(*) as total_out')
      ->where('type', 'out')
      ->where('id_cabang', $id_cabang);

    if ($start_dt && $end_dt) {
      $builder->where('trx_date >=', $start_dt)
              ->where('trx_date <=', $end_dt);
    }

    return $builder->get()->getRow()->total_out;
  }
}
