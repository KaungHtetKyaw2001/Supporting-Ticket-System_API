<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Status;
use App\Models\permission;
use App\Models\Ticket;
use App\Models\attachment_file;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\TicketNotification;
use App\Notifications\EmailTicketNotification;
use App\Notifications\SMSTicketNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\AttachmentFile;
use Nexmo\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserTicketController extends Controller
{
    public function store(Request $request)
{
    try {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        $ticketData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            // 'attachment_file' => 'required|file',
        ]);

        if ($ticketData->fails()) {
            return response()->json([
                'success' => false,
                'message' => $ticketData->messages(),
                'timestamp' => $timestamp
            ], 422);
        }

        $guid = Str::uuid()->toString();
        // $attachment_guid = Str::uuid()->toString();
        // $attachment = $request->attachment_file;
        // list($extension, $attachment) = explode(';', $attachment);
        // list(, $extension) = explode('/', $extension);
        // $attachment = str_replace('base64,', '', $attachment);
        // $attachment = str_replace(' ', '+', $attachment);
        // $attachmentExtension = strtolower($extension);

        // if (!in_array($attachmentExtension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
        //     return response()->json(['status' => 422, 'message' => 'Attachment extension not supported.'], 422);
        // }

        // $attachmentFile = base64_decode($attachment);
        // $attachmentFilePath = storage_path("app/Attachment_files/{$attachment_guid}.{$attachmentExtension}");

        //  dd($attachmentFilePath);
        // file_put_contents($attachmentFilePath, $attachmentFile);
        // $attachment = $request->file('attachment_file');

        // $attachmentExtension = strtolower($attachment->getClientOriginalExtension());

        // if (!in_array($attachmentExtension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
        //     return response()->json(['status' => 422, 'message' => 'Attachment extension not supported.'], 422);
        // }

        // $attachmentFilePath = $attachment->store("Attachment_files");


        $ticket = Ticket::create([
            'title' => $request->title,
            'content' => $request->content,
            'message' => $request->message,
            // 'attachment_file' => $attachmentFilePath,
            'guid' => $guid,
        ]);

        $token = $ticket->createToken($request->title)->plainTextToken;
        $ticket->token = $token;
        $ticket->save();

        $status = new Status;
        $status->ticket_id = $ticket->id;
        $status->guid = $ticket->guid;
        $status->save();

        $permission = new permission;
        $permission->ticket_id = $ticket->id;
        $permission->guid = $ticket->guid;
        $permission->save();

        $priority = new Priority;
        $priority->ticket_id = $ticket->id;
        $priority->guid = $ticket->guid;
        $priority->save();

        $attachment_file = new AttachmentFile;
        $attachment_file->ticket_id = $ticket->id;
        // $attachment_file->attachment_file = $ticket->attachment_file;
        $attachment_file->guid = $ticket->guid;
        $attachment_file->save();

        if ($ticket) {
            return response()->json([
                'success' => true,
                'data' => [
                    'title' => $request->title,
                    'content' => $request->content,
                    'message' => $request->message,
                    // 'attachment_file' => $attachmentFilePath,
                    'guid' => $guid,
                ],
                'message' => 'Ticket is created successfully',
                'timestamp' => $timestamp
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cannot create ticket',
                'timestamp' => $timestamp
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create ticket. Something is wrong'.$e,
            'timestamp' => $timestamp ]);
    }
}



// public function downloadAttachment($guid)
// {
//     $ticket = Ticket::where('guid', $guid)->firstOrFail();

//     $attachmentPath = $ticket->attachment_file;

//     if (empty($attachmentPath)) {
//         return response()->json(['status' => 404, 'message' => 'Attachment not found']);
//     }

//     $attachment = Storage::disk('public')->get($attachmentPath);

//     $finfo = new \finfo(FILEINFO_MIME_TYPE);
//     $mime = $finfo->file(storage_path("app/public/{$attachmentPath}"));

//     return response($attachment, 200)
//         ->header('Content-Type', $mime)
//         ->header('Content-Disposition', 'attachment; filename="' . basename($attachmentPath) . '"');
// }


    public function show($guid)
    {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        // $ticket = Ticket::find($guid);
        $ticket = Ticket::where('guid', $guid)->first();
        $ticket->makeHidden('id');
        // dd($ticket);
        if($ticket)
        {
            return response()->json([
                'success' => true,
                'data' => [
                    $ticket
                ],
                'message' => 'This is the ticket data from user\'s guid - '.$guid,
                'timestamp' => $timestamp
            ],200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'No Ticket is found!',
                'timestamp' => $timestamp
            ],404);
        }
    }

    // public function edit($id)
    // {
    //     $ticket = Ticket::find($id);
    //     if($ticket)
    //     {
    //         return response()->json([
    //             'status' => 200,
    //             'ticket' => $ticket
    //         ],200);
    //     }
    //     else
    //     {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'No Ticket is found!'
    //         ],404);
    //     }
    // }

    public function update(Request $request, string $guid)
    {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        $ticketData = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            // 'attachment_file' => 'required|file', // Add validation rule for attachment file
        ]);

        if($ticketData->fails()){
            return response()->json([
                'success' => false,
                'message' => $ticketData->messages(),
                'timestamp' => $timestamp
            ], 422);
        }

        $ticket = Ticket::where('guid', $guid)->first();
        if(!$ticket)
        {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        $ticket->title = $request->title;
        $ticket->content = $request->content;
        $ticket->message = $request->message;

        $guid = Str::uuid()->toString();
        // // $attachment_guid = Str::uuid()->toString();
        // // $attachment = $request->attachment_file;
        // // list($extension, $attachment) = explode(';', $attachment);
        // // list(, $extension) = explode('/', $extension);
        // // $attachment = str_replace('base64,', '', $attachment);
        // // $attachment = str_replace(' ', '+', $attachment);
        // // $attachmentExtension = strtolower($extension);


        // // if (!in_array($attachmentExtension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
        // //     return response()->json(['status' => 422, 'message' => 'Attachment extension not supported.'], 422);
        // // }

        // // $attachmentFile = base64_decode($attachment);
        // // dd($attachmentFile);
        // // $attachmentFilePath = storage_path("app/Attachment_files/{$attachment_guid}.{$attachmentExtension}");


        // // $RealFile = file_put_contents($attachmentFilePath, $attachmentFile);

        // $attachment = $request->file('attachment_file');

        // $attachmentExtension = strtolower($attachment->getClientOriginalExtension());

        // if (!in_array($attachmentExtension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
        //     return response()->json(['status' => 422, 'message' => 'Attachment extension not supported.'], 422);
        // }

        // $attachmentFilePath = $attachment->store("Attachment_files");
        // $ticket->attachment_file = $attachmentFilePath;
        // $ticket->save();

        // $attachment_file = new AttachmentFile;
        // $attachment_file->ticket_id = $ticket->id;
        // $attachment_file->attachment_file = $ticket->attachment_file;
        // $attachment_file->save();

        $ticket->makeHidden('id');

        return response()->json([
            'success' => true,
            'data' => [
                $ticket // Return updated ticket data in the response
            ],
            'message' => "Ticket is updated successfully",
            'timestamp' => $timestamp
        ]);
    }


    public function destroy($guid)
{
    $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
    $ticket = Ticket::where('guid', $guid)->first();
    if($ticket)
    {
        $ticket->statuses()->delete();
        $ticket->permissions()->delete();
        $ticket->priorities()->delete();
        $attachmentFiles = $ticket->attachment_files;
        if ($ticket->attachment_files) {
        foreach ($attachmentFiles as $attachmentFile) {
            Storage::delete($attachmentFile->attachment_file);
        }
        }
        $ticket->attachment_files()->delete();
        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => "Ticket Data Deleted Successfully",
            'timestamp' => $timestamp
            ]);
    }
    else
    {
        return response()->json([
            'success' => false,
            'message' => "No such ticket data",
            'timestamp' => $timestamp
            ]);
    }
}




    public function index()
    {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        $ticket = Ticket::all();
        if($ticket->count()>0)
        {
           return response()->json([
                'success' => true,
                'data' => [
                    $ticket
                ],
                'message' => 'Here are all ticket data',
                'timestamp' => $timestamp

           ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'No Ticket Found',
                'timestamp' => $timestamp
            ]);
        }

    }
}
