<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountPasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_is_updated_when_confirmation_matches(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('account.password.update'), [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertRedirect(route('account.password.edit'))
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_mismatched_new_password_shows_confirmation_error_without_updating_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from(route('account.password.edit'))
            ->put(route('account.password.update'), [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'different-password',
            ]);

        $response
            ->assertOk()
            ->assertSeeText('Pengesahan kata laluan tidak sepadan.');

        $this->assertTrue(Hash::check('password', $user->refresh()->password));
    }
}
