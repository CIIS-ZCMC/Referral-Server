<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $table = 'register_date';

    public $fillable = [
        'register_date',
        'disch_diagnosis',
        'final_diagnosis',
        'disch_date'
    ];
}
