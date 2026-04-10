<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    /** @use HasFactory<\Database\Factories\WardFactory> */
    use HasFactory;
    protected $fillable = ['code', 'name', 'administrative_level', 'province_code'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
