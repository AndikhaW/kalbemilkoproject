<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditFSSCModel extends Model
{
    protected $table = 'auditfssc'; // Replace with your actual table name
    protected $primaryKey = 'auditfssc_id'; // Replace with your actual primary key field
    protected $allowedFields = [
        'answer_id',
        'question_id',
        'sub_department_id',
        'department_id',
        'auditor_user_id',
        'status',
    ];

}
