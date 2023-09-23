<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    public function test_user_registration_return_a_successful_response(): void
    {
        $this->json('POST', route('register'), [
            'name'                  => fake()->name(),
            'email'                 => fake()->email(),
            'password'              => 'Pa$$word',
            'password_confirmation' => 'Pa$$word',
        ])->assertJson([
            'status'  => true,
            'message' => "Your account created successfully.",
        ])->assertJsonStructure([
            'data' => [
                '*' => array_keys((new User())->toArray())
            ]
        ])->assertStatus(201);
    }

    public function test_user_registration_return_a_validation_error(): void
    {
        $this->json('POST', route('register'), [])->assertJson([
            'status'  => false,
            'message' => "The given data was invalid.",
            "data"    => [
                "name"     => [
                    "The name field is required."
                ],
                "email"    => [
                    "The email field is required."
                ],
                "password" => [
                    "The password field is required."
                ]
            ]
        ])->assertStatus(422);
    }
}
