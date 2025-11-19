<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectCityPage extends Model
{
    use HasFactory;

    protected $table = 'select_city_pages';

    protected $fillable = [
        'main_heading',
        'sub_heading',
        'button_text',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function selectedCities()
    {
        return $this->hasMany(SelectCityPageCity::class);
    }
}