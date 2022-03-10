@extends('layouts.app')
@section('content')
<div class="row justify-content-between mb-2">
    <div class="col mb-2">
    <a href="{{route('categories.index')}}" class="btn btn-secondary">Volver a Categorias</a>
    </div>
    <div class="col-auto">
      @include('categories.btn-new')
    </div>
</div>
  
<section class="row">
  <div class="col col-md-6 offset-md-3">
    <div class="card">
       <img src="{{$category->url}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">{{$category->name}}</h5>
      </div>
      <div class="list-group list-group-flush ">
        <a href="{{route('categories.products.index', $category->id)}}" class="btn btn-success mb-2">Ver Productos</a>
        <a href="{{route('categories.edit', $category->id)}}" class="btn btn-warning mb-2">Editar</a>
        <form action="{{route('categories.destroy', $category->id)}}"  method="POST">
        @csrf
        @method('DELETE')
          <button type="submit" class="btn btn-danger w-100">Eliminar</button>
        </form>

      </div>
    </div>


  </div>
</section>

@endsection
