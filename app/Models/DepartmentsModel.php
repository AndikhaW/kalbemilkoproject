<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentsModel extends Model
{
    protected $table = 'departments';

    public function getDepartmentsForName()
    {
        return $this->findAll();
    }
}
