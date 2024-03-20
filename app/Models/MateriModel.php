<?php

// app/Models/MateriModel.php

namespace App\Models;

use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $table = 'materi';
    protected $primaryKey = 'materi_id';
    protected $allowedFields = ['materi_title', 'department_id', 'sub_department_id'];

    public function getMateriForSubDepartment($subDepartmentId)
    {
        return $this->where('sub_department_id', $subDepartmentId)->findAll();
    }
    public function getMateriForQuestion($questionId)
    {
        // Assuming there's a foreign key relationship between questions and materi
        // Adjust the column names accordingly if needed
        return $this->select('materi.*')
            ->join('questions', 'questions.materi_id = materi.materi_id')
            ->where('questions.question_id', $questionId)
            ->findAll();
    }
}
