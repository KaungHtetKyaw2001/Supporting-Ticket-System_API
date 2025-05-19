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

class PriorityController extends Controller
{
   // Ticket transfer
   public function transfer(Request $request, $guid)
   {
    try {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        $priority = Priority::where('guid', $guid)->first();
        $priority->makeHidden('id');
        // Validate the request payload
        $validator = Validator::make($request->all(), [
            'priority' => 'required|string|max:255',
            'assignee_id' => 'required|integer',
            'assignee_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        // if ($priority->priority !== null) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Ticket is already assigned',
        //         'timestamp' => $timestamp], 400);
        // }
        if ($priority->priority === $request->priority) {
            return response()->json([
                'success' => false,
                'error' => 'Ticket is already ' . $request->priority,
                'timestamp'=>$timestamp
            ], 400);
        }
        else
        {
        // Generate a new GUID for the ticket
        $guid = Str::uuid()->toString();

        // Update the ticket with the new priority and assignee
        $priority->priority = $request->input('priority');
        $priority->assignee_id = $request->input('assignee_id');
        $priority->assignee_name = $request->input('assignee_name');

         // Check if the ticket priority is already defined


            $token = $priority->createToken($request->priority)->plainTextToken;
            $priority->token = $token;
            $priority->save();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'priority' => $priority->priority,
                'assignee_name' => $priority->assignee_name
            ],
            'message' => 'This ticket is transferred',
            'timestamp' => $timestamp
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to transfer ticket'.$e,
            'timestamp'=> $timestamp], 500);
    }
}
}
