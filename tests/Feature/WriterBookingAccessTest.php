<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class WriterBookingAccessTest extends TestCase
{
    public function test_writer_cannot_access_client_booking_pages(): void
    {
        $writer = new User([
            'name' => 'Writer MeSketch',
            'email' => 'writer@example.test',
            'role' => 'writer',
        ]);
        $writer->id = 10;

        $this->actingAs($writer)
            ->get(route('bookings.index'))
            ->assertForbidden();

        $this->actingAs($writer)
            ->post(route('bookings.store'), [])
            ->assertForbidden();
    }
}
