<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class CategoryTest extends TestCase
{
  use RefreshDatabase;
    //todos pueden ver el index.
    public function test_category_index()
    {
      $this->withoutExceptionHandling();
      Category::factory()->count(3)->create();
      $this->assertDatabaseCount('categories', 3);
      $categories = Category::all();
      $response = $this->get('/categories')
        ->assertOk()
        ->assertViewIs('categories.index')
        ->assertViewHas('categories', $categories);

    }
    // solo usuarios autenticados pueden crear.
    public function test_category_store_guest()
    {
      $response = $this->post('/categories',[
        'name' => 'Category Example'
      ]);
      $response->assertRedirect('/login');
    }
    public function test_category_store_auth()
    {
      //$this->withoutExceptionHandling();
      $user = User::factory()->create();
      $this->actingAs($user);
      Storage::fake();
      $file = UploadedFile::fake()->image('test.jpg');
      $response = $this->post('/categories',[
        'name' => 'Category Example',
        'file' => $file,
      ]);
      Storage::assertExists('public/images/'.$file->hashName());
      //$response->assertOk();
      $this->assertDatabaseCount('categories', 1);
      $category = Category::first();
      $this->assertEquals($category->name,'CATEGORY EXAMPLE');
      $response->assertRedirect('/categories/'.$category->id);
    }
    //solo usuarios autenticados pueden ver el show.
    public function test_category_show_guest()
    {
      Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      $category = Category::first();
      $response = $this->get('/categories/'.$category->id);
      $response->assertRedirect('/login');
    }
    public function test_category_show_auth()
    {
      $this->withoutExceptionHandling();
      $user = User::factory()->create();
      $this->actingAs($user);
      Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      $category = Category::first();
      $response = $this->get('/categories/'.$category->id)
        ->assertOk()
        ->assertViewIs('categories.show')
        ->assertViewHas('category');
    }
    // solo usuarios autenticados pueden actualizar.
    public function test_category_update_guest()
    {
      //$this->withoutExceptionHandling();
      $category = Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      $response = $this->put('/categories/'.$category->id,[
        'name' => 'Category Example'
      ]);
      $response->assertRedirect('/login');
    }
    public function test_category_update_name_auth()
    {
      $user = User::factory()->create();
      $this->actingAs($user);
      $category = Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      //Storage::fake();
      //$file = UploadedFile::fake()->image('update.jpg');
      $response = $this->put('/categories/'.$category->id,[
        'name' => 'Category Update',
      //  'file' => $file,
      ]);
      //Storage::assertExists('public/images/'.$file->hashName());
    //  dd($response->content());
      $category = $category->fresh();
      $this->assertEquals($category->name,'CATEGORY UPDATE');
      $response->assertRedirect('/categories/'.$category->id);
    }
    public function test_category_update_full_auth()
    {
      $user = User::factory()->create();
      $this->actingAs($user);
      $category = Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      Storage::fake();
      $file = UploadedFile::fake()->image('update.jpg');
      $response = $this->put('/categories/'.$category->id,[
        'name' => 'Category Update',
        'file' => $file,
      ]);
      Storage::assertExists('public/images/'.$file->hashName());
      $category = $category->fresh();
      $this->assertEquals($category->name,'CATEGORY UPDATE');
      $response->assertRedirect('/categories/'.$category->id);
    }
    //solo auth;
    public function test_category_delete_guest()
    {
      $category = Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      $response = $this->delete('/categories/'.$category->id);
      $this->assertDatabaseCount('categories', 1);
      $response->assertRedirect('/login');
    }
    public function test_category_delete_auth()
    {
      $user = User::factory()->create();
      $this->actingAs($user);
      $category = Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      $response = $this->delete('/categories/'.$category->id);
      $this->assertDatabaseCount('categories', 0);
      $response->assertRedirect('/categories');
    }
    //formularios create y edit: solo auth.
    public function test_category_create_guest()
    {
      $response = $this->get('/categories/create');
      $response->assertRedirect('/login');
    }
    public function test_category_create_auth()
    {
      $user = User::factory()->create();
      $this->actingAs($user);
      $this->get('/categories/create')
        ->assertOk()
        ->assertViewIs('categories.create');
    }
    public function test_category_edit_guest()
    {
      $category = Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      $response = $this->get('/categories/'.$category->id.'/edit');
      $response->assertRedirect('/login');
    }
    public function test_category_edit_auth()
    {
      $this->withoutExceptionHandling();
      $user = User::factory()->create();
      $this->actingAs($user);
      $category = Category::factory()->create();
      $this->assertDatabaseCount('categories', 1);
      $this->get('/categories/'.$category->id.'/edit')
        ->assertOk()
        ->assertViewIs('categories.edit');
    }
    //validaciones Metodo store: campos obligatorios;
    public function test_category_store_name_required()
    {
      $user = User::factory()->create();
      $this->actingAs($user);
      Storage::fake();
      $file = UploadedFile::fake()->image('test.jpg');
      $response = $this->post('/categories',[
        'name' => '',
        'file' => $file,
      ]);
      $response->assertSessionHasErrors('name');
    }
    public function test_category_store_file_required()
    {
      $user = User::factory()->create();
      $this->actingAs($user);
      Storage::fake();
      $file = UploadedFile::fake()->image('test.jpg');
      $response = $this->post('/categories',[
        'name' => 'test',
        'file' => '',
      ]);
      $response->assertSessionHasErrors('file');
    }
}
