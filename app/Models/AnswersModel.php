<?php

namespace App\Models;

use CodeIgniter\Model;

class AnswersModel extends Model
{
    protected $table = 'answers';
    protected $primaryKey = 'answer_id';
    protected $allowedFields = ['user_id', 'question_id', 'answer_text', 'critical', 'major', 'minor', 'observasi', 'answer_image_path', 'deadline_date'];

    // Additional logic can be added here

    public function getDueDateForUser($userId)
    {
        return $this->select('deadline_date')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Adjust the ordering as needed
            ->first();
    }

    
}
