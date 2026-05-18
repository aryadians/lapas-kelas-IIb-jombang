<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastFailedLog extends Model
{
    protected $fillable = ['broadcast_log_id', 'name', 'phone', 'email'];
}
