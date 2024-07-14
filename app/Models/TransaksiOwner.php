<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiOwner extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';


    public function cariData($cari)
    {
        $builder = $this->table('transaksi');
        $builder->select('transaksi.id, transaksi.type, transaksi.trx_date, transaksi.id_user, transaksi.id_menu, transaksi.nominal, transaksi.quantity, transaksi.createby, menu.nama_menu, cabang.nama_cabang');
        $builder->join('menu', 'transaksi.id_menu = menu.id', 'left');
        $builder->join('cabang', 'menu.id_cabang = cabang.id', 'left');
        $builder->join('users', 'transaksi.id_user = users.id', 'left');
        $builder->like('menu.nama_menu', $cari);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function addTransaksi($type, $nominal, $quantity, $id_menu, $id_user)
    {
        $db = db_connect();
        $db->transStart();

        $builder = $db->table('transaksi');
        $data = [
            'trx_date' => date('Y-m-d H:i:s'),
            'type' => $type,
            'nominal' => floatval($nominal),
            'quantity' => intval($quantity),
            'id_menu' => intval($id_menu),
            'id_user' => session('id_user'),
            'id_cabang' => session('id_cabang'),
            'createby' => session('id_user'),
            'createdt' => date('Y-m-d H:i:s'),
        ];

        if ($builder->insert($data)) {
            // Update stok di tabel menu berdasarkan type
            $menuBuilder = $db->table('menu');

            if ($type === 'in') {
                $menuBuilder->set('stok', 'stok - ' . intval($quantity), false);
            } elseif ($type === 'out') {
                $menuBuilder->set('stok', 'stok + ' . intval($quantity), false);
            }

            $menuBuilder->where('id', intval($id_menu));
            $menuBuilder->update();
        }

        if ($db->transComplete()) {
            $msg = [
                'sukses' => 'Tambah Transaksi Berhasil'
            ];
        } else {
            $msg = [
                'error' => 'Gagal menambah transaksi'
            ];
        }

        return $msg;
    }



    public function getAllData()
    {
        $builder = $this->table('transaksi');
        $builder->select('transaksi.id, transaksi.type, transaksi.trx_date, transaksi.id_user, transaksi.id_menu, transaksi.nominal, transaksi.quantity, users.username as createby, menu.nama_menu, cabang.nama_cabang');
        $builder->join('menu', 'transaksi.id_menu = menu.id', 'left');
        $builder->join('cabang', 'transaksi.id_cabang = cabang.id', 'left');
        $builder->join('users', 'transaksi.id_user = users.id', 'left');
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getCount()
    {
        $db = db_connect();
        $builder = $db->table('transaksi');
        $builder->select('COUNT(*) as count');
        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['count'];
    }

    public function updateTransaksi($trx_id, $type, $nominal, $quantity, $id_menu)
    {
        $db = db_connect();
        $db->transStart();

        // Ambil data transaksi lama
        $builder = $db->table('transaksi');
        $oldTransaction = $builder->getWhere(['id' => $trx_id])->getRowArray();

        if ($oldTransaction) {
            // Update transaksi
            $data = [
                'type' => $type,
                'nominal' => floatval($nominal),
                'quantity' => intval($quantity),
                'id_menu' => intval($id_menu),
                'id_user' => session('id_user'),
                'id_cabang' => session('id_cabang'),
                'trx_date' => date('Y-m-d H:i:s'),
                'updateby' => session('id_user'),
                'updatedt' => date('Y-m-d H:i:s'),
            ];

            $builder->where('id', $trx_id);
            $builder->update($data);

            // Kembalikan stok dari transaksi lama
            $menuBuilder = $db->table('menu');
            if ($oldTransaction['type'] === 'in') {
                $menuBuilder->set('stok', 'stok - ' . intval($oldTransaction['quantity']), false);
            } elseif ($oldTransaction['type'] === 'out') {
                $menuBuilder->set('stok', 'stok + ' . intval($oldTransaction['quantity']), false);
            }
            $menuBuilder->where('id', intval($oldTransaction['id_menu']));
            $menuBuilder->update();

            // Kurangi atau tambahkan stok dari transaksi baru
            if ($type === 'in') {
                $menuBuilder->set('stok', 'stok - ' . intval($quantity), false);
            } elseif ($type === 'out') {
                $menuBuilder->set('stok', 'stok + ' . intval($quantity), false);
            }
            $menuBuilder->where('id', intval($id_menu));
            $menuBuilder->update();
        }

        if ($db->transComplete()) {
            $msg = [
                'sukses' => 'Update Transaksi Berhasil'
            ];
        } else {
            $msg = [
                'error' => 'Gagal mengupdate transaksi'
            ];
        }

        return $msg;
    }

    public function getTrxById($id)
    {
        $builder = $this->table('transaksi');
        $builder->select('transaksi.id, transaksi.type, transaksi.trx_date, transaksi.id_user, transaksi.id_menu, transaksi.nominal, transaksi.quantity, transaksi.createby, menu.nama_menu, cabang.nama_cabang');
        $builder->join('menu', 'transaksi.id_menu = menu.id', 'left');
        $builder->join('cabang', 'menu.id_cabang = cabang.id', 'left');
        $builder->join('users', 'transaksi.id_user = users.id', 'left');
        $builder->like('transaksi.id', $id);
        $query = $builder->get();

        return $query->getResultArray();
    }
}
