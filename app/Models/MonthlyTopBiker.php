<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyTopBiker extends Model
{
    protected $fillable = [
        'user_id', 'name', 'phone_last_3', 'total_duration', 'total_trips', 'month', 'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
