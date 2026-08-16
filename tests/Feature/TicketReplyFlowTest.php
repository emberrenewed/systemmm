<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Models\User;
use Tests\TestCase;

class TicketReplyFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_and_admin_can_reply_back_and_forth_with_images(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['email' => 'user@test.com']);
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'is_admin' => true,
        ]);

        $create = $this->actingAs($user, 'sanctum')
            ->postJson('/api/tickets', [
                'subject' => 'Cannot login',
                'description' => 'The login page returns an error.',
            ])
            ->assertStatus(201);

        $ticketId = $create->json('data.id');

        $this->actingAs($user, 'sanctum')
            ->post("/api/tickets/{$ticketId}/replies", [
                'message' => 'User should not reply first.',
            ], ['Accept' => 'application/json'])
            ->assertStatus(403);

        $adminImage = UploadedFile::fake()->image('admin.png');

        $this->actingAs($admin, 'sanctum')
            ->post("/api/tickets/{$ticketId}/replies", [
                'message' => 'Thanks, we are looking into this.',
                'image' => $adminImage,
            ], ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonPath('data.message', 'Thanks, we are looking into this.')
            ->assertJsonPath('ticket_status', 'in_progress');

        $userImage = UploadedFile::fake()->image('screenshot.jpg');

        $this->actingAs($user, 'sanctum')
            ->post("/api/tickets/{$ticketId}/replies", [
                'message' => 'Here is a screenshot.',
                'image' => $userImage,
            ], ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonPath('data.message', 'Here is a screenshot.');

        $this->actingAs($admin, 'sanctum')
            ->post("/api/tickets/{$ticketId}/replies", [
                'message' => 'Got the screenshot, we will fix it.',
            ], ['Accept' => 'application/json'])
            ->assertStatus(201);

        $show = $this->actingAs($user, 'sanctum')
            ->getJson("/api/tickets/{$ticketId}")
            ->assertStatus(200)
            ->assertJsonCount(3, 'data.replies');

        $this->assertNotNull($show->json('data.replies.0.image'));
        $this->assertNotNull($show->json('data.replies.0.image_url'));
        $this->assertNotNull($show->json('data.replies.1.image'));
        $this->assertNotNull($show->json('data.replies.1.image_url'));
        $this->assertNull($show->json('data.replies.2.image'));

        Storage::disk('public')->assertExists($show->json('data.replies.0.image'));
        Storage::disk('public')->assertExists($show->json('data.replies.1.image'));
    }
}
