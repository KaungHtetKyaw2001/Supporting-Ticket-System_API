<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
// use Spatie\MediaLibrary\HasMedia;

class Ticket extends Model
{
    use HasFactory, HasApiTokens;

    // protected $ticketTable = "ticket";

    protected $fillable = [
        'title',
        'content',
        'message',
        'comment',
        'token',
        'status',
        'guid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function priorities()
    {
        return $this->belongsTo(Priority::class);
    }

    public function permissions()
    {
        return $this->belongsTo(Permission::class);
    }

    public function attachment_files()
    {
        return $this->hasMany(AttachmentFile::class);
    }



}

class Status extends Model
{
    protected $fillable = [
        'status',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}

class Priority extends Model
{
    protected $fillable = [
        'priority',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}

class Permission extends Model
{
    protected $fillable = [
        'permission',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}

class AttachmentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachment_file',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
