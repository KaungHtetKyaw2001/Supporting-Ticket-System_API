<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Priority;
use App\Models\Status;
use App\Models\permission;
use App\Models\Ticket;
use App\Models\attachment_file;
use App\Models\Category;
use App\Models\User_category;
use App\Models\Comment;
// use Dotenv\Validator;
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
use Laravel\Ui\Presets\React;

class AttachmentFileController extends Controller
{
    public function insert(Request $request, string $guid)
{
    try {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        // dd($request->file('attachment_file'));
        // Check if the request has the attachment_file
        
        $attachmentFileData = Validator::make($request->all(),[
            'attachment_file' => 'required|file', // Add validation rule for attachment file
        ]);

        if($attachmentFileData->fails()){
            return response()->json([
                'success' => false,
                'message' => $attachmentFileData->messages(),
                'timestamp' => $timestamp
            ], 422);
        }

        $attachment = $request->file('attachment_file');

        $attachmentExtension = strtolower($attachment->getClientOriginalExtension());

        if (!in_array($attachmentExtension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
            return response()->json([
                'success' => false,
                'message' => 'Attachment extension not supported.',
                'timestamp' => $timestamp
            ], 422);
        }

        $attachmentFilePath = $attachment->store("Attachment_files");

        $attachmentFile = AttachmentFile::where('guid', $guid)->first();

        if (!$attachmentFile) {
            return response()->json([
                'success' => false,
                'error' => 'No Data',
                'timestamp' => $timestamp
            ], 404);
        }

        // Update the attachment file path in the database
        $attachmentFile->attachment_file = $attachmentFilePath;
        $attachmentFile->save();

        $attachmentFile->makeHidden('id');
        $attachmentFile->makeHidden('ticket_id');
        $attachmentFile->makeHidden('comment_id');
        return response()->json([
            'success' => true,
            'data' => $attachmentFile,
            'message' => 'Attachment File is added to that data',
            'timestamp' => $timestamp
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to insert attachment. See the error...' . $e->getMessage(),
            'timestamp' => $timestamp
        ]);
    }
}

    

    public function show($guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $attachment = AttachmentFile::where('guid',$guid)->first();
            $attachment->makeHidden('id','comment_id','ticket_id');
            if($attachment)
            {
                return response()->json([
                    'success' => true,
                    'data' => [
                        $attachment
                    ],
                    'message' => 'This is the attachment file data by guid',
                    'timestamp' => $timestamp
                ],200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No attachment File is found',
                    'timestamp' => $timestamp
                ],404);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to show attachment file data. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

     function destroy($guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $attachment = AttachmentFile::where('guid',$guid)->first();
            if($attachment)
            {
                $attachment->delete();

                return response()->json([
                    'success' => true,
                    'message' => "That Attachment File is Deleted Successfully",
                    'timestamp' => $timestamp
                    ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "No such data",
                    'timestamp' => $timestamp
                    ]);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete attachment file. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    function allAttachmentFiles()
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $attachment = AttachmentFile::all();
            $attachment->makeHidden('id');
            $attachment->makeHidden('comment_id');
            $attachment->makeHidden('ticket_id');
            if($attachment->count()>0)
            {
                return response()->json([
                    'success' => true,
                    'data' => [ $attachment],
                    'message' => 'All attachment file data Retrieved',
                    'timestamp' => $timestamp
               ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No attachment data Found',
                    'timestamp' => $timestamp
                ]);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to display attachment file data. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }
}
