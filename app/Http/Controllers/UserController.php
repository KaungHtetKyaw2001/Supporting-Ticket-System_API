<?php

namespace App\Http\Controllers;

use App\Models\user_category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Nexmo\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use HasApiTokens;

    // User register
    public function register(Request $request)
    {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email'=> 'required|email',
            'phone_number' => 'required',
            'password' => 'required|string|confirmed|min:8',
            'category' => 'required'
        ]);
        if(User::where('email',$request->email)->first()){
            return response([
                'success'=> false,
                'message'=> 'Email already exists',
                'timestamp' => $timestamp
            ],200);
        }

        $guid = Str::uuid()->toString();
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            // 'password' => $request->password,
            'category' => $request->category,
            'guid' => $guid,
        ]);
        $token = $user->createToken($request->email)->plainTextToken;
        $user->remember_token = $token;
        $user->save();

        $userCategory = new user_category;
        $userCategory->user_id = $user->id;
        $userCategory->save();
        if($user)
        {
            return response([
                'success' => true,
                'data' => [
                    'name' => $request->name,
                    'role' => $request->role,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'password' => $request->password,
                    'guid' => $guid,
                    'category' => $request->category,
                    'token' => $token,
                ],
                'message' => 'Register success',
                'timestamp' => $timestamp
                ],201);
        }
        else
        {
            return response([
                'success' => false,
                'message' => 'register failed',
                'timestamp' => $timestamp
            ]);
        }
    }

    public function login(Request $request)
    {
        $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        $request->validate([
            'email'=> 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        // dd($user);
        if ($user) {
            $password = $request->password;
            $newHashedPassword = bcrypt($password);
            $user->password = $newHashedPassword;
            $user->save();
        }
        // dd($user);

        if (Auth::attempt(['email' => $request->email, 'password' => $newHashedPassword])) {
            // Login successful, return response
            $user = Auth::user();
            // dd( $user = Auth::user());
            $accessToken = Auth::user()->createToken('authToken')->accessToken;
            // $token = $user->createToken($request->email)->plainTextToken;
            if ($user->isAdmin()) {
                return response([
                    'success' => true,
                    'data' => [
                        'name' => $user->name,
                        'role' => $user->role,
                        'access token' => $accessToken,
                    ],
                    'message' => 'User Login success',
                    'timestamp' => $timestamp
                ],200);
                $user = Auth::user();
                $user_id = Auth::id();
            } elseif ($user->isAgent()) {
                return response([
                    'success' => true,
                    'data' => [
                        'name' => $user->name,
                        'role' => $user->role,
                        'access token' => $accessToken,
                    ],
                    'message' => 'User Login success',
                    'timestamp' => $timestamp
                ],200);
            } else {
                return response([
                    'success' => true,
                    'data' => [
                        'name' => $user->name,
                        'role' => $user->role,
                        'access token' => $accessToken,
                    ],
                    'message' => 'User Login success',
                    'timestamp' => $timestamp
                ],200);
            }
        } else {
            // Login failed, return error response
            return response([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
                'timestamp' => $timestamp
            ],401);
        }
    }


    // User Logout
    public function logout(Request $request)
{
    $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');

    // Get the access token from the Authorization header
    $accessToken = $request->bearerToken();

    // Revoke the access token
    DB::table('oauth_access_tokens')
        ->where('id', $accessToken)
        ->update(['revoked' => true]);

    return response([
        'success' => true,
        'message' => 'User logged out.',
        'timestamp' => $timestamp
    ],200);
}


    // User Logged details using bearer token
    public function logged_user()
{
    $timestamp = Carbon::now()->format('Y-m-d\TH:i:s.uO');
    $loggeduser = auth()->user();
    $loggeduser->makeHidden('id', 'guid');
    return response()->json([
        'success' => true,
        'data' => [
            $loggeduser,
        ],
        'message' => 'This is logged user\'s data',
        'timestamp' => $timestamp
    ], 200);
}

    // Providing all users' list
    public function all_users()
    {
         $timestamp = Carbon::now()->setTimezone('Asia/Yangon')->format('Y-m-d\TH:i:s.uO');
        $users = User::all();
        // Hide the id and guid fields from the user data
        $users->makeHidden('id', 'guid');
        if($users->count() > 0) {
            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'This is all user\'s data',
                'timestamp' => $timestamp
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "What do you expect? There's no any user data for you...",
                'timestamp' => $timestamp
            ]);
        }
    }

    // Password changing
public function change_password(Request $request){
    $timestamp = Carbon::now()->format('Y-m-d\TH:i:s.uO');
    $request->validate([
        'password' => 'required|string|confirmed|min:8',
    ]);

    $loggeduser = auth()->user();
    $loggeduser->password = bcrypt($request->password);

    try {
        $loggeduser->save();
    } catch (\Exception $e) {
        return response([
            'success' => false,
            'message' => 'Failed to change password',
            'timestamp' => $timestamp
        ], 500);
    }

    return response([
        'success' => true,
        'data' => ['password' => $request->password],
        'message' => 'Password Changed Successfully',
        'timestamp' => $timestamp
   ],200);
}


    // finding all user and ticket data
    public function index()
    {
        try {
            $users = User::all();
            $users->makeHidden('id');
            $users->makeHidden('guid');

            $tickets = Ticket::all();
            $tickets->makeHidden('id');

            return response()->json([
                'users' => $users,
                'tickets' => $tickets,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }
}
