@auth
<div class="row">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link disabled h2" aria-current="page">{{$category->name}}</a>
    </li>
    <li class="nav-item">
    <a class="btn btn-success" href="{{route('categories.products.create', $category->id)}}" role="button">Registrar Nuevo Producto</a>
    </li>
  </ul>      
</div>
@endauth
@guest 
<div class="row">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Categorias</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
    </ol>
  </nav>
</div>
@endguest