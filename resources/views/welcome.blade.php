@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col col-md-6 offset-md-3 text-center pt-1">
    
    <img class="mb-4" src="logo-verde.svg" alt="" width="200" >
      <h1 class="display-1">HOLA</h1>
      <H1 class="display-5">ERES MAYOR DE 18?</H1>
      <div class="pt-5">
        <a class="btn btn-outline-success btn-lg" href="{{route('categories.index')}}" role="button">SI</a>
        <a class="btn btn-outline-secondary btn-lg" href="#" role="button">NO</a>
      </div>
    </div>
  </div>

@endsection
