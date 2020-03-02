<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cart;

class ProductsController extends Controller
{
    //

    public function index(){
        /*
        $products =[0=>["name"=>"Iphone","category"=>"smart phones","price"=>1000],
                    1=>["name"=>"Galaxy","category"=>"smart phones","price"=>500],
                    2=>["name"=>"Sony","category"=>"smart phones","price"=>200]];
        */
        $products = Product::paginate(3);
        return view("allproducts",compact("products"));
    }


    public function menProducts(){

        $products = DB::table('products')->where('type', "Men")->get();
         return view("menProducts",compact("products"));
     }
 
 
     public function womenProducts(){
         $products = DB::table('products')->where('type', "Women")->get();
         return view("womenProducts",compact("products"));
     }

     public function search(Request $request){

        $searchText = $request->get('searchText');
        $products = Product::where('name',"Like",$searchText."%")->paginate(3);
        return view("allproducts",compact("products"));
    }

    public function addProductToCart(Request $request,$id){

    //        $request->session()->forget("cart");
    //        $request->session()->flush();

        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id,$product);
        $request->session()->put('cart', $cart);

        //dump($cart);

        return redirect()->route("allProducts");
    
    }

    public function showCart(){

        $cart = Session::get('cart');

        //cart is not empty
        if($cart){
            return view('cartproducts',['cartItems'=> $cart]);

         //cart is empty
        }else{
            return redirect()->route("allProducts");
        }

    }

    public function deleteItemFromCart(Request $request,$id){

        $cart = $request->session()->get("cart");

        if(array_key_exists($id,$cart->items)){
            unset($cart->items[$id]);

        }

        $prevCart = $request->session()->get("cart");
        $updatedCart = new Cart($prevCart);
        $updatedCart->updatePriceAndQunatity();

        $request->session()->put("cart",$updatedCart);

        return redirect()->route('cartproducts');

    }
    

    public function increaseSingleProduct(Request $request,$id){


        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id,$product);
        $request->session()->put('cart', $cart);

        //dump($cart);

        return redirect()->route("cartproducts");


    }
    
    






       public function decreaseSingleProduct(Request $request,$id){


      
        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        if( $cart->items[$id]['quantity'] > 1){
                  $product = Product::find($id);
                  $cart->items[$id]['quantity'] = $cart->items[$id]['quantity']-1;
                  $cart->items[$id]['totalSinglePrice'] = $cart->items[$id]['quantity'] *  $product['price'];
                  $cart->updatePriceAndQunatity();
              
                  $request->session()->put('cart', $cart);
                  
          }

       

        return redirect()->route("cartproducts");


    }

    public function checkoutProducts(){

        return view('checkoutproducts');
 
     }

    public function createOrder(){
        $cart = Session::get('cart');

        //cart is not empty
        if($cart) {
        // dump($cart);
            $date = date('Y-m-d H:i:s');
            $newOrderArray = array("status"=>"on_hold","date"=>$date,"del_date"=>$date,"price"=>$cart->totalPrice);
            $created_order = DB::table("orders")->insert($newOrderArray);
            $order_id = DB::getPdo()->lastInsertId();;


            foreach ($cart->items as $cart_item){
                $item_id = $cart_item['data']['id'];
                $item_name = $cart_item['data']['name'];
                $item_price = $cart_item['data']['price'];
                $newItemsInCurrentOrder = array("item_id"=>$item_id,"order_id"=>$order_id,"item_name"=>$item_name,"item_price"=>$item_price);
                $created_order_items = DB::table("order_items")->insert($newItemsInCurrentOrder);
            }

            //delete cart
            Session::forget("cart");
            Session::flush();
            return redirect()->route("allProducts")->withsuccess("Thanks For Choosing Us");

        }else{

            return redirect()->route("allProducts");

        }


    }
}
