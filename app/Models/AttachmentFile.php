<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachment_file',
        'guid'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

