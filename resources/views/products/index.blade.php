@extends('layouts.app')
@section('content')
    @include('products.btn-new')
    <section class="row">
      @foreach($products as $product)
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 p-2">
          <div class="card">
            <img src="{{asset($product->url)}}" class="card-img-top img-fluid" alt="error al cargar la imagen">
            <div class="card-body">
              <h5 class="card-title">{{$product->name}}</h5>
              <h5 class="card-title">BOB. {{$product->price}}</h5>
              @auth
              <a class="btn btn-warning" href="{{route('products.show', $product->id)}}" role="button">{{'Ver'}}</a>
              @endauth
            </div>
          </div>
      </div>
      @endforeach
    </section>
@endsection