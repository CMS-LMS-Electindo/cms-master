<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoryid',
        'fullname',
        'shortname',
        'idnumber',
        'idsemester',
        'code_prodi',
        'code_kur',
        'nidn',
        'code_class',
        'id_lms',
    ];
}
