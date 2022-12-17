<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Student;
use Carbon\Carbon;

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
    
    public function cart(Request $request) {
     
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        if(empty($user_id)){
            return response()->json([
                'success'=>false,
                'message' => 'User Id is Empty',
            ], 200);
        }
        if(empty($product_id)){
            return response()->json([
                'success'=>false,
                'message' => 'Product Id is Empty',
            ], 200);
        }
        if(empty($quantity)){
          return response()->json([
              'success'=>false,
              'message' => 'Quantity is Empty',
          ], 200);
        }
       
            $cart = DB::table('cart')
            ->where('user_id', $request->input('user_id'))
            ->where('product_id',$request->input('product_id'))->get();
            if (count($cart) >= 1) {
                $id = $cart->first()->id;
                Cart::where('id', $id)
                ->update([
                    'quantity' => $quantity
                    ]);

                return response()->json([
                   "success" => true ,
                    'message' => 'Cart Updated Successfully'
                ], 400);
            }
            else{
                $cart = new Cart;
                $cart->user_id = $request->user_id;
                $cart->product_id = $request->product_id;
                $cart->quantity = $request->quantity;
                $cart->save();
            
                return response()->json([
                  "success" => true ,
                  'message'=> "Successfully Added to cart",
                  'data' =>[$cart]
                ], 201);

            }
    }

    //order
    public function order(Request $request) {
     
        $user_id = $request->input('user_id');
        $method = $request->input('method');
        $delivery_charges = $request->input('delivery_charges');
        $address = $request->input('address');
        $mobile = $request->input('mobile');
        $grand_total = $request->input('grand_total');
        $date = Carbon::now("Asia/Kolkata")->format('Y-m-d');

        if(empty($user_id)){
            return response()->json([
                'success'=>false,
                'message' => 'User Id is Empty',
            ], 200);
        }
        if(empty($method)){
            return response()->json([
                'success'=>false,
                'message' => 'Method is Empty',
            ], 200);
        }
        if(empty($delivery_charges)){
          return response()->json([
              'success'=>false,
              'message' => 'Delivery Charges is Empty',
          ], 200);
        }
        if(empty($address)){
            return response()->json([
                'success'=>false,
                'message' => 'Address is Empty',
            ], 200);
        }
        if(empty($mobile)){
            return response()->json([
                'success'=>false,
                'message' => 'Mobile Number is Empty',
            ], 200);
        }
        if(empty($grand_total)){
            return response()->json([
                'success'=>false,
                'message' => 'Grand Total is Empty',
            ], 200);
        }
            $order = DB::table('cart')
            ->join('products', 'cart.product_id', '=','products.id')
            ->select('cart.id AS id','cart.*','products.price')
            ->where('cart.user_id','=', $user_id)
            ->get();
            if (count($order) >= 1) {
                foreach ($order as  $item):
                    // $id = $item['id'];
                    $id = $item->id;
                    $product_id = $item->product_id;
                    $total = $item->price;
                    $quantity = $item->quantity;

                    $order=new Order;
                    $order->user_id = $request->user_id;
                    $order->product_id = $product_id;
                    $order->method = $request->method;
                    $order->total = $total;
                    $order->quantity = $quantity;
                    $order->address = $request->address;
                    $order->mobile = $request->mobile;
                    $order->delivery_charges = $request->delivery_charges;
                    $order->status = 'Ordered';
                    $order->order_date = $date;
                    $order->save();

                    $cart = Cart::find($id);
                    $cart->delete();
                endforeach;

                if($method=='Wallet'){
                    $type = 'Upi';
                    $wallet=new Wallet;
                    $wallet->user_id = $request->user_id;
                    $wallet->date = $date;
                    $wallet->amount = $request->grand_total;
                    $wallet->type = $type;
                    $wallet->save();

                    Student::where('id', $user_id)
                    ->update(['balance' => DB::raw('balance - '.$grand_total)]);
                }

                return response()->json([
                   "success" => true ,
                    'message' => 'Order Placed Successfully',
                ], 400);
            }
        
    }
}