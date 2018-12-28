@extends('layouts.app')

@section('content')

@if(session()->has('message'))
      <div class="alert alert-success">
            {{ session()->get('message') }}
      </div>
@endif
@if(session()->has('error1'))
      <div class="alert alert-danger">
          {{  session()->get('error1') }}
		  </div>
@endif
<div class = "container stylecontainer" >
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label><b>Product Name</b></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Productname" >
                {!! $errors->first('name', '<p class="a" style = "color: red;">:message</p>') !!}
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label><b>Description</b></label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" >
                {!! $errors->first('description', '<p class="a" style = "color: red;">:message</p>') !!}
            </div>
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label><b>Title</b></label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" >
                {!! $errors->first('title', '<p class="a" style = "color: red;">:message</p>') !!}
            </div>
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                <label><b>Price</b></label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" >
                {!! $errors->first('price', '<p class="a" style = "color: red;">:message</p>') !!}
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label><b>Image</b></label>
                <br>
                <input type="file" class="form-control" name="image"/>
                {!! $errors->first('image', '<p class="a" style = "color: red;">:message</p>') !!}
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>

@endsection
