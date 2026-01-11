<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $primaryKey = 'id'; // Explicitly set primary key
    public $incrementing = false; // Because session IDs are strings (not auto-incremented)
    protected $table = 'sessions';
    public $timestamps = false;

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
