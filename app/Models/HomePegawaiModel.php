<?php

namespace App\Models;

use CodeIgniter\Model;

class HomePegawaiModel extends Model
{
  protected $table = 'transaksi';
  protected $primaryKey = 'id';

  public function getTotalTransaksi()
  {
    return $this->table('cabang')
                ->where('id_cabang', session('id_cabang'))
                ->countAllResults();
  }

  public function getTotalIncome()
  {
    return $this->groupStart()
      ->where('type', 'in')
      ->where('id_cabang', session('id_cabang'))
      ->groupEnd()
      ->selectSum('nominal')
      ->get()->getRow()->nominal;
  }

  public function getTotalOutcome()
  {
    return $this->groupStart()
      ->where('type', 'out')
      ->where('id_cabang', session('id_cabang'))
      ->groupEnd()
      ->selectSum('nominal')
      ->get()->getRow()->nominal;;
  }

  public function getTransaksiByTanggal()
  {
    return $this->select('DATE(trx_date) as tanggal, COUNT(id) as total_transaksi')
      ->where('id_cabang', session('id_cabang'))
      ->groupBy('DATE(trx_date)')
      ->findAll();
  }

  public function getTransaksiByMenu()
  {
    return $this->select('id_menu, menu.nama_menu, COUNT(transaksi.id) as total_transaksi')
      ->join('menu', 'menu.id = id_menu')
      ->where('transaksi.id_cabang', session('id_cabang'))
      ->groupBy('id_menu')
      ->findAll();
  }
}
