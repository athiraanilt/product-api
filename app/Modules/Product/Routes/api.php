<?php

Route::group(['middleware' =>['auth:api'],'namespace' => 'App\Modules\Product\Controllers'], function () {

    Route::post('/product/create', ['as' => 'product.create.p', 'uses' => 'Productcontroller@insert']);

    Route::get('/product/list', ['as' => 'product.list', 'uses' => 'Productcontroller@list']);

    Route::post('/product/{id}/edit', ['as' => 'product.edit', 'uses' => 'Productcontroller@edit']);

	Route::get('/product/{id}', ['as' => 'product', 'uses' => 'Productcontroller@show']);

    Route::post('/product/{id}/delete', ['as' => 'product.delete', 'uses' => 'Productcontroller@delete']);
});



?>
