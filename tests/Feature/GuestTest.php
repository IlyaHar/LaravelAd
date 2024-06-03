<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestTest extends TestCase
{
    public function test_can_guest_logout()
    {
        $response = $this->get('/logout');

        $response->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_can_guest_get_advertisements_page()
    {
        $response = $this->get('/advertisements');

        $response->assertRedirect('/');
    }

    public function test_can_guest_get_create_advertisement_page()
    {
        $response = $this->get('/advertisements/create');

        $response->assertRedirect('/');
    }

    public function test_can_guest_get_edit_advertisement_page()
    {
        $advertisement = Advertisement::factory()->create();

        $response = $this->get('/advertisements/' . $advertisement->id . '/edit');

        $response->assertRedirect('/');
    }

    public function test_can_guest_get_show_advertisement_page()
    {
        $advertisement = Advertisement::factory()->create();

        $response = $this->get('/advertisements/' . $advertisement->id );

        $response->assertStatus(200);
    }
}
