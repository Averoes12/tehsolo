<?php

namespace App\Models;

use CodeIgniter\Model;

class CabangModel extends Model
{
    protected $table = 'cabang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_cabang', 'alamat', 'telepon'];

    public function cariData($cari)
    {
        return $this->table('cabang')->like('nama_cabang', $cari);
    }

    public function getAll()
    {
        return $this->table('cabang')->get()->getResult();
    }

    public function getCount()
    {
        $db = db_connect();
        $builder = $db->table('users');
        $builder->select('COUNT(*) as count');
        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['count'];
    }
}
