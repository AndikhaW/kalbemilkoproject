<?php

// SubKlausulsModel.php

namespace App\Models;

use CodeIgniter\Model;

class SubKlausulsModel extends Model
{
    protected $table = 'sub_klausuls';
    protected $primaryKey = 'sub_klausul_id';
    protected $allowedFields = ['sub_klausul_name', 'klausul_id'];

    public function getSubKlausulsForQuestion($questionId)
    {
        return $this->db->table('question_klausul_subklausul')
            ->where('question_id', $questionId)
            ->join('sub_klausuls', 'sub_klausuls.subklausul_id = question_klausul_subklausul.subklausul_id')
            ->get()
            ->getResultArray();
    }
    
}
