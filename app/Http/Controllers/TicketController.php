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

class TicketController extends Controller
{
    use HasApiTokens;

    public function index()
    {
        $ticket = Ticket::all();
        if($ticket->count()>0)
        {
           return response()->json([
                'status' => 200,
                'ticket' => $ticket
           ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'ticket' => 'No Ticket Found'
            ]);
        }

    }

    public function store(Request $request)
    {
        try
        {

            $ticketData = Validator::make($request->all(),[
                'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            // 'comment' => 'required|string|max:255',
            'attachment_file' => 'required|string',
            // 'assignee_id' => 'required|integer',
            ]);

            if($ticketData->fails()){
                return response()->json([
                    'status' => 422,
                    'errors' => $ticketData->messages()
                ],422);
            }
            else
            {
                $fileExtension = pathinfo($request->attachment_file, PATHINFO_EXTENSION);
            $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            if (!in_array($fileExtension, $allowedExtensions)) 
            {
                return response()->json([
                    'status' => 422,
                    'errors' => 'Invalid file extension. Only PDF, DOC, DOCX, JPG, JPEG, PNG are allowed.'
                ], 422);
            }
            }   
                $guid = Str::uuid()->toString();
                
                $ticket = Ticket::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'message' => $request->message,
                    'attachment_file' => $request->attachment_file,
                    'guid' => $guid,
                    // 'token' => $token
                    // 'assignee_id' => $request->title,
                ]);

                // $ticket->created_by = now()->format('Y-m-d');
                $token = $ticket->createToken($request->title)->plainTextToken;
                $ticket->token = $token;
                $ticket->save();

                $ticketPriority = Priority::create([
                    'ticket_id' => $request->id
                ]);
                $ticketStatus = Status::create([
                    'ticket_id' => $request->id
                ]);
                $ticketPermission = permission::create([
                    'ticket_id' => $request->id
                ]);

                if($ticket)
                {
                    return response()->json([
                    'token' => $token,
                    'status' => 200,
                    'message' => "Ticket is created successfully"
                    ]);

                    $ticket->token = $token;
                    $ticket->save();
                }
                else
                {
                    return response()->json([
                        'status' => 500,
                        'message' => "Cannot create ticket"
                        ]);
                }
            
            }
        catch (\Exception $e) {
        return response()->json(['error' => 'Failed to create ticket. Something is wrong'.$e], 500);
                }
    }

    public function show($id)
    {
        $ticket = Ticket::find($id);
        if($ticket)
        {
            return response()->json([
                'status' => 200,
                'ticket' => $ticket
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'No Ticket is found!'
            ],404);
        }
    }

    public function edit($id)
    {
        $ticket = Ticket::find($id);
        if($ticket)
        {
            return response()->json([
                'status' => 200,
                'ticket' => $ticket
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'No Ticket is found!'
            ],404);
        }
    }

    public function update(Request $request, int $id)
    {
        $ticketData = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            // 'comment' => 'required|string|max:255',
            'attachment_file' => 'required|string',
            // 'assignee_id' => 'required|integer',
        ]);

        if($ticketData->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $ticketData->messages()
            ],422);
        }
        $ticket = Ticket::find($id);
        if(!$ticket)
        {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
        else
        {

            $guid = Str::uuid()->toString();

            $ticket = Ticket::find($id);


            // $ticket->created_by = now()->format('Y-m-d');


            if($ticket)
            {
                $ticket->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'message' => $request->message,
                    'attachment_file' => $request->attachment_file,
                    'guid' => $guid,
                    // 'token' => $token
                    // 'assignee_id' => $request->title,
                ]);

                $token = $ticket->createToken($request->title)->plainTextToken;
                $ticket->token = $token;
                $ticket->save();

                return response()->json([
                'token' => $token,
                'status' => 200,
                'message' => "Ticket is updated successfully"
                ]);

                $ticket->token = $token;
                $ticket->save();
            }
            else
            {
                return response()->json([
                    'status' => 400,
                    'message' => "No such ticket data"
                    ]);
            }
        }
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if($ticket)
        {
            $ticket->delete();

            return response()->json([
                'status' => 200,
                'message' => "Ticket Data Deleted Successfully"
                ]);
        }
        else
        {
            return response()->json([
                'status' => 400,
                'message' => "No such ticket data"
                ]);
        }
    }
}