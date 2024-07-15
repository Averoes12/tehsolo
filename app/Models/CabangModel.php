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
        return $this->table($this->table)
                    ->like('nama_cabang', $cari)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->getResultArray();
    }

    public function getAll()
    {
        return $this->table($this->table)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->getResultArray();
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
