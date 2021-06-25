@extends('layouts.app')
@section('content')
<section class="row">
  <div class="col col-md-6 offset-md-3">
    <div class="card">
       <img src="{{$category->url}}" class="card-img-top" alt="error al cargar la imagen">
      <div class="card-body">
        <form action="{{route('categories.update', $category->id)}}" method="post"  autocomplete="off" enctype="multipart/form-data">
          @method('PUT')
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label"><strong>{{'Categoria:'}}</strong></label>
            <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}">
            @error('name')
              <span class="text-danger">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="file" class="form-label"><strong>{{'Imagen:'}}</strong></label>
            <input type="file" class="form-control" name="file" id="file" accept="image/*">
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>

  </div>
</section>
@endsection
