<?php

// app/Models/AuditsModel.php

namespace App\Models;

use CodeIgniter\Model;

class AuditsModel extends Model
{
    protected $table = 'audits';
    protected $primaryKey = 'audit_id';
    protected $allowedFields = ['audit_type_id', 'department_id', 'sub_department_id', 'auditor_user_id', 'status'];

    public function getAuditsByType($auditTypeId)
    {
        // Implement the logic to fetch audit records based on audit type
        // You may need to join tables to get department, area audit, and auditor information

        // Return the fetched audits
        return $this->db->table('audits')
            ->where('audit_type_id', $auditTypeId)
            ->get()
            ->getResultArray();
    }
}
