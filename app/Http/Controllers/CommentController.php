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

class CommentController extends Controller
{
    public function store(Request $request)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $CommentData = Validator::make($request->all(),[
                'comment' => 'required|string|max:255',
                // 'attachment_file' => 'required|string',
                'user_id' => 'required|string|max:255',
            ]);
            if($CommentData->fails())
            {
                return response()->json([
                    'success'=> false,
                    'message'=> $CommentData->messages(),
                    'timestamp'=>$timestamp
                ],422);
            }

            $attachment_guid = Str::uuid()->toString();
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

        // //  dd($attachmentFilePath);
        // file_put_contents($attachmentFilePath, $attachmentFile);

            $guid = Str::uuid()->toString();
            $comment = Comment::create([
                'comment' => $request->comment,
                'user_id' => $request->user_id,
                'guid' => $guid,
            ]);

            // if ($request->has('category') && !empty($request->category)) {
            //     $token = $comment->createToken($request->category)->plainTextToken;
            //     $comment->token = $token;
            //     $comment->save();
            // }
            $token = $comment->createToken($request->comment)->plainTextToken;
                $comment->token = $token;
                $comment->save();

        $attachment_file = new AttachmentFile;
        $attachment_file->comment_id = $comment->id;
        $attachment_file->guid = $guid;
        $attachment_file->save();

            if($comment)
            {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'comment' => $request->comment,
                        'user_id' => $request->user_id,
                        'guid' => $comment->guid,
                        'token' => $comment->token,
                    ],
                    'message' => 'Comment is created',
                    'timestamp' => $timestamp
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot create comment',
                    'timestamp' => $timestamp
                ]);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function show($guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $comment = Comment::where('guid',$guid)->first();
            $comment->makeHidden('id');
            if($comment)
            {
                return response()->json([
                    'success' => true,
                    'data' => [
                        $comment
                    ],
                    'message' => 'This is the comment data by guid',
                    'timestamp' => $timestamp
                ],200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No comment is found',
                    'timestamp' => $timestamp
                ],404);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to show comment. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function update(Request $request, string $guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $CommentData = Validator::make($request->all(),[
                'comment' => 'required|string|max:255',
                // 'attachment_file' => 'required|string',
                'user_id' => 'required|string',
            ]);

            if($CommentData->fails()){
                return response()->json([
                    'success'=> false,
                    'message'=> $CommentData->messages(),
                    'timestamp'=>$timestamp
                ],422);
            }

            $comment = Comment::where('guid',$guid)->first();
            $comment->comment = $request->input('comment');
            $comment->user_id = $request->input('user_id');
            if(!$comment)
        {
            return response()->json([
                'success' => false,
                'error' => 'Comment not found',
                'timestamp' => $timestamp], 404);
        }
        $comment->makeHidden('id');
        $comment->save();
        return response()->json([
            'success' => true,
            'data' => [
                $comment // Return updated ticket data in the response
            ],
            'message' => "Comment is updated successfully",
            'timestamp' => $timestamp
        ]);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update comment. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function destroy($guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $comment = Comment::where('guid',$guid)->first();
            if($comment)
            {
                $comment->delete();

                return response()->json([
                    'success' => true,
                    'message' => "Comment Deleted Successfully",
                    'timestamp' => $timestamp
                    ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "No such Comment data",
                    'timestamp' => $timestamp
                    ]);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete comment. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function allComments()
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $comment = Comment::all();
            $comment->makeHidden('id');
            if($comment->count()>0)
            {
                return response()->json([
                    'success' => true,
                    'data' => [ $comment],
                    'message' => 'All Comment data Retrieved',
                    'timestamp' => $timestamp
               ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No Comments Found',
                    'timestamp' => $timestamp
                ]);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to display comment. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }
}
