<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index()
    {
        return view('owner/home');
    }
}
