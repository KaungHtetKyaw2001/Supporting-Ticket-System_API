<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Status;
use App\Models\permission;
use App\Models\Ticket;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\TicketNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class StatusController extends Controller
{
     // Ticket Status
     public function open(Request $request, $guid)
{
    $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
    try {
        // $ticket = Ticket::findOrFail($id);
        $status = Status::where('guid', $guid)->first();
        // $user = auth()->user();
        // $assignee_id = $user->id;
        // $assignee_name = $user->name;

        // if (!$status) {
        //     $status = new Status;
        //     $status->guid = $guid;
        // }

        if ($status->status === $request->status) {
            return response()->json([
                'success' => false,
                'error' => 'Ticket is already ' . $request->status,
                'timestamp'=>$timestamp
            ], 400);
        }
        // if ($status->guid !== null) {
        //     return response()->json(['error' => 'Ticket is already defined'], 400);
        // }

        $guid = Str::uuid()->toString();

        // $ticket->update([
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'message' => $request->message,
        //     // 'comment' => $request->comment,
        //     // 'attachment_file' => $imageName,
        //     'guid' => $guid,
        //     // 'token' => $token,
        //     // 'assignee_id' => $request->title,
        // ]);

        $status->status = $request->input('status');
        $status->assignee_id = $request->input('assignee_id');
        $status->assignee_name = $request->input('assignee_name');
        $token = $status->createToken($request->status)->plainTextToken;
        $status->token = $token;

        $status->update([
            'status' => $request->status,
            'assignee_id' => $status->assignee_id,
            'assignee_name' => $status->assignee_name,
            'token' => $status->token
        ]);


        $status->save();
        $status->makeHidden('id','assignee_id','ticket_id');
        // Notify the assigned user
        // $user = User::findOrFail($status->assignee_id);
        // Notification::send($user, new TicketNotification($ticket));
        return response()->json([
            'success' => true,
            'data' => $status,
            'message' => 'Ticket opened successfully',
            'timestamp' => $timestamp


        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ticket status not found'.$e,
            'timestamp' => $timestamp], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => true,
            'message' => 'Failed to open ticket'.$e,
            'timestamp' => $timestamp
        ], 500);
    }
}
}
