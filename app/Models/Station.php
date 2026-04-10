<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    /** @use HasFactory<\Database\Factories\StationFactory> */
    use HasFactory;
    protected $fillable = ['name', 'code', 'image_url', 'ward_id'];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
