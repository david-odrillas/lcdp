<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function guest_view_index()
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertViewIs('welcome');
    }
    /**
     * @test
     * login view
     */
    public function guest_view_login()
    {
        $response = $this->get('login');
        $response->assertOk()
            ->assertViewIs('auth.login');
    }
    /**
     * @test
     * login admin
     */
    public function login_admin()
    {
        //$this->withoutExceptionHandling();
        User::factory()->create([
            'email' => 'test@lcdp.com'
        ]);
        $this->assertDatabaseCount('users', 1);
        $response = $this->post('/login',[
            'name' => 'test@lcdp.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
    }
}
