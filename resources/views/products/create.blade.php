@extends('layouts.app')
@section('content')
<section class="row">
  <div class="col col-md-6 offset-md-3">
    <div class="card">
      <div class="card-body">
        <legend class="card-title">Crear Producto - <strong>Categoria: {{$category->name}}</strong></legend>
        <form class="" action="{{route('categories.products.store', $category->id)}}" method="post"  autocomplete="off" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label"><strong>{{'Producto'}}</strong></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
              <span class="text-danger">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="price" class="form-label"><strong>{{'Precio'}}</strong></label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('name') }}" required>
            @error('price')
              <span class="text-danger">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="file" class="form-label"><strong>{{'Imagen:'}}</strong></label>
            <input type="file" class="form-control" name="file" id="file" accept="image/*">
            @error('file')
              <span class="text-danger">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <button type="submit" class="btn btn-success">Guardar</button>
        </form>
      </div>
    </div>

  </div>
</section>
@endsection
