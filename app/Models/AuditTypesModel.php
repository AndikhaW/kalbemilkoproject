<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditTypesModel extends Model
{
    protected $table = 'audit_types'; // Adjust the table name if needed
    protected $primaryKey = 'audit_type_id'; // Adjust the primary key if needed
    protected $allowedFields = ['audit_type_id', 'audit_type_name'];

    // Additional model logic can be added here

    public function showDepartments($auditTypeId)
    {
        // Fetch departments based on the selected audit type
        // Use $auditTypeId to query the database and get relevant data

        // Pass data to the view
        return view('audit_types/show_departments', [
            'auditTypeId' => $auditTypeId,
            // Include other necessary data for the view
        ]);
    }
}
