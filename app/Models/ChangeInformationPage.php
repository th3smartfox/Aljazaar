<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeInformationPage extends Model
{
    use HasFactory;

    protected $table = 'change_information_pages';

    protected $fillable = [
        'title',
        'label_account',
        'label_personal_information',
        'label_payment_method',
        'label_card_information',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}