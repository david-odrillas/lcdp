@extends('layouts.app')
@section('content')
<section class="row">
  <div class="col col-md-6 offset-md-3">
    <div class="card">
       <img src="{{$product->url}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">{{$product->name}}</h5>
      </div>
      <div class="list-group list-group-flush ">
        <a href="{{route('categories.products.index', $product->category->id)}}" class="btn btn-info">Volver a Productos</a>
        <a href="{{route('products.edit', $product->id)}}" class="btn btn-warning">Editar</a>
        <form action="{{route('products.destroy', $product->id)}}"  method="POST">
        @csrf
        @method('DELETE')
          <button type="submit" class="btn btn-danger w-100">Eliminar</button>
        </form>

      </div>
    </div>

  </div>
</section>
@endsection
