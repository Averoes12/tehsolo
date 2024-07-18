<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiPegawai extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';


    public function cariData($cari)
    {
        $builder = $this->table('transaksi');
        $builder->select('transaksi.id, transaksi.type, transaksi.trx_date, transaksi.id_user, transaksi.barang, transaksi.id_menu, transaksi.nominal, transaksi.quantity, a.username as createby, menu.nama_menu, cabang.nama_cabang, transaksi.cancelInd, b.username as updateby');
        $builder->join('menu', 'transaksi.id_menu = menu.id', 'left');
        $builder->join('cabang', 'menu.id_cabang = cabang.id', 'left');
        $builder->join('users a', 'transaksi.createBy = a.id', 'left');
        $builder->join('users b', 'transaksi.updateBy = b.id', 'left');
        $builder->where('transaksi.id_cabang', session('id_cabang'));
        $builder->like('menu.nama_menu', $cari);
        $builder->orLike('transaksi.barang', $cari);
        $builder->groupBy('transaksi.trx_date');
        $builder->orderBy('transaksi.trx_date', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function addTransaksi($type, $nominal, $quantity, $menus, $barang, $cabang)
    {
        $db = db_connect();
        $db->transStart();

        $builder = $db->table('transaksi');
        $data = [
            'trx_date' => date('Y-m-d H:i:s'),
            'type' => $type,
            'nominal' => floatval($nominal),
            'barang' => $barang,
            'quantity' => $quantity,
            'id_user' => session('id_user'),
            'id_cabang' => session('id_cabang'),
            'createby' => session('id_user'),
            'createdt' => date('Y-m-d H:i:s'),
        ];

        if ($builder->insert($data)) {
            // Mendapatkan ID terakhir yang baru saja dimasukkan
            $last_id = $db->insertID();

            // Update stok di tabel menu berdasarkan type
            if ($type === 'in') {
                $trx_menu_builder = $db->table('transaksi_menu');
                $menuBuilder = $db->table('menu');
                for ($i = 0; $i < count($menus); $i++) {
                    $item = [
                        "id_transaksi" => $last_id,
                        "id_menu" => $menus[$i]['id'],
                        "qty" => $menus[$i]['qty'],
                    ];
                    $trx_menu_builder->insert($item);

                    $menuBuilder->set('stok', 'stok - ' . intval($menus[$i]['qty']), false);
                    $menuBuilder->where('id', intval($menus[$i]['id']));
                    $menuBuilder->update();
                }
            }
        } else {
            // Tangkap error jika insert ke tabel transaksi gagal
            $msg = [
                'error' => 'Gagal menambah transaksi: ' . $db->error()
            ];
            return $msg;
        }

        if ($db->transComplete()) {
            if ($db->transStatus() === FALSE) {
                $msg = [
                    'error' => 'Gagal menyelesaikan transaksi: ' . $db->error()
                ];
            } else {
                $msg = [
                    'sukses' => 'Tambah Transaksi Berhasil'
                ];
            }
        } else {
            // Tangkap error jika commit transaksi gagal
            $msg = [
                'error' => 'Gagal menambah transaksi: ' . $db->error()
            ];
        }

        return $msg;
    }



    public function getAllData()
    {
        $builder = $this->table('transaksi');
        $builder->select('transaksi.id, transaksi.type, transaksi.trx_date, transaksi.id_user, transaksi.barang, transaksi.id_menu, transaksi.nominal, a.qty quantity, b.username as createby, c.username as updateby, menu.nama_menu, cabang.nama_cabang, transaksi.cancelInd');
        $builder->join('transaksi_menu a', 'a.id_transaksi = transaksi.id', 'left');
        $builder->join('menu', 'a.id_menu = menu.id', 'left');
        $builder->join('cabang', 'transaksi.id_cabang = cabang.id', 'left');
        $builder->join('users b', 'transaksi.createBy = b.id', 'left');
        $builder->join('users c', 'transaksi.updateBy = c.id', 'left');
        $builder->where('transaksi.id_cabang', session('id_cabang'));
        $builder->groupBy('transaksi.trx_date');
        $builder->orderBy('transaksi.trx_date', 'DESC');
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

    public function updateTransaksi($trx_id, $type, $nominal, $quantity, $id_menu, $barang)
    {
        $db = db_connect();
        $db->transStart();

        // Ambil data transaksi lama
        $builder = $db->table('transaksi');
        $oldTransaction = $builder->getWhere(['id' => $trx_id])->getRowArray();

        if ($oldTransaction) {
            // Update transaksi
            $data = [
                'nominal' => floatval($nominal),
                'quantity' => intval($quantity),
                'id_menu' => intval($id_menu),
                'barang' => $barang,
                'id_user' => session('id_user'),
                'id_cabang' => session('id_cabang'),
                'trx_date' => date('Y-m-d H:i:s'),
                'updateby' => session('id_user'),
                'updatedt' => date('Y-m-d H:i:s'),
            ];

            $builder->where('id', $trx_id);
            $builder->update($data);
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
        $builder->select('
        transaksi.id, 
        transaksi.trx_date, 
        transaksi.id_user, 
        transaksi.barang, 
        transaksi.nominal, 
        a.qty as quantity, 
        users.username as createby, 
        menu.nama_menu, 
        cabang.nama_cabang,
        menu.harga,
        (a.qty * menu.harga) as sub_total
    ');
        $builder->join('transaksi_menu a', 'a.id_transaksi = transaksi.id', 'left');
        $builder->join('menu', 'a.id_menu = menu.id', 'left');
        $builder->join('cabang', 'transaksi.id_cabang = cabang.id', 'left');
        $builder->join('users', 'transaksi.id_user = users.id', 'left');
        $builder->where('transaksi.id', intval($id));
        $builder->orderBy('transaksi.trx_date', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function cancelTrx($id)
    {
        $db = db_connect();
        $db->transStart();

        // Ambil data transaksi lama
        $builder = $db->table('transaksi');
        $data = [
            'updateby' => session('id_user'),
            'updatedt' => date('Y-m-d H:i:s'),
            'cancelInd' => 'Y'
        ];

        $builder->where('id', $id);
        $builder->update($data);
        if ($db->transComplete()) {
            $msg = [
                'success' => true,
                'msg' => 'Cancel Transaksi Berhasil'
            ];
        } else {
            $msg = [
                'success' => false,
                'msg' => 'Gagal cancel transaksi'
            ];
        }

        return $msg;

    }
}
