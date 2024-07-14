<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];

    public function cariData($cari, $limit, $offset)
    {
        $builder = $this->table('users');
        $builder->select('users.id, users.username, users.role, cabang.nama_cabang');
        $builder->join('cabang', 'users.id_cabang = cabang.id');
        $builder->groupBy('users.id');
        $builder->like('username', $cari);
        $builder->limit($limit, $offset);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function detailUsers($id_user)
    {
        return $this->select('users.id, users.username, users.role, cabang.nama_cabang, cabang.alamat, cabang.telepon')
            ->join('cabang', 'users.id_cabang = cabang.id')
            ->where('users.id', $id_user)
            ->first();
    }

    public function getAllData($limit, $offset)
    {
        $builder = $this->table('users');
        $builder->select('users.id, users.username, users.role, cabang.nama_cabang');
        $builder->join('cabang', 'users.id_cabang = cabang.id');
        $builder->groupBy('users.id');
        $builder->limit($limit, $offset);
        $query = $builder->get();

        return $query->getResultArray();
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

    public function addUser($username, $password, $role, $id_cabang)
    {
        $db = db_connect();
        $builder = $db->table('users');
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'id_cabang' => (int) $id_cabang
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

    public function updateUser($username, $password, $id_cabang, $id)
    {

        $db = db_connect();
        $builder = $db->table('users');
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'id_cabang' => (int) $id_cabang
        ];

        if ($builder->where('id', $id)->update($data)) {
            $msg = [
                'sukses' => 'Update User Berhasil'
            ];
        } else {
            $msg = [
                'error' => 'Gagal mengupdate user'
            ];
        }

        return $msg;
    }
}
