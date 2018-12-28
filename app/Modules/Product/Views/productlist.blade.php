@extends('layouts.app')

@section('content')
@if(session()->has('message'))
      <div class="alert alert-success">
          {{  session()->get('message') }}
		  <a href="{{ route('show.cart') }}">View Cart</a>
      </div>
@endif
@if(session()->has('message1'))
      <div class="alert alert-success">
          {{  session()->get('message1') }}
      </div>
@endif
@if(session()->has('message2'))
      <div class="alert alert-success">
          {{  session()->get('message2') }}
      </div>
@endif
@if(session()->has('error1'))
      <div class="alert alert-danger">
          {{  session()->get('error1') }}
		  </div>
@endif
<link rel = "stylesheet" href = "{{ URL:: asset('css/common.css') }}">
<center><h2><b>Product List </b></h2></center>
<table border = 1 align="center">
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Title</th>
        <th>Price</th>
        <th>Image</th>
		    <th>Add to Cart</th>
    </tr>
	<?php $i = ($products->currentPage()-1) * $products->perPage() ?>
    @foreach ($products as $product)
    <tr>
        <td>{{++$i}}</td>
        <td>{{$product->name}}</td>
        <td>{{$product->description}}</td>
        <td>{{$product->title}}</td>
        <td>{{$product->price}}</td>
        <td>
            <img src="{{ route('showimage', $product->id) }}" height="80px" width="80px" />
        </td>
		    <td><a href = "{{route('addtocart',$product->id)}}">Add to cart</a></td>
    </tr>
    @endforeach
</table>
<br>
<center>
	<button onclick = "location.href = '{{ route('show.cart') }}';">View Cart</button>
  <button onclick = "location.href = '{{ route('search.order') }}';">Search Orders</button>
</center>
<br>
<div class="stylelink">
	{{$products->render() }}
</div>
@endsection
