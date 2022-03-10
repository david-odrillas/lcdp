@extends('layouts.app')
@section('content')
<div class="row justify-content-end mb-2">
    <div class="col-auto">
      @include('categories.btn-new')
    </div>
</div>
    <section class="row">
      @foreach($categories as $category)
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 p-2">
          <div class="card">
            <img src="{{asset($category->url)}}" class="card-img-top img-fluid" alt="error al cargar la imagen">
            <div class="card-body">
              <h5 class="card-title">{{$category->name}}</h5>
              <a class="btn btn-success" href="{{route('categories.products.index', $category->id)}}" role="button">Ver Productos</a>
              @auth
              <a class="btn btn-warning" href="{{route('categories.show', $category->id)}}" role="button">{{'Ver'}}</a>
              @endauth
            </div>
          </div>
      </div>
      @endforeach
    </section>
@endsection
