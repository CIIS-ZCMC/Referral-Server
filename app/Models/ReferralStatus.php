<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralStatus extends Model
{
    use HasFactory;

    protected $table = 'referral_status';

    public $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];
}
