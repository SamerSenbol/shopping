<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  ["uses"=>"ProductsController@index", "as"=> "allProducts"]);
Route::post('/saveorder', 'ProductsController@saveorder')->name('saveorder');
//Men
Route::get('products/men', ["uses"=>"ProductsController@menProducts", "as"=> "menProducts"]);

//Women
Route::get('products/women', ["uses"=>"ProductsController@womenProducts", "as"=> "womenProducts"]);

//search
Route::get('search', ["uses"=>"ProductsController@search", "as"=> "searchProducts"]);

/* Route::get('/', function () {
    return view('test');
}); */
Route::get('products', ["uses"=>"ProductsController@index", "as"=>"allProducts"]);
Route::get('product/addToCart/{id}', ['uses'=>'ProductsController@addProductToCart','as'=>'AddToCartProduct']);

//show cart items
Route::get('cart', ["uses"=>"ProductsController@showCart", "as"=>"cartproducts"]);
Route::get('payments', ["uses"=>"ProductsController@showpayments", "as"=>"payments"]);
Route::get('thanks', ["uses"=>"ProductsController@showthanks", "as"=>"thanks"]);
Route::get('verify', ["uses"=>"ProductsController@showverify", "as"=>"verify"]);

//delete item from cart
Route::get('product/deleteItemFromCart/{id}',['uses'=>'ProductsController@deleteItemFromCart','as'=>'DeleteItemFromCart']);

//increase single product in cart
Route::get('product/increaseSingleProduct/{id}',['uses'=>'ProductsController@increaseSingleProduct','as'=>'IncreaseSingleProduct']);


//decrease single product in cart
Route::get('product/decreaseSingleProduct/{id}',['uses'=>'ProductsController@decreaseSingleProduct','as'=>'DecreaseSingleProduct']);


//checkout page
Route::get('product/checkoutProducts/',['uses'=>'ProductsController@checkoutProducts','as'=>'checkoutProducts']);

//process checkout page
Route::post('product/createNewOrder/',['uses'=>'ProductsController@createNewOrder','as'=>'createNewOrder']);

//payment page
Route::get('payment/paymentpage', ["uses"=> "Payment\PaymentsController@showPaymentPage", 'as'=> 'showPaymentPage']);

//process payment & receipt page
Route::get('payment/paymentreceipt/{paymentID}/{payerID}', ["uses"=> "Payment\PaymentsController@showPaymentReceipt", 'as'=> 'showPaymentReceipt']);


//create an order
Route::get('product/createOrder/',['uses'=>'ProductsController@createOrder','as'=>'createOrder']);

//user authentication
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Admin Panel
Route::get('admin/products', ["uses"=>"Admin\AdminProductsController@index", "as"=> "adminDisplayProducts"])->middleware('restrictToAdmin');

//display edit product form
Route::get('admin/editProductForm/{id}', ["uses"=>"Admin\AdminProductsController@editProductForm", "as"=> "adminEditProductForm"]);

//display edit product image form
Route::get('admin/editProductImageForm/{id}', ["uses"=>"Admin\AdminProductsController@editProductImageForm", "as"=> "adminEditProductImageForm"]);

//update product image
Route::post('admin/updateProductImage/{id}', ["uses"=>"Admin\AdminProductsController@updateProductImage", "as"=> "adminUpdateProductImage"]);

//update product data
Route::post('admin/updateProduct/{id}', ["uses"=>"Admin\AdminProductsController@updateProduct", "as"=> "adminUpdateProduct"]);

//display create product form
Route::get('admin/createProductForm', ["uses"=>"Admin\AdminProductsController@createProdcutForm", "as"=> "adminCreateProductForm"]);

//send new product data to database
Route::post('admin/sendCreateProductForm/', ["uses"=>"Admin\AdminProductsController@sendCreateProductForm", "as"=> "adminSendCreateProductForm"]);

//delete product
Route::get('admin/deleteProduct/{id}', ["uses"=>"Admin\AdminProductsController@deleteProduct", "as"=> "adminDeleteProduct"]);


//storage
Route::get('/testStorage',function(){

    // return "<img src=".Storage::url('product_images/jacket.jpg').">";
   // return Storage::disk('local')->url('product_images/jacket.jpg');
   // print_r(Storage::disk("local")->exists("public/product_images/jacket.jpg"));
  // Storage::delete('public/product_images/jacket.jpg');

});
