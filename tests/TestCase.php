<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, WithFaker;

    const TEST_EMAIL = 'test@gmail.com';
    const TEST_EMAIL_REGISTRATION = 'new_test@gmail.com';

    protected function login()
    {

        $data = [
            'email' => self::TEST_EMAIL,
            'password' => env('PASSWORD_USERS_SEEDER')
        ];

        $response = $this->json('POST', route('api.auth.login'), $data);

        $this->assertEquals(201, $response->status());

        $userData = \GuzzleHttp\json_decode($response->getContent());

        return $userData->data;
    }



}
