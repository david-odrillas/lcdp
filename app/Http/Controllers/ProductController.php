<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth',['except' => 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $products =Product::where('category_id', $category->id)->get();
        return view('products.index', compact(['products', 'category']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        return view('products.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request, Category $category)
    {
      $path = $request->file('file')->store('public/images');
      $request->merge(['url' => Storage::url($path)]);
      $product = $category->products()->create($request->all());
      return redirect()->route('products.show', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Product $product)
    {
        return view('products.show', compact(['product', 'category']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Product $product)
    {
        return view('products.edit', compact(['category', 'product']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Product $product)
    {
        //
    }
}
