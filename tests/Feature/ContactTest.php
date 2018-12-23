<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientContacts;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
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
            ->json('GET', 'api/contacts')
            ->assertStatus(200)
            ->assertJsonStructure([
                'total',
                'per_page',
                'data',
                'current_page'
            ]);

        $response = json_decode($response->getContent());

        $this->assertEquals($response->total, ClientContacts::all()->count());
    }

    public function testStore()
    {
        $registerData = $this->login();

        $countBefore = ClientContacts::all()->count();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('POST', 'api/contacts', [
                'address' => $this->faker->address,
                'post_code' => $this->faker->postcode,
                'client_id' => Client::inRandomOrder()->first()->id,
            ])
            ->assertStatus(200);


        $this->assertEquals($countBefore + 1, ClientContacts::all()->count());
    }

    public function testShow()
    {
        $registerData = $this->login();

        $contact = ClientContacts::inRandomOrder()->first();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('GET', 'api/contacts/' . $contact->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'address',
                'post_code',
                'client_id',
                'client'
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
            ->json('PUT', 'api/contacts/' . $client->contacts->first()->id,
                [
                    'address' => $this->faker->address,
                    'post_code' => $this->faker->postcode,
                    'client_id' => $client->id,
                ]
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'address',
                'post_code',
                'client_id',
                'client'
            ]);

    }

    public function testUpdateWrong()
    {
        $registerData = $this->login();

        $client = Client::inRandomOrder()->first();

        $contact = ClientContacts::where('client_id' , '!=', $client->id)->first();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('PUT', 'api/contacts/' . $contact->id,
                [
                    'address' => $this->faker->address,
                    'post_code' => $this->faker->postcode,
                    'client_id' => $client->id,
                ]
            )
            ->assertStatus(422);

    }


    public function testDelete()
    {
        $registerData = $this->login();

        $contact = ClientContacts::inRandomOrder()->first();

        $countBefore = ClientContacts::all()->count();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('DELETE', 'api/contacts/' . $contact->id)
            ->assertStatus(200);

        $this->assertEquals($countBefore - 1, ClientContacts::all()->count());
    }

}
