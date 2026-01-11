<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLogs extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'visited_at'];
}
