<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformationPage extends Model
{
    use HasFactory;

    protected $table = 'personal_information_pages';

    protected $fillable = [
        'title',
        'label_name',
        'label_email',
        'label_phone',
        'button_cancel',
        'button_save',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}