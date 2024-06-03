<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_can_user_fill_up_empty_fields()
    {
        $response = $this->post('/login',
            [
                'username' => '',
                'password' => ''
            ]
        );

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['username', 'password']);

        $view = $this->withViewErrors([
            'username' => ['The username field is required.'],
            'password' => ['The password field is required.']
        ])->view('blocks.auth');

        $view->assertSee('The username field is required.');
        $view->assertSee('The password field is required.');

        $this->assertGuest();
    }

    public function test_can_user_fill_up_fields_less_than_required_quantity_characters()
    {
        $response = $this->post('/login',
            [
                'username' => 'Jo',
                'password' => '1234'
            ]
        );

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['username', 'password']);

        $view = $this->withViewErrors([
            'username' => ['The username field must be at least 3 characters.'],
            'password' => ['The password field must be at least 8 characters.'],
        ])->view('blocks.auth');

        $view->assertSee('The username field must be at least 3 characters.');
        $view->assertSee('The password field must be at least 8 characters.');

        $this->assertGuest();
    }

    public function test_can_user_register()
    {
        $user = User::factory()->make();

        $attributes = [
            'username' => $user->name,
            'password' => '12345678'
        ];

        $response = $this->post('/login', $attributes);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', ['name' => $user->name]);

        $this->assertAuthenticated();

        $view = $this->view('blocks.jumbotron', ['name' => $user->name]);

        $view->assertSee($user->name);
    }

    public function test_can_user_login()
    {
        $user = User::factory()->create();

        $attributes = [
            'username' => $user->name,
            'password' => 'password'
        ];

        $response = $this->post('/login', $attributes);

        $response->assertRedirect('/');

        $this->assertAuthenticated();

        $view = $this->view('blocks.jumbotron', ['name' => $user->name]);

        $view->assertSee($user->name);
    }

    public function test_can_user_login_with_wrong_password()
    {
        $user = User::factory()->create();

        $attributes = [
            'username' => $user->name,
            'password' => '12345678'
        ];

        $response = $this->post('/login', $attributes);

        $response->assertRedirect('/');

        $response->assertSessionHasErrors(['password']);

        $view = $this->withViewErrors([
            'password' => ['The provided credentials do not match our records.'],
        ])->view('blocks.auth');

        $view->assertSee('The provided credentials do not match our records.');

        $this->assertGuest();
    }

    public function test_can_user_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/logout');

        $response->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_can_user_get_advertisements_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/advertisements');

        $response->assertStatus(200);
    }

    public function test_can_user_get_create_advertisement_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/advertisements/create');

        $response->assertStatus(200);
    }

    public function test_can_user_get_edit_mine_advertisement_page()
    {
        $user = User::factory()->create();

        $advertisement = Advertisement::factory()->create([
            'author_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get('/advertisements/' . $advertisement->id . '/edit');

        $response->assertStatus(200);
    }

    public function test_can_user_get_edit_stranger_advertisement_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/advertisements/1/edit');

        $response->assertStatus(403);
    }

    public function test_can_user_delete_stranger_advertisement()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/advertisements/1');

        $response->assertStatus(403);
    }

    public function test_can_user_delete_his_advertisement()
    {
        $user = User::factory()->create();

        $advertisement = Advertisement::factory()->create(
            [
                'author_id' => $user->id
            ]
        );

        $response = $this->actingAs($user)->delete('/advertisements/' . $advertisement->id);

        $response->assertRedirect('/');
    }
}
