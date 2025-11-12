<?php namespace App\Models;

use CodeIgniter\Model;

class failPeribadiPinjamModel extends Model{
    protected $table = 'tblperibadi_pinjam';
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
        'STATUS2',
        'LOKASI_FAIL',
        'NAMAPENGGUNA',
        'TARIKHPPT',
        'phone',
        'email'
    ];
}

?>

