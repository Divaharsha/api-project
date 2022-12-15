<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class ProductController extends Controller
{
    public function product() {
        $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        // ->select('categories.name')
        ->get();

        return response()->json([
                'success' =>true,
                'message' => 'Product Listed successfully',
                'data' => $products,
        ],200);
        
    
    }
    
    public function getproduct($id) {
        if (Product::where('id', $id)->exists()) {
                $products = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                // ->select('products.id AS id','categories.name AS category_Name','products.*')
                ->where('products.id', $id)
                ->get();

                return response()->json([
                        'success' =>true,
                        'message' => 'Product Listed successfully',
                        'data' => $products,
                ],200);
        }
        else{
            return response()->json([
                'success' =>false,
                'message' => 'Product Not Found',
        ],404);
        } 
    }
}
