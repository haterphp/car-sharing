<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;


class CarSearchTest extends TestCase
{
    public function testEmptyBody()
    {
        $response = $this->json('GET', '/api/cars', []);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items'
                ]
            ])
            ->assertJsonPath('data.items', []);
    }

    public function testGetCarsByMark()
    {
        $response = $this->json('GET', '/api/cars', ['mark' => 'Mer']);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'mark',
                            'title',
                            'car_number',
                            'branch_id',
                            'price',
                            'branch' => [
                                'id',
                                'name'
                            ]
                        ]
                    ]
                ]
            ])
            ->assertJsonFragment([ 'mark' => 'Mercedes-Benz' ]);
    }

    public function testGerCarsByMarkAndModel()
    {
        $response = $this->json('GET', '/api/cars', ['mark' => 'Mer', 'model' => 'GLC']);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'mark',
                            'title',
                            'car_number',
                            'branch_id',
                            'price',
                            'branch' => [
                                'id',
                                'name'
                            ]
                        ]
                    ]
                ]
            ])
            ->assertJsonFragment([ 'mark' => 'Mercedes-Benz', 'title' => 'GLC' ]);
    }

    public function testIncorrectMark()
    {
        $response = $this->json('GET', '/api/cars', ['mark' => Str::random(15)]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items'
                ]
            ])
            ->assertJsonPath('data.items', []);
    }
}
