<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class permission extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'permission',
        'assignee_id',
        'assignee_name',
        'guid',
        'token',
    ];
}
