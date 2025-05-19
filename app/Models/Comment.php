<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class comment extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'comment',
        'guid',
        'user_id'
    ];
}
