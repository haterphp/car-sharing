<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseUserTest;

class RegisterTest extends BaseUserTest
{

    public function testRegistration()
    {
        $response = $this->createUser();

        $response
            ->assertStatus(204);
    }

    public function testEmptyBody()
    {
        $response = $this->json('POST', '/api/register', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'code',
                    'message',
                    'errors' => [
                        'first_name',
                        'last_name',
                        'phone',
                        'passport_number',
                        'passport_series',
                        'birth_date',
                        'password',
                    ]
                ]
            ])
            ->assertJsonPath('error.code', 422)
            ->assertJsonPath('error.message', 'Validation error');
    }

    public function testPhoneIsUnique()
    {
        $response = $this->createUser();

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'code',
                    'message',
                    'errors' => [
                        'phone',
                    ]
                ]
            ])
            ->assertJsonPath('error.code', 422)
            ->assertJsonPath('error.message', 'Validation error');

    }

}
