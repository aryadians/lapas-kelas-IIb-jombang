<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastLog extends Model
{
    protected $fillable = ['target_date', 'reason', 'sent_count', 'failed_count'];

    public function failedLogs()
    {
        return $this->hasMany(BroadcastFailedLog::class);
    }
}
