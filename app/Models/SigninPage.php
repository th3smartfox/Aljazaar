<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SigninPage extends Model
{
    use HasFactory;

    protected $table = 'signin_pages';

    protected $fillable = [
        'title',
        'sub_title',
        'email_or_phone_label',
        'email_or_phone_hint',
        'password_label',
        'password_hint',
        'forgot_password_text',
        'login_button_text',
        'dont_have_account_text',
        'sign_up_text',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
