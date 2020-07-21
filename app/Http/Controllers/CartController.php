<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;

class CartController extends Controller
{
    public function addProductToCart(Request $res)
    {

        $tableId = $res->tableId;

        $addToCart = Cart::session($tableId)->add(array(
            'id' => $res->id,
            'name' => $res->name,
            'price' => $res->price,
            'quantity' => $res->quantity
        ));

        return response()->json($res);


    }

    public function getCartContent(Request $res)
    {
        $tableId = $res->tableId;
        $cartProducts = Cart::session($tableId)->getContent();

        return response()->json($cartProducts);
    }

    public function removeFromCart(Request $res){
        $tableId = $res->tableId;
        $productId = $res->id;
        return Cart::session($tableId)->remove($productId);
    }

    public function updateCartQuantity(Request $res){
        $tableId = $res->tableId;
        $productId = $res->id;
        $actualProduct =  Cart::session($tableId)->get($productId);
        $actualQuantity = $actualProduct->quantity;

        Cart::session($tableId)->update( $productId, array(
                'quantity' => -$actualQuantity + $res->quantity
            )
        );



        return response()->json($res);

    }

    public function down(Request $res)
    {
        $tableId = $res->tableId;

        $drop = Cart::session($tableId)->truncate();
        if($drop){
            return redirect()->back();
        }
    }

    public function getCount(Request $res)
    {
        $tableId = $res->tableId;
        $cartContent =  \Cart::session($tableId)->getContent();
        $count = $cartContent->count();

        return json_encode($count);
    }

    public function getTotal(Request $res){
        $tableId = $res->tableId;
        $cartTotal =  \Cart::session($tableId)->getTotal();


        return response()->json($cartTotal);

    }
}
