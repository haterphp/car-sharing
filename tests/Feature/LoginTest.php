<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\BaseUserTest;

class LoginTest extends BaseUserTest
{
    public function testLogin()
    {
        $response = $this->json('POST', '/api/login', $this->loginBody());

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'token',
                ]
            ]);

        $this->token = $response->decodeResponseJson()['data']['token'];
    }

    public function testEmptyBody()
    {
        $response = $this->json('POST', '/api/login', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'code',
                    'message',
                    'errors' => [
                        'phone',
                        'password'
                    ]
                ]
            ])
            ->assertJsonPath('error.code', 422)
            ->assertJsonPath('error.message', 'Validation error');
    }

    public function testIncorrectData()
    {
        $response = $this->json('POST', '/api/login', [
            'phone' => Str::random(25),
            'password' => Str::random(25),
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'error' => [
                    'code',
                    'message',
                    'errors' => [
                        'phone',
                    ]
                ]
            ])
            ->assertJsonPath('error.errors.phone', [ "phone or password incorrect" ])
            ->assertJsonPath('error.code', 401)
            ->assertJsonPath('error.message', 'Unauthorized');
    }
}
