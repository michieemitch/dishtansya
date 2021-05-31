<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
// use App\Http\Resources\OrdersResource;
use DB;

class OrdersController extends Controller
{
    public function order(Request $reques){
        try {


            if(!request('product_id')) return response()->json(['message' => 'Product ID is required'], 400);
            if(!request('quantity')) return response()->json(['message' => 'Quantity is required'], 400);

            $chkproductqty = Product::find(request('product_id'));
            if (!$chkproductqty) {
                return response()->json(['message' => 'Product Not Found'], 400);
            }

            $Order = new Order();
            $Order->product_id = request('product_id');
            $Order->quantity = request('quantity');
            $Order->save();
            return response()->json(['message' => 'You have successfully ordered this product.'], 201);
    
        } catch (\Exception $e) {
    
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
}
