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
        // "id": 13,
            // "claim_code": "66739ca032342",
            // "user_id": 4,
            // "shop_id": 6,
            // "weight": "100",
            // "with_pickup": false,
            // "with_delivery": false,
            // "pickup_address": null,
            // "delivery_address": null,
            // "total": "1500000",
            // "description": "100 Sepatu",
            // "status": "Process",
            // "created_at": "2024-06-20T03:06:08.000000Z",
            // "updated_at": "2024-06-20T03:06:08.000000Z",
            // "date_pickup": "2024-06-23",
        $laundries = Laundry::select('laundries.id', 'laundries.claim_code', 'laundries.user_id', 'laundries.shop_id', 'laundries.weight', 'laundries.total', 'laundries.description', 'laundries.status', 'laundries.created_at', 'laundries.updated_at', 'laundries.date_pickup')->where('user_id', $id)->with('shop', 'user')->orderBy('created_at', 'desc')->get();
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

        if ($laundry->status == 'Done') {
            return response()->json([
                'message' => 'laundry has been claimed'
            ], 400);
        }

        $laundry->user_id = $request->user_id;
        $laundry->status = 'Done';
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

    function post(Request $request) {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     // Tambahkan validasi lainnya sesuai kebutuhan
        // ]);
        // dd(auth()->user());
        
        $laundry = new Laundry();
        
        $laundry->claim_code = uniqid();
        // $laundry->user_id = auth()->user()->id;
        // $laundry->shop_id = $request->shop_id;
        $laundry->user_id = $request->user_id; // Set user_id to the id of the logged-in user
        $laundry->shop_id = $request->shop_id;
        $laundry->weight = $request->weight;
        $laundry->total = 15000 * $request->weight; // Calculate price based on weight
        $laundry->description = $request->weight." Sepatu";
        $laundry->status = 'Process';
        $laundry->date_pickup = now()->addDays(3); // Set date_pickup to 3 days from now
        $laundry->save();

        return response()->json(['message' => 'Success', 'statusCode' => 200], 201);
    }
}
