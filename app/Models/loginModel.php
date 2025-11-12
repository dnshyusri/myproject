<?php

namespace App\Models;

use CodeIgniter\Model;

class loginModel extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'email', 'jenis'];

    // Method to get a user by username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
