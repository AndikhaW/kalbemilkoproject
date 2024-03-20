<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuditsSeeder extends Seeder
{
    public function run()
    {
        // Uncomment the following line to truncate the table and delete existing data
        // $this->db->table('audits')->truncate();

        // Fetch some sample data to use for seeding (replace with your actual logic)
        $usersModel = new \App\Models\UsersModel();
        $answersModel = new \App\Models\AnswersModel();

        // Replace '1' with the actual user ID of the logged-in user
        $loggedInUserId = 1;

        // Replace 'FSSC' with the actual audit type ID or fetch it from the database
        $auditTypeId = 'FSSC';

        // Replace 'In Progress' with the actual default status
        $status = 'In Progress';

        // Fetch the due date from the answers table (replace with your actual logic)
        $dueDate = $answersModel->getDueDateForUser($loggedInUserId);

        $data = [
            [
                'auditor_user_id' => $loggedInUserId,
                'evaluated_user_id' => $loggedInUserId, // Replace with the actual user ID
                'audit_type_id' => $auditTypeId,
                'status' => $status,
                'due_date' => $dueDate,
            ],
            // Add more sample data as needed
        ];

        // Insert the data
        $this->db->table('audits')->insertBatch($data);
    }
}
