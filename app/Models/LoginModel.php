<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'id_cabang'];
    protected $useTimestamps = false;

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}