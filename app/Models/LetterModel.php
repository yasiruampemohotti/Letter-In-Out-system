<?php

namespace App\Models;

use CodeIgniter\Model;

class LetterModel extends Model
{
    protected $table = 'letters';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'sender_address', 'receiver_address','reference_number','letter_status','location'];
}
