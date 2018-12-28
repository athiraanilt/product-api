<?php

Route::group(['middleware' => ['auth:api'], 'namespace' => 'App\Modules\Cart\Controllers'], function(){

  Route::post('/addtocart/{id}', ['as' => 'addtocart', 'uses' => 'CartController@add_to_cart']);

  Route::get('/showcart', ['as' => 'show.cart', 'uses' => 'CartController@show_cart']);

  Route::post('/removeproduct', ['as' => 'remove.product', 'uses' => 'CartController@remove_product']);

  Route::post('/emptycart', ['as' => 'empty.cart', 'uses' => 'CartController@empty_cart']);

});
