<?php

namespace App\Models;

use CodeIgniter\Model;

class ActionFSSCModel extends Model
{
    protected $table = 'actionfssc';
    protected $primaryKey = 'actionfssc_id';
    protected $allowedFields = [
        'auditfssc_id', 'answer_id', 'question_id', 'sub_department_id', 'department_id',
        'RootCuaseAnalysis', 'Correction', 'CorrectiveActionPlan', 'due_date', 'evidence_path',
        'status', 'auditor_user_id',
    ];

    public function insertOrUpdate($data)
    {
        // Check if the record already exists based on auditfssc_id
        $existingRecord = $this->where('auditfssc_id', $data['auditfssc_id'])->first();

        if ($existingRecord) {
            // Update the existing record
            $this->update($existingRecord['actionfssc_id'], $data);
            return $existingRecord['actionfssc_id'];
        } else {
            // Insert a new record
            $this->insert($data);
            return $this->getInsertID();
        }
    }

    public function hasExistingData($auditfsscId, $questionId)
    {
        $result = $this->where('auditfssc_id', $auditfsscId)
            ->where('question_id', $questionId)
            ->countAllResults();

        if ($result > 0) {
            // If data exists, return true
            return true;
        } else {
            // If no data is found, check for data with the same created_at timestamp
            $existingRecords = $this->select('auditfssc_id')
                ->where('question_id', $questionId)
                ->orderBy('created_at', 'ASC') // Order by created_at ascending
                ->findAll();

            // Get all unique auditfssc_ids
            $auditfsscIds = array_unique(array_column($existingRecords, 'auditfssc_id'));

            // Return the array of auditfssc_ids
            return $auditfsscIds;
        }
    }
}
