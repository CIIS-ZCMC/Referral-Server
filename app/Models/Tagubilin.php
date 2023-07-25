<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagubilin extends Model
{
    use HasFactory;

    protected $table = 'tagubilin';

    public $fillable = [
        'FK_tagubilin_details_ID',
        'FK_result_ID',
        'FK_medication_ID',
        'FK_breastfeed_ID',
        'FK_follow_up_ID'
    ];
}
