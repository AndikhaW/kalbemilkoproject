<?php
// app/Models/QuestionKlausulSubklausulModel.php

namespace App\Models;

use CodeIgniter\Model;

class QuestionKlausulSubklausulModel extends Model
{
    protected $table = 'question_klausul_subklausul';
    protected $primaryKey = 'id';
    protected $allowedFields = ['question_id', 'klausul_id', 'subklausul_id'];

    public function getSubKlausulsForQuestion($questionId)
    {
        return $this->select('sub_klausuls.sub_klausul_name, klausuls.klausul_number, sub_klausuls.subklausul_number')
                    ->join('klausuls', 'klausuls.klausul_id = question_klausul_subklausul.klausul_id')
                    ->join('sub_klausuls', 'sub_klausuls.sub_klausul_id = question_klausul_subklausul.subklausul_id')
                    ->where('question_id', $questionId)
                    ->findAll();
    }
}

