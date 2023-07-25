<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Covid extends Model
{
    use HasFactory;

    protected $table ='covid';

    public $fillable = [
        'swab_type',
        'result',
        'swab_date',
        'result_date'
    ];
}
