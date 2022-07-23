<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code_pt',
        'nama_app',
        'nama_pt',
        'domain_pt',
        'domain_lms',
        'domain_api',
        'email_pt',
        'add_course',
        'req_course',
        'active',
        'desc',
        'token_lms',
        'token_auth',
        'token_sia',
        'app_sia',
        'logo',
        'logo_gelap',
        'logo_terang',

    ];
}
