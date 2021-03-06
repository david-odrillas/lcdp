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
  /**
   * guest: productos activos
   * admin: productos activos y desactivados
   */
  public function test_product_index_guest()
  {
    Category::factory()->hasProducts(3)->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 3);
    $category = Category::first();
    $products = Product::where('category_id', $category->id)->orderBy('name', 'DESC')->get();
    $response = $this->get('/categories/'.$category->id.'/products')
      ->assertOk()
      ->assertViewIs('products.index')
      ->assertViewHas('products', $products);
  }
  public function test_product_index_admin()
  {
    Category::factory()->hasProducts(3)->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 3);
    $category = Category::first();
    $products = Product::where('category_id', $category->id)->withTrashed()->orderBy('name', 'DESC')->get();
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
    $category = $product->category->id;
    $this->assertEquals($product->name,'PRODUCT TEST');
    $response->assertRedirect('categories/'.$category.'/products');
  }
  //solo usuarios autenticados pueden ver el show.
  // public function test_product_show_guest()
  // {
  //   Category::factory()->hasProducts()->create();
  //   $this->assertDatabaseCount('categories', 1);
  //   $this->assertDatabaseCount('products', 1);
  //   $product = Product::first();
  //   $response = $this->get('/products/'.$product->id);
  //   $response->assertRedirect('/login');
  // }
  // public function test_product_show_auth()
  // {
  //   $this->withoutExceptionHandling();
  //   $user = User::factory()->create();
  //   $this->actingAs($user);
  //   Category::factory()->hasProducts()->create();
  //   $this->assertDatabaseCount('categories', 1);
  //   $this->assertDatabaseCount('products', 1);
  //   $product = Product::first();
  //   $response = $this->get('/products/'.$product->id)
  //     ->assertOk()
  //     ->assertViewIs('products.show')
  //     ->assertViewHas('product');
  // }

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
    $this->get('/products/'.$product->id.'/edit')
      ->assertOk()
      ->assertViewIs('products.edit')
     // ->assertViewHas('category', $category);
      ->assertViewHas('product', $product);
  }
  // solo usuarios autenticados pueden actualizar.
  public function test_product_update_guest()
  {
    Category::factory()->hasProducts()->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products', 1);
    $product = Product::first();
    $response = $this->put('/products/'.$product->id,[
      'name' => 'Product Update'
    ]);
    $response->assertRedirect('/login');
  }
  public function test_product_update_name_price_auth()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    Category::factory()->hasProducts()->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products',1);
    $product = Product::first();
    $response = $this->put('/products/'.$product->id,[
      'name' => 'Product Update',
      'price' => 10.5
    ]);
    $product = $product->fresh();
    $category = $product->category->id;
    // dd($category);
    $this->assertEquals($product->name,'PRODUCT UPDATE');
    $this->assertEquals($product->price, 10.5);
    $response->assertRedirect('categories/'.$category.'/products');
  }
  public function test_product_update_file_auth()
  {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $this->actingAs($user);
    Category::factory()->hasProducts()->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products',1);
    $product = Product::first();
    Storage::fake();
    $file = UploadedFile::fake()->image('update.jpg');
    $response = $this->put('/products/'.$product->id,[
      'name' => 'Product Update',
      'price' => 10.5,
      'file' => $file,
    ]);
    Storage::assertExists('public/images/'.$file->hashName());
  //  dd($response->content());
    $product = $product->fresh();
    $category = $product->category->id;
    $this->assertEquals($product->name,'PRODUCT UPDATE');
    $this->assertEquals($product->price, 10.5);
    // $response->assertRedirect('/products/'.$product->id);
    $response->assertRedirect('categories/'.$category.'/products');
  }
  //softDelete method change status
  public function test_product_update_status_auth()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    Category::factory()->hasProducts()->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products',1);
    $product = Product::first();
    $response = $this->delete('/products/'.$product->id);
    $this->assertSoftDeleted($product);
  }
  //forceDelete
  public function test_product_delete_auth()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    Category::factory()->hasProducts()->create();
    $this->assertDatabaseCount('categories', 1);
    $this->assertDatabaseCount('products',1);
    $product = Product::first();
    $category = $product->category->id;
    $response = $this->delete('/products/'.$product->id.'/delete');
    $this->assertDeleted($product);
    $response->assertRedirect('categories/'.$category.'/products');
  }
}
//el show debe incluir with trased