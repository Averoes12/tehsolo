<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\TransaksiPegawai;

class Home extends BaseController
{
    public function index()
    {

        return view('pegawai/home');
    }
}
