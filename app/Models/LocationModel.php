<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'locations'; // Table name
    protected $primaryKey = 'id';  // Primary key of the table
    protected $allowedFields = ['location_name', 'timestamp']; // Columns that can be inserted/updated
}
