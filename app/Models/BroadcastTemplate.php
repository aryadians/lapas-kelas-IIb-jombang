<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastTemplate extends Model
{
    protected $fillable = ['name', 'whatsapp_body', 'email_subject', 'email_body'];
}
