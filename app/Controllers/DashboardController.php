<?php

// app/Controllers/DashboardController.php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AuditsModel;
use App\Models\AnswersModel;
use App\Models\QuestionsModel;
use App\Models\AuthModel;
use App\Models\UsersModel;
use App\Models\DepartmentsModel;
use App\Models\AuditFSSCModel;

class DashboardController extends BaseController
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

        // Pass user data to the view
        return view('dashboard', ['userData' => $userData]);
    }


    public function showAudits()
    {
        $session = session();
        if (!$session->has('user_data')) {
            return redirect()->to('/login');
        }

        // Retrieve user data from session
        $userData = $session->get('user_data');

        // Log user data
        log_message('debug', 'User Data: ' . print_r($userData, true));

        // Instantiate UsersModel
        $usersModel = new UsersModel();

        // Get user data by user ID
        $user = $usersModel->getUserById($userData['user_id']);

        // Check if the user has a valid department ID
        if (!$user || !array_key_exists('department_id', $user)) {
            // Log that 'department_id' is not found
            log_message('debug', 'Department ID not found for user ID: ' . $userData['user_id']);
            // Show an empty table or take other appropriate action
            return view('show_audits', ['audits' => []]);
        }

        // Now you have the correct 'department_id'
        $userDepartmentId = $user['department_id'];

        // Log user department ID
        log_message('debug', 'User Department ID: ' . $userDepartmentId);

        // Retrieve audit data based on the user's department
        $auditFSSCModel = new \App\Models\AuditFSSCModel();
        $uniqueCombinations = $auditFSSCModel
            ->distinct()
            ->select('sub_department_id, department_id, auditor_user_id')
            ->where('auditfssc.department_id', $userDepartmentId)
            ->findAll();

        $audits = [];
        foreach ($uniqueCombinations as $combination) {
            $audit = $auditFSSCModel
                ->select('auditfssc.*, answers.*, questions.*, sub_departments.*, departments.department_name, auditors.username as nama_auditor')
                ->join('answers', 'answers.answer_id = auditfssc.answer_id')
                ->join('questions', 'questions.question_id = auditfssc.question_id')
                ->join('sub_departments', 'sub_departments.sub_department_id = auditfssc.sub_department_id')
                ->join('departments', 'departments.department_id = auditfssc.department_id')
                ->join('users as auditors', 'auditors.user_id = auditfssc.auditor_user_id')
                ->where([
                    'auditfssc.sub_department_id' => $combination['sub_department_id'],
                    'auditfssc.department_id' => $combination['department_id'],
                    'auditfssc.auditor_user_id' => $combination['auditor_user_id'],
                ])
                ->findAll();

            if (!empty($audit)) {
                $audits[] = $audit[0];
            }
        }

        // Log retrieved audits
        log_message('debug', 'Retrieved audits: ' . print_r($audits, true));

        // Pass audits to the view
        // return view('show_audits', ['audits' => $audits]);
        return view('show_audits', ['audits' => $audits, 'userData' => $userData]);
    }
}
