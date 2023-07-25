<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagubilinDetails extends Model
{
    use HasFactory;

    protected $table ='tagubilindetails';

    public $fillable = [
        'patient_name',
        'birthdate',
        'gender',
        'address',
        'ward',
        'hrn',
        'admission_date',
        'disch_date',
        'disch_diagnosis',
        'operation',
        'surgeon',
        'operation_date',
        'health',
        'health_others',
        'instructions'  
    ];
}
