<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public $token = true;

    public function registerUser(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);
    
            return response()->json(['message' => 'user has been created'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed to create user', 'error' => $e->getMessage()], 500);
        }
    }

    public function loginUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($validatedData)) {
            return response()->json(['message' => 'incorrect email id and password combination'], 401);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 200);
    }

    public function testApi(){
        echo "server working";
    }

    // public function getSongs(){
    //     $songs = DB::table('songs')->get();

    //     return response()->json($songs, 200);
    // }
}
