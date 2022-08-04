<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailConfirmationModel extends Model
{
    protected $table = 'email_confirmations';

    protected $allowedFields = [
        'user_id',
        'token'
    ];

    protected $returnType    = \App\Entities\EmailConfirmation::class;
    protected $useTimestamps = true;
}
