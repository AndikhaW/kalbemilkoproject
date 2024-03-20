<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['username', 'password', 'role', 'department_id'];

    public function getUser($login)
    {
        return $this->db->table('users')
            ->select('users.*, departments.department_name') // Include the department_name
            ->join('departments', 'departments.department_id = users.department_id', 'left')
            ->where('username', $login)
            ->get()
            ->getRowArray();
    }
}
