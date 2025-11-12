<?php namespace App\Models;

use CodeIgniter\Model;

class bhgnCwgnModel extends Model{
    protected $table = 'tbl_bhgn_cwgn';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'Bhgn_cwgn'
    ];
}
?>