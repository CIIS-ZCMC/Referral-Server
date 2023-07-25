<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient';

    public $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'gender',
        'birthdate',
        'civil_status',
        'nationality',
        'religion',
        'occupation',
        'height',
        'weight',
        'philhealth_no'
    ];
}
