<?php namespace App\Models;

use CodeIgniter\Model;

class peminjamModel extends Model{
    protected $table = 'tbl_peminjam';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'user',
        'phone',
        'email'
    ];
}

?>