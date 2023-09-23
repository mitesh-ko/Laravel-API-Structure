<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductModuleTest extends TestCase
{
    public function userToken() {
        $userData = [
            'name'     => fake()->name(),
            'email'    => fake()->email(),
            'password' => Hash::make('password')
        ];
        $user = User::create($userData);
        return $user->createToken($user->email)->accessToken;
}
    public function test_user_not_have_token_return_a_unauthorized_response(): void
    {
        $this->get(route('products.index'))->assertJson([
            'status'  => false,
            'message' => "unauthorized",
        ])->assertStatus(401);
    }

    public function test_authorized_user_get_success_response_and_product_list(): void
    {
        $this->json('GET', route('products.index'), [], [
            'Authorization' => 'Bearer ' . $this->userToken()
        ])->assertJson([
            'status'  => true,
            'message' => "Products list.",
        ])->assertJsonStructure([
            'data' => []
        ])->assertStatus(200);
    }

    public function test_authorized_user_can_create_product(): void
    {
        $this->json('POST', route('products.store'), [
            'name'  => fake()->name(),
            'desc'  => fake()->text(),
            'price' => 525.54,
        ], [
            'Authorization' => 'Bearer ' . $this->userToken()
        ])->assertJson([
            'status'  => true,
            'message' => "New product created successfully.",
        ])->assertJsonStructure([
            'data' => []
        ])->assertStatus(201);
    }

    public function test_authorized_user_can_update_product(): void
    {
        $product = Product::create([
            'name'  => fake()->name(),
            'desc'  => fake()->text(),
            'price' => 525.54,
        ]);

        $this->json('PATCH', route('products.update', $product->id), [
            'name'  => fake()->name(),
            'desc'  => fake()->text(),
            'price' => 525.54,
        ], [
            'Authorization' => 'Bearer ' . $this->userToken()
        ])->assertJson([
            'status'  => true,
            'message' => "Product updated successfully.",
        ])->assertJsonStructure([
            'data' => []
        ])->assertStatus(200);
    }

    public function test_authorized_user_can_delete_product(): void
    {
        $product = Product::create([
            'name'  => fake()->name(),
            'desc'  => fake()->text(),
            'price' => 525.54,
        ]);

        $this->json('DELETE', route('products.destroy', $product->id), [], [
            'Authorization' => 'Bearer ' . $this->userToken()
        ])->assertJson([
            'status'  => true,
            'message' => "Product deleted successfully.",
        ])->assertJsonStructure([
            'data' => []
        ])->assertStatus(202);
    }
}
