<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiPegawai extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama_menu', 'harga'];

    public function cariData($cari)
    {
        return $this->table('menu')->like('nama_menu', $cari);
    }
}