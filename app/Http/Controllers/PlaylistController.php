<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Tymon\JWTAuth\Facades\JWTAuth;

class PlaylistController extends Controller
{
    //

    public function createPlaylist(Request $request){
        try {
            $user = JWTAuth::parseToken()->authenticate();

            DB::beginTransaction();

            $playlistId = DB::table('playlists')->insertGetId([
                'user_id' => $user->id,
                'playlist_name' => $request->name,
                'songs_id' => $request->songs_id,           //expecting to get songs id in comma separated from the postman
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json(['message' => 'playlist created successfully', 'playlist_id' => $playlistId], 201);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'unauthorized'], 401);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'unable to create playlist', 'message' => $e->getMessage()], 500);
        }
    }

    public function getUserPlaylist(Request $request){
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (is_null($user)) {
                return response()->json(['error' => 'unauthorized'], 401);
            }
    
            $playlists = DB::table('playlists')->where('user_id', $user->id)->get();

            if ($playlists->isEmpty()) {
                return response()->json(['message' => 'no playlists found for the user'], 404);
            }

            return response()->json($playlists, 200);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'unauthorized access'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'playlists not found', 'message' => $e->getMessage()], 500);
        }
    }

    public function test(Request $request)
    {
        return response()->json(['message' => 'middleware working'], 200);
    }
}
