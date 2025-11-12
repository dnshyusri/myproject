<?php namespace App\Models;

use CodeIgniter\Model;

class subjekFailAmModel extends Model{
    protected $table = 'tbl_subjek';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'ABJAD',
        'KodSubjek',
        'SUBJEK',
    ];
    public function getKodSubjekBySubjek($subjek)
    {
        return $this->where('SUBJEK', $subjek)->first();
    }
}
?>