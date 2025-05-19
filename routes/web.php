<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSNotification;
use App\Http\Controllers\NotificationSendController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\testNotificationController::class,'index']);
Route::get('/ticketcreated',function(){
    \Illuminate\Support\Facades\Mail::send(new App\Mail\TicketCreate());
    return view('welcome');
}); 
Route::get('/ticketupdated',function(){
    \Illuminate\Support\Facades\Mail::send(new App\Mail\TicketUpdate());
    return view('welcome');
}); 
Route::get('/ticketdeleted',function(){
    \Illuminate\Support\Facades\Mail::send(new App\Mail\TicketDelete());
    return view('welcome');
}); 
Route::get('/ticketstatusdefined',function(){
    \Illuminate\Support\Facades\Mail::send(new App\Mail\TicketStatusDefine());
    return view('welcome');
}); 
Route::get('/ticketprioritydefined',function(){
    \Illuminate\Support\Facades\Mail::send(new App\Mail\TicketPriorityDefine());
    return view('welcome');
}); 
Route::get('/ticketpermissionassigned',function(){
    \Illuminate\Support\Facades\Mail::send(new App\Mail\TicketPermissionAssigned());
    return view('welcome');
}); 


// SMS Notification
Route::get('send-sms-notification', [SMSNotification::class, 'sendSmsNotificatiion']);
Route::get('ticket-create-send-sms-notification', [SMSNotification::class, 'TicketCreatesendSmsNotificatiion']);
Route::get('ticket-update-send-sms-notification', [SMSNotification::class, 'TicketUpdateSmsNotificatiion']);
Route::get('ticket-delete-send-sms-notification', [SMSNotification::class, 'TicketDeletesendSmsNotificatiion']);
Route::get('ticket-status-send-sms-notification', [SMSNotification::class, 'TicketStatusDefinesendSmsNotificatiion']);
Route::get('ticket-priority-send-sms-notification', [SMSNotification::class, 'TicketPriorityDefinesendSmsNotificatiion']);
Route::get('ticket-permission-send-sms-notification', [SMSNotification::class, 'TicketPermissionAssignendSmsNotificatiion']);

Route::group(['middleware' => 'auth'],function(){
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
