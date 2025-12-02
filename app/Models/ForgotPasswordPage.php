<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForgotPasswordPage extends Model
{
    use HasFactory;

    protected $table = 'forgot_password_pages';

    protected $fillable = [
        'title',
        'sub_title',
        'email_or_phone_label',
        'email_or_phone_hint',
        'continue_button_text',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
