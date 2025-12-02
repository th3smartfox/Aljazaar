<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignupPage extends Model
{
    use HasFactory;

    protected $table = 'signup_pages';

    protected $fillable = [
        'title',
        'sub_title',
        'full_name_label',
        'full_name_hint',
        'phone_number_label',
        'phone_number_hint',
        'password_label',
        'password_hint',
        'sign_up_button_text',
        'already_have_account_text',
        'login_button_text',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
