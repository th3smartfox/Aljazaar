<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'address_title',
        'address_line',
        'street_number',
        'latitude',
        'longitude',
        'landmark',
        'nearest_landmark',
        'city_id',
        'is_default',
    ];


    protected $casts = [
        'is_default' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(\Nnjeim\World\Models\City::class, 'city_id');
    }
}
