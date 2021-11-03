<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request){

        try {
            $products = $this->filters(Product::select('*'),$request);
            $products = $products->paginate(12);
            return response()->json([
                'products' => $products,
                'status' => JsonResponse::HTTP_OK,
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }

    public function filters($products,$request){
        $name = $request['name'] ? $request['name'] : '';
        $order = $request['order'] ? $request['order'] : '';
        if($name)
            $products = $products->where('name',$name);
        if($order)
            $products = $products->orderBy('price',$order);
        return $products;
    }
}
