<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SongCategoryController extends Controller
{
    //

    public function getCategories(){
        $categories = DB::table('categories')->get();

        return response()->json($categories, 200);
    }
}
