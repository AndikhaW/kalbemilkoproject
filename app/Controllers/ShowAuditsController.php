<?php

namespace App\Controllers;

use App\Models\AuditFSSCModel;
use App\Models\AnswersModel;
use App\Models\QuestionsModel;
use App\Models\UsersModel;
use App\Models\MateriModel;
use App\Models\ActionFSSCModel;

class ShowAuditsController extends BaseController
{
    public function index()
    {
        $auditModel = new AuditFSSCModel();
        $audits = $auditModel->findAll();

        return view('show_audits', ['audits' => $audits]);
    }

    public function getAuditDetails($auditfsscId)
    {
        $auditModel = new AuditFSSCModel();
        $answersModel = new AnswersModel();
        $questionsModel = new QuestionsModel();
        $materiModel = new MateriModel();
        $actionModel = new ActionFSSCModel();

        // Retrieve user data from session
        $session = session();
        $userData = $session->get('user_data');

        // Fetch auditfssc_id from POST data if the form is submitted
        $auditfsscId = $this->request->getPost('auditfssc_id', FILTER_SANITIZE_NUMBER_INT) ?? $auditfsscId;

        $auditDetails = $auditModel->find($auditfsscId);

        if ($auditDetails) {
            $departmentId = $auditDetails['department_id'] ?? null;
            $auditorUserId = $auditDetails['auditor_user_id'] ?? null;

            if (!empty($departmentId)) {
                $relatedAudits = $auditModel
                    ->where('department_id', $departmentId)
                    ->where('auditor_user_id', $auditorUserId)
                    ->findAll();

                log_message('debug', 'Related Audits: ' . json_encode($relatedAudits));

                $data = [];
                $viewOnly = false;

                foreach ($relatedAudits as $relatedAudit) {
                    $answerId = $relatedAudit['answer_id'] ?? null;
                    $answerDetails = $answersModel
                        ->where('answer_id', $answerId)
                        ->findAll();
                
                    log_message('debug', 'Answer Details: ' . json_encode($answerDetails));
                
                    foreach ($answerDetails as $answer) {
                        $questionId = isset($answer['question_id']) ? $answer['question_id'] : null;
                        $questionDetails = $questionsModel
                            ->where('question_id', $questionId)
                            ->first();
                
                        log_message('debug', 'Question Details: ' . json_encode($questionDetails));
                
                        if ($questionDetails) {
                            $answerType = $this->determineAnswerType($answer);
                
                            $materiDetails = $materiModel
                                ->where('materi_id', $questionDetails['materi_id'])
                                ->first();
                
                                if (!empty($materiDetails['materi_id'])) {
                                    // Fetch RootCauseAnalysis, Correction, CorrectiveActionPlan, and due_date connected to the data detail
                                    $actionDetails = $actionModel
                                        ->where('auditfssc_id', $relatedAudit['auditfssc_id'])
                                        ->where('question_id', $questionId)
                                        ->first();
                    
                                    // Initialize variables
                                    $rootCauseAnalysisValue = '';
                                    $correctionValue = '';
                                    $correctiveActionPlanValue = '';
                                    $dueDateValue = '';
                    
                                    if ($actionDetails) {
                                        $rootCauseAnalysisValue = $actionDetails['RootCuaseAnalysis'] ?? '';
                                        $correctionValue = $actionDetails['Correction'] ?? '';
                                        $correctiveActionPlanValue = $actionDetails['CorrectiveActionPlan'] ?? '';
                                        $dueDateValue = $actionDetails['due_date'] ?? '';
                                    }

                                    log_message('debug', 'Root Cause Analysis Value: ' . $rootCauseAnalysisValue);
                                    log_message('debug', 'Correction Value: ' . $correctionValue);
                                    log_message('debug', 'Corrective Action Plan Value: ' . $correctiveActionPlanValue);
                                    log_message('debug', 'Due Date Value: ' . $dueDateValue);
                    
                                    // Add data to the array
                                    $data[$questionDetails['materi_id']][] = [
                                        'question_id' => $questionDetails['question_id'],
                                        'materi_name' => $materiDetails['materi_title'],
                                        'question_text' => $questionDetails['question_text'],
                                        'answer_text' => $answer['answer_text'],
                                        'answer_type' => $answerType,
                                        'rootCauseAnalysisValue' => $rootCauseAnalysisValue,
                                        'correctionValue' => $correctionValue,
                                        'correctiveActionPlanValue' => $correctiveActionPlanValue,
                                        'dueDateValue' => $dueDateValue,
                                    ];
                                }
                            $hasExistingData = $actionModel->hasExistingData($auditfsscId, $questionId);
                            if ($hasExistingData) {
                                $viewOnly = true;
                            }
                        }
                    }
                }
                
                log_message('debug', 'View Only Mode: ' . ($viewOnly ? 'true' : 'false'));

                return view('audit_details', [
                    'auditDetails' => $data,
                    'auditorName' => $this->getAuditorName($auditorUserId),
                    'auditfsscId' => $auditfsscId,
                    'userData' => $userData,
                    'viewOnly' => $viewOnly,
                ]);
            } else {
                return redirect()->to('show_audits')->with('error', 'Audit details not found or missing department_id.');
            }
        } else {
            return redirect()->to('show_audits')->with('error', 'Audit details not found.');
        }
    }




    public function submitAuditDetails()
    {
        // Initialize $viewOnly
        $viewOnly = false;

        // Check if the form is submitted
        if ($this->request->getMethod() === 'post') {
            // Load necessary models
            $auditModel = new AuditFSSCModel();
            $actionModel = new ActionFSSCModel();

            // Fetch auditfssc_id from POST data
            $auditfsscId = $this->request->getPost('auditfssc_id');

            // Fetch audit details based on the selected auditfssc_id
            $auditDetails = $auditModel
                ->select('auditfssc_id, department_id, auditor_user_id')
                ->where('auditfssc_id', $auditfsscId)
                ->first(); // Use first() to get a single result

            // Check if 'department_id' is set in $auditDetails
            if ($auditDetails && isset($auditDetails['department_id'])) {
                // Fetch additional details based on the retrieved audit data
                $relatedAudits = $auditModel
                    ->where('department_id', $auditDetails['department_id'])
                    ->where('auditor_user_id', $auditDetails['auditor_user_id'])
                    ->findAll();

                foreach ($relatedAudits as $index => $relatedAudit) {
                    $questionId = $relatedAudit['question_id'];

                    // Check if data exists for the current question
                    $hasExistingData = $actionModel->hasExistingData($relatedAudit['auditfssc_id'], $questionId);

                    // Set view-only mode based on existing data
                    if ($hasExistingData) {
                        // Existing data is present, user is in view-only mode for this question
                        $viewOnly = true;
                    } else {
                        // No existing data, so view-only mode is false
                        $viewOnly = false;
                    }

                    $rootCauseAnalysisArray = $this->request->getPost('root_cause_analysis');
                    $correctionArray = $this->request->getPost('correction');
                    $correctiveActionPlanArray = $this->request->getPost('corrective_action_plan');
                    $dueDateArray = $this->request->getPost('due_date');

                    // Get values for the current question from arrays
                    $rootCauseAnalysis = $rootCauseAnalysisArray[$index] ?? null;
                    $correction = $correctionArray[$index] ?? null;
                    $correctiveActionPlan = $correctiveActionPlanArray[$index] ?? null;
                    $dueDate = $dueDateArray[$index] ?? null;

                    $actionData = [
                        'auditfssc_id' => $relatedAudit['auditfssc_id'],
                        'answer_id' => $relatedAudit['answer_id'],
                        'question_id' => $relatedAudit['question_id'],
                        'sub_department_id' => $relatedAudit['sub_department_id'],
                        'department_id' => $relatedAudit['department_id'],
                        'RootCuaseAnalysis' => $rootCauseAnalysis,
                        'Correction' => $correction,
                        'CorrectiveActionPlan' => $correctiveActionPlan,
                        'due_date' => $dueDate,
                        'evidence_path' => $this->request->getPost('evidence_' . $questionId),
                        'status' => 'In Progress',
                        'auditor_user_id' => $relatedAudit['auditor_user_id'],
                    ];

                    // Call insertOrUpdate with the constructed $actionData array
                    $actionModel->insertOrUpdate($actionData);

                    // Break out of the loop if view-only mode is set to true
                    if ($viewOnly) {
                        break;
                    }
                }

                return redirect()->to(base_url('show_audits'))->with('success', 'Audit details submitted successfully.');
            } else {
                // Handle case where audit details are not found or 'department_id' is not set
                return redirect()->to('show_audits')->with('error', 'Audit details not found or missing department_id.');
            }
        } else {
            // Redirect or display an error message for unauthorized access
            return redirect()->to('show_audits')->with('error', 'Unauthorized access.');
        }
    }






    private function getAuditorName($userId)
    {
        if (isset($userId)) {
            $usersModel = new UsersModel();
            $user = $usersModel->find($userId);

            return $user ? $user['username'] : 'N/A';
        }

        return 'N/A';
    }


    private function handleFileUpload($inputName)
    {
        $file = $this->request->getFile($inputName);

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            return $newName;
        }

        return null;
    }


    private function determineAnswerType($answer)
    {
        if ($answer['critical'] == 1) {
            return 'Critical';
        } elseif ($answer['major'] == 1) {
            return 'Major';
        } elseif ($answer['minor'] == 1) {
            return 'Minor';
        } elseif ($answer['observasi'] == 1) {
            return 'Observasi';
        } else {
            return 'N/A';
        }
    }
}
