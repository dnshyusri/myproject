<?php namespace App\Models;

use CodeIgniter\Model;

class jawatanModel extends Model{
    protected $table = 'tbl_jawatan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'jawatan'
    ];
}
?>