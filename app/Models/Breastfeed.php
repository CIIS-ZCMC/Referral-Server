<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breastfeed extends Model
{
    use HasFactory;

    protected $table = 'breastfeed';

    public $fillable = [
        'date',
        'from_to',
        'yes',
        'reason_for_no',
        'management',
        'attended'
    ];
}
