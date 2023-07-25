<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObDetails extends Model
{
    use HasFactory;

    protected $table = 'obdetails';

    public $fillable = [
        'gp',
        'lmp',
        'aog',
        'edc',
        'fht',
        'fh',
        'apgar',
        'le',
        'bow'
    ];
}
