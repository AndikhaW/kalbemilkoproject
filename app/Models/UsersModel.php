<?php

// app/Models/UsersModel.php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['username', 'email', 'password', 'role', 'department_id'];

    // Get user data by user ID
    public function getUserById($userId)
    {
        return $this->find($userId);
    }

    // Add any additional logic or methods for user-related operations
}