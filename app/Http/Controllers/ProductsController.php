<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

class ProductsController extends Controller
{
    public function createProduct(Request $request){
        $product = Products::create($request->all());
        return response()->json($product);
    }

    public function getProducts(){
        $products = Products::all();
        return response()->json($products);
    }

    public function getProduct($id){
        $products = Products::where('id',$id);
        return response()->json($products);
    }

    public function updateProduct(Request $request, $id){
        $product = Products::where('id',$id)
            ->update($request->all());
        return response()->json($product);
    }

    public function deleteProduct($id){
        $product = Products::where('id',$id);
        return $product->delete();
    }
}
