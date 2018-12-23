<?php

namespace Tests\Feature;

use App\Models\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{

    public function testIndex()
    {
        $registerData = $this->login();


        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('GET', 'api/clients')
            ->assertStatus(200)
            ->assertJsonStructure([
                'total',
                'per_page',
                'data',
                'current_page'
            ]);

        $response = json_decode($response->getContent());

        $this->assertEquals($response->total, Client::all()->count());
    }

    public function testStore()
    {
        $registerData = $this->login();

        $countBefore = Client::all()->count();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('POST', 'api/clients', [
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'email' => $this->faker->email,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'email',
                'contacts'
            ]);


        $this->assertEquals($countBefore + 1, Client::all()->count());
    }

    public function testShow()
    {
        $registerData = $this->login();

        $client = Client::inRandomOrder()->first();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('GET', 'api/clients/' . $client->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'email',
                'contacts'
            ]);

    }

    public function testUpdate()
    {
        $registerData = $this->login();

        $client = Client::inRandomOrder()->first();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('PUT', 'api/clients/' . $client->id,
                [
                    'first_name' => $this->faker->firstName,
                    'last_name' => $this->faker->lastName,
                    'email' => $this->faker->email,
                ]
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'email',
                'contacts'
            ]);

    }


    public function testDelete()
    {
        $registerData = $this->login();

        $client = Client::inRandomOrder()->first();


        $countBefore = Client::all()->count();


        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('DELETE', 'api/clients/' . $client->id)
            ->assertStatus(200);

        $this->assertEquals($countBefore - 1, Client::all()->count());
    }


}
