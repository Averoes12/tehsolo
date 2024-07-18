<?php

namespace App\Models;

use CodeIgniter\Model;

class HomePegawaiModel extends Model
{
  protected $table = 'transaksi';
  protected $primaryKey = 'id';

  public function getTotalTransaksi($id_cabang)
  {
    return $this->select('COUNT(*) as total')
    ->groupStart()
    ->where('id_cabang', $id_cabang)
    ->where('transaksi.cancelInd', 'N')
    ->groupEnd()
    ->get()
    ->getRow()
    ->total;
  }

  public function getTotalIncome($id_cabang)
  {
    return $this->groupStart()->where('type', 'in')->where('id_cabang', $id_cabang)->where('transaksi.cancelInd', 'N')->groupEnd()->selectSum('nominal')->get()->getRow()->nominal;
  }

  public function getTotalOutcome($id_cabang)
  {
    return $this->groupStart()->where('type', 'out')->where('id_cabang', $id_cabang)->groupEnd()->selectSum('nominal')->get()->getRow()->nominal;
  }

  public function getTransaksiByTanggal($id_cabang)
  {
    return $this->select('DATE(trx_date) as tanggal, COUNT(id) as total_transaksi')
      ->groupStart()
      ->where('type', 'in')
      ->where('id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->groupBy('DATE(trx_date)')
      ->findAll();
  }

  public function getTransaksiByCabang($id_cabang)
  {
    return $this->select('id_cabang, cabang.nama_cabang, COUNT(transaksi.id) as total_transaksi')
      ->join('cabang', 'cabang.id = '.$id_cabang)
      ->groupStart()
      ->where('type', 'in')
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->findAll();
  }

  public function getTransaksiByMenu($id_cabang)
  {
    return $this->select('a.id_menu, menu.nama_menu, SUM(a.qty) as total_transaksi')
    ->join('transaksi_menu a','a.id_transaksi = transaksi.id')
      ->join('menu', 'menu.id = a.id_menu')
      ->groupStart()
      ->where('transaksi.id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->groupBy('a.id_menu')
      ->findAll();
  }
  public function getLaporanKeuanganPerCabang($id_cabang)
  {
    return $this->select(
      'cabang.nama_cabang,
      SUM(CASE WHEN transaksi.type = "in" THEN transaksi.nominal ELSE 0 END) as total_income,
      SUM(CASE WHEN transaksi.type = "out" THEN transaksi.nominal ELSE 0 END) as total_outcome,
      SUM(CASE WHEN transaksi.type = "in" THEN transaksi.nominal ELSE 0 END) - 
      SUM(CASE WHEN transaksi.type = "out" THEN transaksi.nominal ELSE 0 END) as profit'
    )
      ->join('menu', 'transaksi.id_menu = menu.id', 'left')
      ->join('cabang', 'transaksi.id_cabang = cabang.id')
      ->groupStart()
      ->where('transaksi.id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->findAll();
  }

  public function getTotalPenjualan($id_cabang)
  {
    return $this->select('COUNT(*) as total_in')
      ->groupStart()
      ->where('type', 'in')
      ->where('id_cabang', $id_cabang)
      ->where('transaksi.cancelInd', 'N')
      ->groupEnd()
      ->get()
      ->getRow()
      ->total_in;
  }

  public function getTotalPengeluaran($id_cabang)
  {
    return $this->select('COUNT(*) as total_out')
      ->groupStart()
      ->where('type', 'out')
      ->where('id_cabang', $id_cabang)
      ->groupEnd()
      ->get()
      ->getRow()
      ->total_out;
  }
}
