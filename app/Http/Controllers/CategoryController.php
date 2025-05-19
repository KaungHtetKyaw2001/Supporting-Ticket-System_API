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

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $CategoryData = Validator::make($request->all(),[
                'category' => 'required|string|max:255',
            ]);

            if($CategoryData->fails()){
                return response()->json([
                    'success'=> false,
                    'message'=> $CategoryData->messages(),
                    'timestamp'=>$timestamp
                ],422);
            }

            $guid = Str::uuid()->toString();
            $category = Category::create([
                'category' => $request->category,
                'guid' => $guid
            ]);

            $token = $category->createToken($request->category)->plainTextToken;
            $category->token = $token;
            $category->save();

            $userCategory = new User_Category;
            $userCategory->category_id = $category->id;
            $userCategory->save();

            if($category)
            {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'category' => $request->category,
                        'token'=> $token,
                        'guid' => $guid,
                    ],
                    'message' => 'Category is created',
                    'timestamp' => $timestamp
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot create category',
                    'timestamp' => $timestamp
                ]);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function show($guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $category = Category::where('guid',$guid)->first();
            $category->makeHidden('id');
            if($category)
            {
                return response()->json([
                    'success' => true,
                    'data' => [
                        $category
                    ],
                    'message' => 'This is the category data by guid',
                    'timestamp' => $timestamp
                ],200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No category is found',
                    'timestamp' => $timestamp
                ],404);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to show category. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function update(Request $request, string $guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $CategoryData = Validator::make($request->all(),[
                'category' => 'required|string|max:255',
            ]);

            if($CategoryData->fails()){
                return response()->json([
                    'success'=> false,
                    'message'=> $CategoryData->messages(),
                    'timestamp'=>$timestamp
                ],422);
            }

            $category = Category::where('guid',$guid)->first();
            if(!$category)
        {
            return response()->json([
                'success' => false,
                'error' => 'Category not found',
                'timestamp' => $timestamp], 404);
        }
        $category->category = $request->category;
        $category->save();
        $category->makeHidden('id');
        return response()->json([
            'success' => true,
            'data' => [
                 $category // Return updated ticket data in the response
            ],
            'message' => "Category is updated successfully",
            'timestamp' => $timestamp
        ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function destroy($guid)
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $category = Category::where('guid',$guid)->first();
            if($category)
            {
                $category->user_categories()->delete();
                $category->delete();

                return response()->json([
                    'success' => true,
                    'message' => "Category Deleted Successfully",
                    'timestamp' => $timestamp
                    ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "No such category data",
                    'timestamp' => $timestamp
                    ]);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function allCategories()
    {
        try
        {
            $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
            $category = Category::all();
            $category->makeHidden('id');
            if($category->count()>0)
            {
                return response()->json([
                    'success' => true,
                    'data' => [$category],
                    'message' => 'All Category data Retrieved',
                    'timestamp' => $timestamp
               ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No Category Found',
                    'timestamp' => $timestamp
                ]);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to display category. See the error...'.$e,
                'timestamp' => $timestamp
            ]);
        }
    }
}
