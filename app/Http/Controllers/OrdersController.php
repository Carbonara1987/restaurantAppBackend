<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;

class OrdersController extends Controller
{
    public function createOrder(Request $request){
        $order = Orders::create($request->all());
        return response()->json($order);
    }

    public function getOrders(){
        $orders = Orders::all();
        return response()->json($orders);
    }

    public function getOrder($id){
        $orders = Orders::where('id',$id);
        return response()->json($orders);
    }

    public function updateOrder(Request $request, $id){
        $order = Orders::where('id',$id)
            ->update($request->all());
        return response()->json($order);
    }

    public function deleteOrder($id){
        $order = Orders::where('id',$id);
        return $order->delete();
    }
}
