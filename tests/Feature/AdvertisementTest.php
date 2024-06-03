<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertisementTest extends TestCase
{
    public function test_can_user_create_advertisements_with_empty_fields()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/advertisements',
            [
                'title' => '',
                'description' => '',
                'image' => '',
                'author_id' => $user->id,
            ]
        );

//        $response->assertRedirect('/');

        $response->assertSessionHasErrors(['title', 'description']);

        $view = $this->withViewErrors([
            'title' => ['The title field is required.'],
            'description' => ['The description field is required.'],
        ])->view('advertisements.create');

        $view->assertSee('The title field is required.');
        $view->assertSee('The description field is required.');
    }

    public function test_can_user_create_advertisements_with_less_quantity_characters()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/advertisements',
            [
                'title' => 'Test',
                'description' => 'Hello World',
                'image' => '',
                'author_id' => $user->id,
            ]
        );

//        $response->assertRedirect('/');

        $response->assertSessionHasErrors(['title', 'description']);

        $view = $this->withViewErrors([
            'title' => ['The title field must be at least 5 characters.'],
            'description' => ['The description field must be at least 15 characters.'],
        ])->view('advertisements.create');

        $view->assertSee('The title field must be at least 5 characters.');
        $view->assertSee('The description field must be at least 15 characters.');
    }
}
