@extends('layouts.app')
@section('content')
<section class="row">
  <div class="col col-md-6 offset-md-3">
    <div class="card">
      <div class="card-body">
        <legend class="card-title">Crear Categoria</legend>
        <form class="" action="{{route('categories.store')}}" method="post"  autocomplete="off" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label"><strong>{{'Categoria'}}</strong></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
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
