<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referrals extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    public $fillable = [
        'status',
        'request_edit',
        'request_date',
        'updated_at'
    ];
}
