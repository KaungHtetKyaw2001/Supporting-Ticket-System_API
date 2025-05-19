<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\TicketNotification;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Facades\Notification;

class testNotificationController extends Controller
{
    public function index()
    {
        $users = User::get();
        $post = [
            'title' => 'post title',
            'slug' => 'post-slug', 
        ];
    
        foreach ($users as $user) {
            $user->notify(new TicketNotification($post));
        }
    
        dd('Done');
    }
}
