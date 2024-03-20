<?php

// app/Models/SubDepartmentsModel.php

namespace App\Models;

use CodeIgniter\Model;

class SubDepartmentsModel extends Model
{
    protected $table = 'sub_departments';
    protected $primaryKey = 'sub_department_id';
    protected $allowedFields = ['sub_department_name', 'department_id'];

    public function getSubDepartmentsForDepartment($departmentId)
    {
        // Adjust the column names if needed
        $subDepartments = $this->where('department_id', $departmentId)->findAll();

        return $subDepartments ? $subDepartments : [];
    }

    public function getQuestionsForSubDepartment($subDepartmentId)
    {
        // Adjust the column names if needed
        return $this->db->table('questions')
            ->where('sub_department_id', $subDepartmentId)
            ->get()
            ->getResultArray();
    }
}
