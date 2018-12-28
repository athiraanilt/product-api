<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;

use Log;

use Auth;

use File;

use Response;

use App\Modules\Product\Models\Product ;

use App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Storage;

use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{

    public function show($id) {

    	$products = Product::find($id);

    	if(!$products){

    		return response()->json(['error'=>'invalid product'], 400);

    	}

        $response = ['products' =>$products];

        return response()->json(['data' => $response,'message'=> 'Product list'], 200);

	}

    public function rules() {

        return [

            'name' => 'required|string|max:100',

            'description' => 'required|string',

            'title' => 'required|string',

            'price' => 'required|numeric',

        ];

    }

    public function messages() {

        return [

            'name.required' => 'Name is required!',

            'description.required' => 'Description is required!',

            'title.required' => 'Title is required!',

            'price.required' => 'Price is required!',

        ];

    }

    public function insert(Request $request) {

        $products = new Product;

        $inputs = Input::all();

        $rules = $this->rules();

        $messages = $this->messages();

        $product_table = (new Product())->getTable();

        $validator = Validator::make($inputs,$rules,$messages);

        if ($validator->fails()) {

            return response()->json(['errors'=>$validator->errors()], 400);

        }

        $products->name = $request->name;

        $products->description = $request->description;

        $products->title = $request->title;

        $products->price = $request->price;

        $products->save();

        $created_product = Product::select('name', 'title', 'description', 'price')->where($product_table.'.id', $products->id)->first();

        return response()->json(['data' => $created_product,'message'=> 'Product created'], 200);

    }

    public function edit(Request $request,$id) {

        $products = Product::find($id);

        if(!$products){

            return response()->json(['error'=>'invalid product'], 400);

        }

        $inputs = Input::all();

        $rules = $this->rules();

        $messages = $this->messages();

        $product_table = (new Product())->getTable();

        $validator = Validator::make($inputs,$rules,$messages);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors(), 'message' => 'validation error'], 400);

        }

        $products->name = $request->name;

        $products->description = $request->description;

        $products->title = $request->title;

        $products->price = $request->price;

        $products->save();

        $created_product = Product::select('name', 'title', 'description', 'price')->where($product_table.'.id', $products->id)->first();

        return response()->json(['data' => $created_product,'message'=> 'Task edited '], 200);

    }

    public function list() {

        $product_table = (new Product())->getTable();

        $products = Product::Paginate(5);


        foreach($products as $product){

            $product_list[] =['id' => $product->id, 'name' => $product->name, 'description' => $product->description, 'title' => $product->title, 'price' => $product->price];

        }

        $pagination = ['perPage' => $products->perPage(), 'currentPage' => $products->currentPage(), 'lastPage' => $products->lastPage()];


        $response = ['products' =>$product_list, 'pagination' => $pagination];


        return response()->json(['data' => $response,'message'=> 'Product list'], 200);

    }

    public function delete($id) {

        $deleted_product = Product::where('id', $id)->delete();

        $products = Product::all();

        $response = ['products' =>$products];

       return response()->json(['data' => $response,'message'=> 'Product list'], 200);

    }

}
