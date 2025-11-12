<?php namespace App\Models;

use CodeIgniter\Model;

class failAmPinjamModel extends Model{
    protected $table = 'tbl_failam_pinjam';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'Abjad',
        'KodSubjek',
        'Subjek',
        'Bil',
        'TajukFail',
        'RujukFailLama',
        'RujukFailBaru',
        'RujukFailBaruID',
        'Jilid',
        'tkhBuka',
        'tkhTutup',
        'tkhkandungtama',
        'tkhkandungakhir',
        'LokasiFail',
        'Catatan',
        'Status',
        'NamaPinjamPulang',
        'TARIKHPPT',
        'phone',
        'email'
    ];
}

?>