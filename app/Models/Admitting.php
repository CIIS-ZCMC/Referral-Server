<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admitting extends Model
{
    use HasFactory;

    protected $table = 'admitting';

    public $fillable = [
        'admitted',
        'type',
        'disposition',
        'temperature',
        'blood_pressure',
        'respiratory_rate',
        'pulse_rate',
        'oxygen',
        'o2_sat',
        'gcs',
        'chief_complaints',
        'diagnosis',
        'endorsement',
        'referring_ROD',
        'reason',
        'patient_history',
        'pertinent_pe',
        'lvf',
        'labs',
        'meds'
    ];
}
