<?php

namespace App\Models;

use CodeIgniter\Model;

class CabangModel extends Model
{
    protected $table = 'cabang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_cabang', 'alamat', 'telepon'];

    public function cariData($cari, $perPage = 15, $currentPage = 1)
    {
        return $this->table($this->table)
            ->like('nama_cabang', $cari)
            ->orderBy('id', 'DESC')
            ->paginate($perPage, 'default', $currentPage);
    }

    public function getAll($perPage = 15, $currentPage = 1)
    {
        return $this->table($this->table)
            ->orderBy('id', 'DESC')
            ->paginate($perPage, 'default', $currentPage);
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
