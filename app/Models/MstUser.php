<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'usertype',
        'username',
        'fullname',
        'code_prodi',
        'code_fakultas',
        'id_lms',
    ];
    public function Prodi(){
        return $this->hasOne(Category::class,'code_sia','code_prodi');
    }
}
