<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    function readAll() {
        $laundrys = Laundry::with('user','shop')->get();

        return response()->json([
            'data' => $laundrys,
        ], 200);
    }

    function whereUserId($id) {
        $laundries = Laundry::where('user_id', $id)->with('shop', 'user')->orderBy('created_at', 'desc')->get();
        if (count($laundries)>0) {
            return response()->json([
                'data' => $laundries
            ], 200);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'data' => $laundries
            ], 404);
        }
    }

    function claim(Request $request) {
        $laundry = Laundry::where([['id', $request->id],['claim_code', $request->claim_code]])->first();
        if (!$laundry) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        if ($laundry->user_id != 0) {
            return response()->json([
                'message' => 'laundry has been claimed'
            ], 400);
        }

        $laundry->user_id = $request->user_id;
        $update = $laundry->save();

        if ($update) {
            return response()->json([
                'data' => $update
            ], 201);
        }else {
            return response()->json([
                'message' => 'Cannot Be Updated',
            ], 500);
        }
    }
}
