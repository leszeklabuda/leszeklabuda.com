<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table = 'password_resets';

    protected $allowedFields = [
        'user_id',
        'token'
    ];

    protected $returnType    = \App\Entities\PasswordReset::class;
    protected $useTimestamps = true;
}
