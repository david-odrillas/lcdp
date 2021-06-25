<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductTest extends TestCase
{
  use RefreshDatabase;
  //todos pueden ver el index.
  public function test_product_index()
  {
    //$this->withoutExceptionHandling();
    Category::factory()->hasProducts(3)->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 3);
    $category = Category::first();
    $products = Product::where('category_id', $category->id)->get();
    $response = $this->get('/categories/'.$category->id.'/products')
      ->assertOk()
      ->assertViewIs('products.index')
      ->assertViewHas('products', $products);
  }
  // solo usuarios autenticados pueden crear.
  public function test_product_store_guest()
  {
  Category::factory()->create();
  $this->assertDatabaseCount('categories', 1);
  $category = Category::first();
  $response = $this->post('/categories/'.$category->id.'/products',[
    'name' => 'Product Example'
  ]);
  $response->assertRedirect('/login');
  }
  public function test_product_store_auth()
  {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $this->actingAs($user);
    $category = Category::factory()->create();
    $this->assertDatabaseCount('categories', 1);
    Storage::fake();
    $file = UploadedFile::fake()->image('product.jpg');
    $response = $this->post('/categories/'.$category->id.'/products',[
      'name' => 'Product Test',
      'price' => 5.5,
      'file' => $file,
    ]);
    Storage::assertExists('public/images/'.$file->hashName());
    $this->assertDatabaseCount('products', 1);
    $product = Product::first();
    $this->assertEquals($product->name,'Product Test');
    $response->assertRedirect('/products/'.$product->id);
  }
  //solo usuarios autenticados pueden ver el show.
  public function test_product_show_guest()
  {
    Category::factory()->hasProducts()->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 1);
    $product = Product::first();
    $response = $this->get('/products/'.$product->id);
    $response->assertRedirect('/login');
  }
  public function test_product_show_auth()
  {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $this->actingAs($user);
    Category::factory()->hasProducts()->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 1);
    $product = Product::first();
    $response = $this->get('/products/'.$product->id)
      ->assertOk()
      ->assertViewIs('products.show')
      ->assertViewHas('product');
  }

  //formularios create y edit: solo auth.
  public function test_product_create_guest()
  {
    Category::factory()->create();
    $this->assertDatabaseCount('categories', 1);
    $category = Category::first();
    $response = $this->get('/categories/'.$category->id.'/products/create');
    $response->assertRedirect('/login');
  }
  public function test_product_create_auth()
  {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $this->actingAs($user);
    Category::factory()->create();
    $this->assertDatabaseCount('categories', 1);
    $category = Category::first();
    $response = $this->get('/categories/'.$category->id.'/products/create')
      ->assertOk()
      ->assertViewIs('products.create')
      ->assertViewHas('category', $category);
  }
  public function test_product_edit_guest()
  {
    $category = Category::factory()->hasProducts(3)->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 3);
    $product = Product::first();
    $response = $this->get('/products/'.$product->id.'/edit');
    $response->assertRedirect('/login');
  }
  public function test_product_edit_auth()
  {
    //$this->withoutExceptionHandling();
    $user = User::factory()->create();
    $this->actingAs($user);
    Category::factory()->hasProducts(3)->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 3);
    $product = Product::first();
    //$category = Category::first();
    $this->get('/products/'.$product->id.'/edit')
      ->assertOk()
      ->assertViewIs('products.edit')
     // ->assertViewHas('category', $category);
      ->assertViewHas('product', $product);
  }
}
