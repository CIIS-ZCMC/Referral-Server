<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelledReferral extends Model 
{
    use HasFactory;

    protected $table = 'canceled_referral_log';

    public $fillable = [
        'remarks',
        'date',
        'deleted',
        'prevStatus'
    ];
}
