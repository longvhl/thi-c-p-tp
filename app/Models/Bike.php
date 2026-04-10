<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Bike extends Model
{
    /** @use HasFactory<\Database\Factories\BikeFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = ['type', 'bike_number', 'status', 'current_station', 'unit_price'];

    public function station()
    {
        return $this->belongsTo(Station::class, 'current_station');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
