<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
  protected $table = 'transaksi';
  protected $primaryKey = 'id';

  public function getTotalTransaksi()
  {
    return $this->countAll();
  }

  public function getTotalIncome()
  {
    return $this->where('type', 'in')->selectSum('nominal')->get()->getRow()->nominal;
  }

  public function getTotalOutcome()
  {
    return $this->where('type', 'out')->selectSum('nominal')->get()->getRow()->nominal;
  }

  public function getTransaksiByTanggal()
  {
    return $this->select('DATE(trx_date) as tanggal, COUNT(id) as total_transaksi')
      ->groupBy('DATE(trx_date)')
      ->findAll();
  }

  public function getTransaksiByCabang()
  {
    return $this->select('id_cabang, cabang.nama_cabang, COUNT(transaksi.id) as total_transaksi')
      ->join('cabang', 'cabang.id = id_cabang')
      ->groupBy('id_cabang')
      ->findAll();
  }

  public function getTransaksiByMenu()
  {
    return $this->select('id_menu, menu.nama_menu, COUNT(transaksi.id) as total_transaksi')
      ->join('menu', 'menu.id = id_menu')
      ->groupBy('id_menu')
      ->findAll();
  }
}
