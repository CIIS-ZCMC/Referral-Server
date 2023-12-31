<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUploads extends Model
{
    use HasFactory;

    protected $table ='files';

    public $fillable = [
        'url',
        'details',
        'date'
    ];
}
