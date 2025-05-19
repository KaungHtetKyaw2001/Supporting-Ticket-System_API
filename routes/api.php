<?php

use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AgentTicketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AttachmentFileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTicketController;
use App\Models\AttachmentFile;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    
    return $request->user();
});


// Public Routes
    Route::get('/register', [UserController::class, 'register']);
    Route::get('/allusers',[UserController::class, 'all_users']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class,'login']);
    Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
    Route::post('/reset-password/guid', [PasswordResetController::class, 'reset']);


// Protected Routes
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/loggeduser', [UserController::class, 'logged_user']);

Route::post('/changepassword', [UserController::class, 'change_password']);
});

    Route::post('usertickets', [UserTicketController::class, 'store'],[SMSNotification::class, 'sendSmsNotificatiion'],function(){
        \Illuminate\Support\Facades\Mail::send(new App\Mail\TicketCreate());
        return view('welcome');
    })->name('usertickets.store');
        // Route::get('usertickets/{guid}/attachment', [UserTicketController::class, 'downloadAttachment'])->name('usertickets.attachment');
        Route::get('usertickets', [UserTicketController::class, 'index'])->name('usertickets.index');
        Route::get('usertickets/{guid}',[UserTicketController::class, 'show'])->name('usertickets.show');
        Route::put('usertickets/{guid}/update',[UserTicketController::class, 'update'])->name('usertickets.update');
        Route::delete('usertickets/{guid}/delete',[UserTicketController::class, 'destroy'])->name('usertickets.destroy');
    // // Admin Login
    // Route::middleware('auth:api')->group(function () {
        
    // });
    Route::post('admintickets', [AdminTicketController::class, 'store'])->name('admintickets.store');
        Route::get('admintickets', [AdminTicketController::class, 'index'])->name('admintickets.index');
        Route::get('admintickets/{guid}',[AdminTicketController::class, 'show'])->name('admintickets.show');
        Route::put('admintickets/{guid}/update',[AdminTicketController::class, 'update'])->name('admintickets.update');
        Route::delete('admintickets/{guid}/delete',[AdminTicketController::class, 'destroy'])->name('admintickets.destroy');
        Route::put('admintickets/{guid}/status',[StatusController::class, 'open'])->name('admintickets.open');
        Route::put('admintickets/{guid}/transfer', [PriorityController::class, 'transfer'])->name('admintickets.transfer');
        Route::put('admintickets/{guid}/assign', [PermissionController::class, 'assign'])->name('admintickets.assign');
        Route::put('admintickets/{guid}/reassign',[PermissionController::class, 'reassign'])->name('admintickets.reassign');
        Route::get('allusers',[AdminTicketController::class, 'all_users'])->name('admintickets.all_users');
    // Agent Login
    // Route::middleware('auth:api')->group(function () {
        
    // });
    Route::post('agenttickets', [AgentTicketController::class, 'store'])->name('agentickets.store');
    Route::get('agenttickets', [AgentTicketController::class, 'index'])->name('agenttickets.index');
        Route::get('agenttickets/{guid}',[AgentTicketController::class, 'show'])->name('agenttickets.show');
        Route::put('agenttickets/{guid}/update',[AgentTicketController::class, 'update'])->name('agenttickets.update');
        Route::delete('agenttickets/{guid}/delete',[AgentTicketController::class, 'destroy'])->name('agenttickets.destroy');
        Route::put('agenttickets/{guid}/status',[StatusController::class, 'open'])->name('agenttickets.open');
        Route::put('agenttickets/{guid}/transfer', [PriorityController::class, 'transfer'])->name('agenttickets.transfer');
        Route::put('agenttickets/{guid}/assign', [PermissionController::class, 'assign'])->name('agenttickets.assign');
        Route::put('agenttickets/{guid}/reassign',[PermissionController::class, 'reassign'])->name('agenttickets.reassign');
        Route::get('allusers',[AgentTicketController::class, 'all_users'])->name('agenttickets.all_users');

        // Ticket routes

        // Public routes
    Route::get('tickets', [TicketController::class, 'index']);
    Route::post('tickets', [TicketController::class, 'store']);
    Route::get('tickets/{guid}',[TicketController::class, 'show']);
    Route::put('tickets/{guid}/update',[TicketController::class, 'update']);
    Route::delete('tickets/{guid}/delete',[TicketController::class, 'destroy']);

// Category Routes
    
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{guid}',[CategoryController::class, 'show']);
    Route::put('categories/{guid}/update',[CategoryController::class, 'update']);
    Route::delete('categories/{guid}/delete',[CategoryController::class,'destroy']);
    Route::get('allcategories',[CategoryController::class,'allCategories']);

    // Comment Routes

    Route::post('comments',[CommentController::class,'store']);
    Route::get('comments/{guid}',[CommentController::class,'show']);
    Route::put('comments/{guid}/update',[CommentController::class,'update']);
    Route::delete('comments/{guid}/delete',[CommentController::class,'destroy']);
    Route::get('allcomments',[CommentController::class,'allComments']);

    // Attachment Routes

    Route::post('attachmentFiles/{guid}/insert',[AttachmentFileController::class, 'insert']);
    Route::get('attachmentFiles/{guid}',[AttachmentFileController::class,'show']);
    Route::delete('attachmentFiles/{guid}/delete',[AttachmentFileController::class,'destroy']);
    Route::get('allAttachmentFiles',[AttachmentFileController::class,'allAttachmentFiles']);
    // Ticket Management
    // Route::put('/tickets/{id}/status',[TicketController::class, 'open']);
    // Route::put('/tickets/{id}/transfer', [TicketController::class, 'transfer']);
    // Route::put('/tickets/{id}/assign', [TicketController::class, 'assign']);
    // Route::put('/tickets/{id}/reassign',[TicketController::class, 'reassign']);

    // Route::put('/tickets/{id}',[TicketController::class, 'update']);
    // Route::delete('/tickets/{id}',[TicketController::class,'delete']);

    // Route::post('/logout', [UserController::class, 'logout']);
