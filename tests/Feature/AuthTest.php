<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function testLoginEmail()
    {
        $response = $this->json('POST', route('api.auth.login'),
            [

                'email' => self::TEST_EMAIL,
                'password' => env('PASSWORD_USERS_SEEDER')

            ]);

        $this->assertEquals(201, $response->status());

        $user = User::where('email', self::TEST_EMAIL)->get()->first();

        $this->assertEquals($response->getContent(),
            json_encode(
                [
                    'success' => true,
                    'data' => $user
                ]
            )
        );

    }

    public function testTokenGeneration()
    {
        $response = $this->json('POST', route('api.auth.login'),
            [

                'email' => self::TEST_EMAIL,
                'password' => env('PASSWORD_USERS_SEEDER')

            ]);

        $userData = \GuzzleHttp\json_decode($response->getContent());

        $this->assertNotEquals($userData->data->auth_token, null);


    }


    public function testLogOut()
    {

        $response = $this->json('POST', route('api.auth.login'),
            [

                'email' => self::TEST_EMAIL,
                'password' => env('PASSWORD_USERS_SEEDER')

            ]);

        $this->assertEquals(201, $response->status());

        $user = User::where('email', self::TEST_EMAIL)->get()->first();

        $response = $this->json('POST', route('api.auth.logout'),
            [

                'id' => $user->id

            ]
        );

        $this->assertEquals(200, $response->status());

        $this->assertEquals($response->getContent(),
            json_encode(
                [
                    'success' => true,
                    'data' => 'logout'
                ]
            )
        );

    }


}
