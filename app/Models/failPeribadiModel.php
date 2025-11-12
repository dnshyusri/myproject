<?php namespace App\Models;

use CodeIgniter\Model;

class failPeribadiModel extends Model{
    protected $table = 'tblperibadi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'NAMA',
        'NOKP',
        'JAWATAN',
        'BAHAGIAN_CAWANGAN',
        'NOFAIL',
        'NOJILID',
        'TARIKH',
        'STATUS',
        'CATITAN',
        'LOKASI_FAIL'
    ];
}

?>

