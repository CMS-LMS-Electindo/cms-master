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
        'email_pt',
        'add_course',
        'req_course',
        'active',
        'desc'

    ];
}
