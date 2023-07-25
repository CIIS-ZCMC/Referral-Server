<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'bod',
        'sex',
        'contact'
    ];
}
