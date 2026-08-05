<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_health_endpoint_returns_a_successful_response(): void
    {
        // This is an API-only application, so there is no "/" route to hit.
        $response = $this->get('/up');

        $response->assertStatus(200);
    }

    public function test_protected_routes_reject_unauthenticated_requests(): void
    {
        $this->getJson('/api/tickets')
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}
