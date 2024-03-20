<?php

namespace App\Models;

use CodeIgniter\Model;

class CatchFSSCModel extends Model
{
    protected $table = 'catchfssc';
    protected $primaryKey = 'fssc_id';
    protected $allowedFields = ['auditfssc_id', 'auditor_user_id', 'created_at'];

    // You can add more configurations or methods if needed
}
