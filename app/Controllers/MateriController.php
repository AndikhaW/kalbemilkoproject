<?php

// app/Controllers/MateriController.php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MateriModel;
use App\Models\QuestionsModel;

class MateriController extends BaseController
{
    public function index()
    {
        // Add authentication check here to ensure the user is logged in
        $session = session();
        if (!$session->has('user_data')) {
            return redirect()->to('/login');
        }

        // Retrieve user data from session
        $userData = $session->get('user_data');

        // Fetch materi from the database
        $materiModel = new MateriModel();
        $materi = $materiModel->findAll();

        // Pass data to the view
        return view('materi', [
            'userData' => $userData,
            'materi' => $materi,
        ]);
    }

    public function showQuestionsByMateri($materiId)
    {
        // Load your QuestionsModel here
        $questionsModel = new QuestionsModel();

        // Get questions for the materi
        $questions = $questionsModel->getQuestionsForMateri($materiId);

        // Pass the data to the view
        return view('show_questions_by_materi', ['questions' => $questions]);
    }
}
