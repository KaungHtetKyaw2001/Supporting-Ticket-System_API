<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Status extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'status',
        'assignee_id',
        'assignee_name',
        'guid',
        'token',
    ];
}
