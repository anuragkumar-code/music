<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\DB;

class SongsController extends Controller
{
    //
    public function getSongs(){
        $songs = DB::table('songs')->get();

        return response()->json($songs, 200);
    }

}
