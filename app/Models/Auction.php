<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory;

    /**
     * Relationships
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
