<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $table = 'followup';

    public $fillable = [
        'follow_up_date',
        'follow_up_time',
        'need_to_bring',
        'nurse',
        'resident'
    ];
}
