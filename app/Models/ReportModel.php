<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
  protected $table = 'transaksi';
  protected $primaryKey = 'id';

  public function getTotalTransaksi($id_cabang)
  {
    return $this->select('COUNT(*) as total')
    ->where('id_cabang', $id_cabang)
    ->get()
    ->getRow()
    ->total;
  }

  public function getTotalIncome($id_cabang)
  {
    return $this->groupStart()->where('type', 'in')->where('id_cabang', $id_cabang)->groupEnd()->selectSum('nominal')->get()->getRow()->nominal;
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
      ->groupEnd()
      ->groupBy('DATE(trx_date)')
      ->findAll();
  }

  public function getTransaksiByCabang($id_cabang)
  {
    return $this->select('id_cabang, cabang.nama_cabang, COUNT(transaksi.id) as total_transaksi')
      ->join('cabang', 'cabang.id = '.$id_cabang)
      ->where('type', 'in')
      ->findAll();
  }

  public function getTransaksiByMenu($id_cabang)
  {
    return $this->select('id_menu, menu.nama_menu, COUNT(transaksi.quantity) as total_transaksi')
      ->join('menu', 'menu.id = id_menu')
      ->where('transaksi.id_cabang', $id_cabang)
      ->groupBy('id_menu')
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
      ->where('transaksi.id_cabang', $id_cabang)
      ->findAll();
  }

  public function getTotalPenjualan($id_cabang)
  {
    return $this->select('COUNT(*) as total_in')
      ->groupStart()
      ->where('type', 'in')
      ->where('id_cabang', $id_cabang)
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
