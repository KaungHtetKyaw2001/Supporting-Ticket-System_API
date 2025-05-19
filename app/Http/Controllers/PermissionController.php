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
use Illuminate\Contracts\Auth\Authenticatable;
use JWTAuth;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function assign(Request $request, $guid)
    {
        try {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');

            // Find the permission record by GUID
            $permission = Permission::where('guid', $guid)->first();
            if (!$permission) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission not found',
                    'timestamp'=> $timestamp], 404);
            }

            // Validate the request payload
            $validator = Validator::make($request->all(), [
                'permission' => 'required|string|max:255',
                'assignee_id' => 'required|integer',
                'assignee_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                    'timestamp'=> $timestamp], 400);
            }

            // Check if the user has the 'assign-tickets' permission
            // if (Gate::denies('assign-tickets')) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'You do not have permission to assign tickets',
            //         'timestamp' => $timestamp
            //     ], 403);
            // }

            // Update the ticket assignee
            $guid = Str::uuid()->toString();

            $permission->permission = $request->input('permission');
            $permission->assignee_id =Permission::max('assignee_id') + 1;
            $permission->assignee_name = $request->input('assignee_name');
            $token = $permission->createToken($request->permission)->plainTextToken;
            $permission->token = $token;
            $permission->save();

            $permission->makeHidden('id','assignee_id','ticket_id');
            return response()->json([
                'success' => true,
                'data' => [
                    // 'assignee_id' => $permission->assignee_id,
                    // 'assignee_name' => $permission->assignee_name,
                    // 'permission' => $permission->permission,
                    $permission
                ],
                'message' => 'This ticket is assigned',
                'timestamp' => $timestamp
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign ticket '.$e->getMessage(),
                'timestamp'=> $timestamp], 500);
        }
    }



        // Ticket Reassign
        public function reassign(Request $request, $guid)
{
            try {
                $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
                $permission = Permission::where('guid', $guid)->first();
                // Validate the request payload
                $validator = Validator::make($request->all(), [
                    'permission' => 'required|string|max:255',
                    'assignee_id' => 'required|integer',
                    'assignee_name' => 'required|string|max:255',

                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 400);
                }
                $guid = Str::uuid()->toString();

                $permission->permission = $request->input('permission');
            $permission->assignee_id =Permission::max('assignee_id') + 1;
            $permission->assignee_name = $request->input('assignee_name');
            $token = $permission->createToken($request->permission)->plainTextToken;
            $permission->token = $token;
            $permission->save();
            $permission->makeHidden('id','assignee_id','ticket_id');

                return response()->json([
                    'success'=> true,
                    'data' => [
                        $permission
                    ],
                    'message' => 'ticket is reassigned',
                    'timestamp' => $timestamp
                ], 200);
            //  }
                // $ticket->notify(new NewTicketNotification($ticket));

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to assign ticket '.$e->getMessage(),
                    'timestamp'=> $timestamp], 500);
            }
        }
}
