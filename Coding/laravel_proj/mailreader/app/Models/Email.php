<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';

    protected $fillable = [
        'message_id',
        'subject',
        'from_email',
        'from_name',
        'body_html',
        'body_text',
        'mail_date'
    ];

    protected $casts = [
        'mail_date' => 'datetime'
    ];
}
