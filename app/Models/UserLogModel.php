<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLogModel extends Model
{
    protected $table = 'user_log'; // Table name
    protected $primaryKey = 'id';  // Primary key of the table
    protected $allowedFields = ['user_email', 'letter_id', 'timestamp']; // Columns that can be inserted/updated
}
