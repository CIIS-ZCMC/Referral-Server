<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medication';

    public $fillable = [
        'medicine',
        'dosage',
        'schedule',
        'quantity'
    ];
}
