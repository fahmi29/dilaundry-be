<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    function readAll() {
        $shops = Shop::with('laundries')->get();

        return response()->json([
            'data' => $shops,
        ], 200);
    }

    function readRecomendationLimit() {
        $shops = Shop::orderBy('rate', 'desc')->limit(5)->get();
        if (count($shops)>0) {
            return response()->json([
                'data' => $shops
            ], 200);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'data' => $shops
            ], 404);
        }
    }

    function searchByCity($name) {
        $shops = Shop::where('city', 'like','%'.$name.'%')->orderBy('name')->get();
        if (count($shops)>0) {
            return response()->json([
                'data' => $shops
            ], 200);
        }else {
            return response()->json([
                'message' => 'Not Found',
                'data' => $shops
            ], 404);
        }
    }
}
