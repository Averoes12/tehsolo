<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelmenuminuman extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama_menu', 'harga'];

    public function cariData($cari, $perPage = 15, $currentPage = 1)
    {
        $builder = $this->table('menu');
        $builder->select('menu.id, menu.nama_menu, menu.harga, menu.stok, cabang.nama_cabang');
        $builder->join('cabang', 'menu.id_cabang = cabang.id', 'left');
        if(session('role_id') != "owner"){
            $builder->where('cabang.id', session('id_cabang'));
        }
        $builder->like('menu.nama_menu', $cari);
        $builder->groupBy('menu.id');
        $builder->orderBy('menu.id', 'DESC');

        return $builder->paginate($perPage, 'default', $currentPage);

    }

    public function addMenu($namamenu, $hargamenu, $stok, $id_cabang)
    {
        $db = db_connect();
        $builder = $db->table('menu');
        $data = [
            'nama_menu' => $namamenu,
            'harga' => floatval($hargamenu),
            'stok' => intval($stok),
            'id_cabang' => intval($id_cabang)
        ];

        if ($builder->insert($data)) {
            $msg = [
                'sukses' => 'Tambah User Berhasil'
            ];
        } else {
            $msg = [
                'error' => 'Gagal menambah user'
            ];
        }

        return $msg;
    }

    public function getAllData($perPage = 15, $currentPage = 1)
    {
        $builder = $this->table('menu');
        $builder->select('menu.id, menu.nama_menu, menu.harga, menu.stok, cabang.nama_cabang');
        $builder->join('cabang', 'menu.id_cabang = cabang.id', 'left');
        if(session('role_id') != "owner"){
            $builder->where('cabang.id', session('id_cabang'));
        }
        $builder->groupBy('menu.id');
        $builder->orderBy('menu.id', 'DESC');
        

        return $builder->paginate($perPage, $currentPage);
    }

    public function getCount()
    {
        $db = db_connect();
        $builder = $db->table('menu');
        $builder->select('COUNT(*) as count');
        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['count'];
    }

    public function updateMenu($id, $nama_menu, $harga, $stok, $id_cabang)
    {

        $db = db_connect();
        $builder = $db->table('menu');
        $data = [
            'nama_menu' => $nama_menu,
            'harga' => floatval($harga),
            'stok' => intval($stok),
            'id_cabang' => intval($id_cabang)
        ];

        if ($builder->where('id', $id)->update($data)) {
            $msg = [
                'sukses' => 'Update Menu Berhasil'
            ];
        } else {
            $msg = [
                'error' => 'Gagal mengupdate menu'
            ];
        }

        return $msg;
    }

    public function getMenuById($id)
    {
        return $this->table('menu')->where('id', $id)->first();
    }
}
