<?php namespace App\Models;

use CodeIgniter\Model;

class lokasiModel extends Model{
    protected $table = 'tbl_lokasi';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'Lokasi_Fail'
    ];
}
?>