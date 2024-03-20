<?php

// app/Controllers/PenilaianController.php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DepartmentsModel;
use App\Models\SubDepartmentsModel;
use App\Models\QuestionsModel;
use App\Models\SubKlausulsModel;
use App\Models\MateriModel;
use App\Models\AnswersModel;
use App\Models\AuditFSSCModel;
use App\Models\AuthModel;
use App\Models\CatchFSSCModel;


class PenilaianController extends BaseController
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

        // Fetch audit types from the database
        $auditTypesModel = new \App\Models\AuditTypesModel();
        $auditTypes = $auditTypesModel->findAll();

        // Pass data to the view
        return view('penilaian', [
            'userData' => $userData,
            'auditTypes' => $auditTypes,
        ]);
    }

    public function showDepartments($auditTypeId)
    {
        // Check if the user is logged in
        $session = session();
        if (!$session->has('user_data')) {
            return redirect()->to('/login');
        }

        // Retrieve user data from session
        $userData = $session->get('user_data');

        // Check if the user has a department name
        if (!isset($userData['department_name'])) {
            return redirect()->to('/dashboard')->with('error', 'User department information not available');
        }

        // Fetch departments for the given department name
        $departmentsModel = new DepartmentsModel();
        $departments = $departmentsModel->getDepartmentsForName();

        log_message('debug', 'User Data: ' . print_r($userData, true));
        log_message('debug', 'Departments: ' . print_r($departments, true));

        // Pass data to the view
        return view('show_departments', [
            'auditTypeId' => $auditTypeId,
            'userData' => $userData,
            'departments' => $departments,
        ]);
    }


    public function getSubDepartments($departmentId)
    {
        // Check if the user is logged in
        $session = session();
        if (!$session->has('user_data')) {
            return redirect()->to('/login');
        }

        // Fetch sub-departments for the selected department
        $subDepartmentsModel = new SubDepartmentsModel();
        $subDepartments = $subDepartmentsModel->getSubDepartmentsForDepartment($departmentId);

        // Return sub-departments as JSON response
        return $this->response->setJSON($subDepartments);
    }

    public function showQuestions($subDepartmentId)
    {
        // Load your QuestionsModel here
        $questionsModel = new \App\Models\QuestionsModel();

        // Get questions for the sub department
        $questions = $questionsModel->getQuestionsForSubDepartment($subDepartmentId);

        // Load your SubKlausulsModel here
        $subKlausulsModel = new SubKlausulsModel();

        // Load your MateriModel here
        $materiModel = new MateriModel();

        // Fetch the related sub_klausuls and materi for each question
        foreach ($questions as &$question) {
            $questionId = $question['question_id'];

            // Fetch sub_klausuls for the question using the correct ID
            $question['sub_klausuls'] = $subKlausulsModel->getSubKlausulsForQuestion($questionId);

            // Fetch materi for the sub department
            $subDepartmentId = $question['sub_department_id'];
            $question['materi'] = $materiModel->getMateriForQuestion($questionId);

            // Log the retrieved sub_klausuls and materi
            log_message('debug', 'Retrieved sub_klausuls: ' . print_r($question['sub_klausuls'], true));
            log_message('debug', 'Retrieved materi: ' . print_r($question['materi'], true));
        }

        // Retrieve user data from session
        $session = session();
        $userData = $session->get('user_data');

        // Pass the data to the view, including $subDepartmentId and $userData
        return view('show_questions', ['questions' => $questions, 'subDepartmentId' => $subDepartmentId, 'userData' => $userData]);
    }




    public function showQuestionsByMateri($materiId)
    {
        // Load your QuestionsModel here
        $questionsModel = new \App\Models\QuestionsModel();

        // Get questions for the materi
        $questions = $questionsModel->getQuestionsForMateri($materiId);

        // Load your MateriModel here
        $materiModel = new \App\Models\MateriModel();

        // Get Materi information
        $materi = $materiModel->find($materiId);

        // Pass the data to the view
        return view('show_questions', [
            'questions' => $questions,
            'materi' => $materi, // Pass Materi information to the view
        ]);
    }


    protected $answersModel;
    protected $auditFSSCModel;
    protected $authModel;

    public function __construct()
    {
        // Load the AnswersModel in the constructor
        $this->answersModel = new \App\Models\AnswersModel();
        $this->auditFSSCModel = new \App\Models\AuditFSSCModel();
        $this->authModel = new AuthModel();
    }

    public function processAnswers($subDepartmentId)
    {
        // Check if the request is a POST request
        if ($this->request->getMethod() === 'post') {

            $questionsModel = new \App\Models\QuestionsModel();
            // Get user ID from the session
            $session = session();
            $userId = $session->get('user_data.user_id');

            // Assuming you have the question IDs, adjust the following line accordingly
            $questionIds = $this->request->getPost('question_id'); // Replace with the actual question IDs

            foreach ($questionIds as $questionId) {
                // Get form data for each question
                $answerText = $this->request->getPost('answer_text_' . $questionId);
                $answerType = $this->request->getPost('answer_type_' . $questionId);
                $deadlineDate = $this->request->getPost('deadline_' . $questionId);

                $imagePath = null;

                // Process file upload
                // $imageFile = $this->request->getFile('answer_image_' . $questionId);
                // Process file upload
                var_dump($this->request->getFiles());

                $imageFile = $this->request->getFile('answer_image_' . $questionId);

                // Debugging: Display file upload information
                var_dump($imageFile);

                // Check if a file was uploaded
                $imageFile = $this->request->getFile('answer_image_' . $questionId);

                // Debugging: Display file upload information
                var_dump($imageFile);

                // Check if a file was uploaded
                if ($imageFile) {
                    // Debugging: Display file details in log
                    log_message('debug', 'File details for question ' . $questionId . ': ' . json_encode([
                        'isValid' => $imageFile->isValid(),
                        'hasMoved' => $imageFile->hasMoved(),
                        'getError' => $imageFile->getError(),
                        'getErrorString' => $imageFile->getErrorString(),
                    ]));

                    if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                        // Set the upload path
                        $uploadsPath = WRITEPATH . 'uploads/';

                        // Move the uploaded file to the uploads directory
                        $imageName = $imageFile->getRandomName();
                        $imageFile->move($uploadsPath, $imageName);

                        // Set the image path in case of successful upload
                        $imagePath = 'uploads/' . $imageName;
                    } else {
                        // Log detailed upload errors
                        log_message('error', 'File upload error for question ' . $questionId . ': ' . $imageFile->getErrorString() . ' (' . $imageFile->getError() . ')');
                    }
                } else {
                    // Log a message indicating that no file was uploaded
                    log_message('error', 'No file uploaded for question ' . $questionId);
                }

                // Insert data into the 'answers' table for each question
                $data = [
                    'user_id' => $userId,
                    'question_id' => $questionId,
                    'answer_text' => $answerText,
                    'answer_type' => $answerType,
                    // 'deadline_date' => $deadlineDate,
                    'critical' => ($answerType === 'critical') ? 1 : 0,
                    'major' => ($answerType === 'major') ? 1 : 0,
                    'minor' => ($answerType === 'minor') ? 1 : 0,
                    'observasi' => ($answerType === 'observasi') ? 1 : 0,
                    'image_path' => $imagePath,
                ];

                // Insert data into the 'answers' table for each question
                $this->answersModel->insert($data);


                // Get the answer ID for the current question
                $answerId = $this->answersModel->insertID();

                // Get the due date for the user
                // $dueDateResult = $this->answersModel->select('deadline_date')->find($answerId);

                $dueDate = null;

                // if ($dueDateResult && array_key_exists('deadline_date', $dueDateResult)) {
                //     $dueDate = $dueDateResult['deadline_date'];
                // }

                // Get the user data
                $user = $this->authModel->find($userId);

                $question = $questionsModel->find($questionId);

                // Insert data into the 'auditfssc' table
                $auditFSSCData = [
                    'answer_id' => $answerId,
                    'question_id' => $questionId,
                    'sub_department_id' => $subDepartmentId,
                    'department_id' => $question['department_id'],
                    'auditor_user_id' => $userId,
                    'status' => 'In Progress',
                    // 'due_date' => $dueDate,
                    'created_at' => date('Y-m-d H:i:s'),  // Include 'created_at' field
                ];



                // Insert data into the 'auditfssc' table
                $this->auditFSSCModel->insert($auditFSSCData);


                // $this->auditFSSCModel->insert($auditFSSCData);
            }

            // Redirect to the dashboard
            return redirect()->to("/dashboard");
        }



        // Handle cases where the request is not a POST request
        // You can add additional logic or redirect as needed
        return redirect()->back();
    }
}
