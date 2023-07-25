<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watcher extends Model
{
    use HasFactory;

    protected $table = 'watcher';

    public $fillable = [
        'name',
        'contact',
        'relationship'
    ];
}
