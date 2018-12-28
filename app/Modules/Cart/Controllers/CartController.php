<?php

namespace App\Modules\Cart\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Cart\Models\Cart ;

use App\Modules\Product\Models\Product ;

use App\Http\Requests;

use Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;

class CartController extends Controller
{

	public function add_to_cart(Request $request,$id) {

        if (Product::where('id', $id)->exists()) {

		    $carts = new Cart;

			$cart_table = (new Cart())->getTable();

	    	$inputs = Input::all();

		    $rules = $this->rules();

    		$messages = $this->messages();

  			$validator = Validator::make($inputs,$rules,$messages);

          	if ($validator->fails()) {

              	return response()->json(['errors' => $validator->errors(), 'message' => 'validation error'], 400);

          	}

    		$user_id = Auth::user()->id;

	        $products = Cart::where('productid', '=', $id)->first();

	        if(is_null($products)) {

              	$carts->quantity = $request->quantity;

      		    $carts->productid = $id;

      		    $carts->userid = $user_id;

              	$carts->save();

				$created_cart = $carts->id;

				$created_cart = Cart::select($cart_table.'.*' )

								->where($cart_table.'.id',$created_cart)

	   							->first();

				$response = [ 'Cart' => $created_cart];

		   		return response()->json(['data' => $response, 'message' =>'Product successfully added to cart'], 200);

          	} else{

              	$totalquantity = $products->quantity + $request->quantity;

              	Cart::where('productid', '=', $id)->where('userid', '=', $user_id)->update(['quantity'=>$totalquantity]);

				$created_cart = Cart::select($cart_table.'.*' )

								->where($cart_table.'.productid',$id)

						   		->first();

		   		$response = [ 'Cart' => $created_cart];

		   		return response()->json(['data' => $response, 'message' =>'Quantity of product updated'], 200);

          	}

        } else {

            return response()->json(['code' => '400', 'error'=>'No such product id exists'], 400);

        }

	}

    public function rules() {

      	return [

        	'quantity' => 'required|numeric',

      	];

    }

    public function messages() {

      	return [

        	'quantity.required' => 'Quantity is required!',

	    	'quantity.numeric' => 'Quantity should be numeric!',

      	];

    }

    public function show_cart() {

        $user_id = Auth::user()->id;

        $cart_tbl = (new Cart())->getTable();

        $product_tbl = (new Product())->getTable();

        $carts = Cart::select($product_tbl.'.*',$cart_tbl.'.date', $cart_tbl.'.quantity' )

				->join('products', $product_tbl.'.id', '=', $cart_tbl.'.productid')

				->where($cart_tbl.'.userid','=',$user_id)

				->Paginate(3);

		foreach ($carts as $cart){

			$cart_list[] =['id' => $cart->id, 'name' => $cart->name, 'description' => $cart->description, 'title' => $cart->title, 'price' => $cart->price, 'date' => $cart->date, 'quantity' => $cart->quantity];

		}

		$pagination = ['perPage' => $carts->perPage(), 'currentPage' => $carts->currentPage(), 'lastPage' => $carts->lastPage()];

		$response = [ 'Cart' => $cart_list, 'pagination' => $pagination];

		return response()->json(['data' => $response, 'message' =>'Cart list'], 200);

    }

    public function remove_product(Request $request) {

		$id = $request->id;

        $user_id = Auth::user()->id;

        $cart_tbl = (new Cart())->getTable();

        $product_tbl = (new Product())->getTable();

        Cart::where('productid', $id)->where('userid', $user_id)->delete();

        $carts = Cart::select($product_tbl.'.name', $product_tbl.'.price', $cart_tbl.'.date', $cart_tbl.'.quantity', $product_tbl.'.id')

				->join('products', $product_tbl.'.id', '=', $cart_tbl.'.productid')

				->where($cart_tbl.'.userid','=',$user_id)

				->get();

		$response = [ 'Cart' => $carts];

        return response()->json(['data' => $response, 'message' =>'Cart list'], 200);

    }

    public function empty_cart() {

        $user_id = Auth::user()->id;

        Cart::where('userid', $user_id)->delete();

        return response()->json(['message'=>'Cart deleted successfully'], 200);

    }

}
