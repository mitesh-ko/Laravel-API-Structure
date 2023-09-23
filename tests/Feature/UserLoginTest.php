<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    public function test_user_login_with_right_credentials_return_a_successful_response(): void
    {
        $userData = [
            'name'     => 'Jhon',
            'email'    => 'jhon@example.com',
            'password' => Hash::make('password')
        ];
        User::create($userData);
        $this->json('POST', route('login'), [
            'email'    => 'jhon@example.com',
            'password' => 'password'
        ])->assertJson([
            'status'  => true,
            'message' => "User logged in successfully.",
        ])->assertJsonStructure([
            'data' => [
                '*' => array_keys((new User())->toArray())
            ]
        ])->assertStatus(200);
    }

    public function test_user_login_with_wrong_credentials_return_a_user_not_found_response(): void
    {
        $this->json('POST', route('login'), [
            'email'    => fake()->email(),
            'password' => 'password'
        ])->assertJson([
            'status'  => false,
            'message' => "User not found for given credentials.",
        ])->assertJsonStructure([
            'data' => []
        ])->assertStatus(404);
    }

    public function test_user_login_return_a_validation_error(): void
    {
        $this->json('POST', route('login'), [])->assertJson([
            'status'  => false,
            'message' => "The given data was invalid.",
            "data"    => [
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
