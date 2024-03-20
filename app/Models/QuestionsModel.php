<?php
// app/Models/QuestionsModel.php

namespace App\Models;

use CodeIgniter\Model;

class QuestionsModel extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'question_id';
    protected $allowedFields = ['department_id', 'sub_department_id', 'materi_id', 'question_text'];

    // Add any other necessary properties and methods

    public function getQuestionsForSubDepartment($subDepartmentId)
    {
        // Adjust the column names if needed
        return $this->where('sub_department_id', $subDepartmentId)->findAll();
    }
    public function getQuestionsForMateri($materiId)
    {
        return $this->where('materi_id', $materiId)
            ->findAll();
    }
    public function getSubKlausulsForQuestion($questionId)
    {
        // Load QuestionKlausulSubklausulModel
        $questionKlausulSubklausulModel = new QuestionKlausulSubklausulModel();

        // Fetch sub_klausuls for the given question ID
        return $questionKlausulSubklausulModel->getSubKlausulsForQuestion($questionId);
    }
}
