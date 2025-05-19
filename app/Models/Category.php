<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class category extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'category',
        'token',
        'guid'
    ];

    /**
     * Get the user categories associated with this category.
     */
    public function user_categories()
    {
        return $this->hasMany(User_Category::class);
    }


}

