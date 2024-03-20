<?php

// app/Controllers/SubDepartmentsController.php

namespace App\Controllers;

use CodeIgniter\Controller;

class SubDepartmentsController extends BaseController
{
    public function showQuestions($departmentId, $subDepartmentId)
    {
        // Fetch questions for the selected sub-department
        $questionsModel = new \App\Models\QuestionsModel();
        $questions = $questionsModel->getQuestionsForSubDepartment($subDepartmentId);

        // Pass data to the view
        return view('show_questions', [
            'departmentId' => $departmentId,
            'subDepartmentId' => $subDepartmentId,
            'questions' => $questions,
        ]);
    }
}
