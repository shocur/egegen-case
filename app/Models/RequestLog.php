<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'method',
        'url',
        'status_code'
    ];
}
