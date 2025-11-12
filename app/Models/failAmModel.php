<?php namespace App\Models;

use CodeIgniter\Model;

class failAmModel extends Model{
    protected $table = 'tbl_failam';
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
        'Catatan'
    ];
}

?>

