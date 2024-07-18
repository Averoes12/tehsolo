<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
  protected $table = 'transaksi';
  protected $primaryKey = 'id';

  public function getTotalTransaksi()
  {
    return $this->select('COUNT(*) as total')
    ->groupStart()
    ->where('transaksi.cancelInd', 'N')
    ->groupEnd()
    ->get()
    ->getRow()
    ->total;
  }

  public function getTotalIncome()
  {
    return $this
      ->groupStart()
      ->where('type', 'in')
      ->where('cancelInd', 'N')
      ->groupEnd()
      ->selectSum('nominal')->get()->getRow()->nominal;
  }

  public function getTotalOutcome()
  {
    return $this->where('type', 'out')->selectSum('nominal')->get()->getRow()->nominal;
  }

  public function getTransaksiByTanggal()
  {
    return $this->select('DATE(trx_date) as tanggal, COUNT(id) as total_transaksi')
      ->groupStart()
      ->where('type', 'in')
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->groupBy('DATE(trx_date)')
      ->findAll();
  }

  public function getTransaksiByCabang()
  {
    return $this->select('id_cabang, cabang.nama_cabang, COUNT(transaksi.id) as total_transaksi')
      ->join('cabang', 'cabang.id = id_cabang')
      ->groupStart()
      ->where('type', 'in')
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->groupBy('id_cabang')
      ->findAll();
  }

  public function getTransaksiByMenu()
  {
    return $this->select('id_menu, menu.nama_menu, COUNT(transaksi.quantity) as total_transaksi')
      ->join('menu', 'menu.id = id_menu')
      ->where('transaksi.cancelInd', 'N')
      ->groupBy('id_menu')
      ->findAll();
  }
  public function getLaporanKeuanganPerCabang()
  {
    return $this->select(
      'cabang.nama_cabang,
      SUM(CASE WHEN transaksi.type = "in" THEN transaksi.nominal ELSE 0 END) as total_income,
      SUM(CASE WHEN transaksi.type = "out" THEN transaksi.nominal ELSE 0 END) as total_outcome,
      SUM(CASE WHEN transaksi.type = "in" THEN transaksi.nominal ELSE 0 END) - 
      SUM(CASE WHEN transaksi.type = "out" THEN transaksi.nominal ELSE 0 END) as profit'
    )
      ->join('menu', 'transaksi.id_menu = menu.id', 'left')
      ->join('cabang', 'transaksi.id_cabang = cabang.id', 'left')
      ->where('transaksi.cancelInd', 'N')
      ->groupBy('cabang.nama_cabang')
      ->findAll();
  }

  public function getTotalPenjualan()
  {
    return $this->select('COUNT(*) as total_in')
      ->groupStart()
      ->where('type', 'in')
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->get()
      ->getRow()
      ->total_in;
  }

  public function getTotalPengeluaran()
  {
    return $this->select('COUNT(*) as total_out')
      ->where('type', 'out')
      ->get()
      ->getRow()
      ->total_out;
  }
}
