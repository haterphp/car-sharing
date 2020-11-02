<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'opened'
            ],
            [
                'name' => 'closed'
            ],
        ];
        collect($statuses)->each(fn($item) => Status::create($item));

        $branches = [
            [
                'name' => 'branch 1',
                'cars' => [
                    [
                        "mark" => "Toyota",
                        "title" => "Prado",
                        "car_number" => "А228АА",
                        "price" => 3000
                    ],
                    [
                        "mark" => "Kia Rio",
                        "title" => "X-Line",
                        "car_number" => "L123OX",
                        "price" => 5000
                    ]
                ]
            ],
            [
                'name' => 'branch 2',
                'cars' => [
                    [
                        "mark" => "Volkswagen",
                        "title" => "Polo",
                        "car_number" => "L113OX",
                        "price" => 5000
                    ],
                ]
            ],
            [
                'name' => 'branch 3',
                'cars' => [
                    [
                        "mark" => "Mercedes-Benz",
                        "title" => "CLA",
                        "car_number" => "J902QW",
                        "price" => 5000
                    ],
                    [
                        "mark" => "Mercedes-Benz",
                        "title" => "GLC",
                        "car_number" => "N901KJ",
                        "price" => 5000
                    ],
                    [
                        "mark" => "Mercedes-Benz",
                        "title" => "A-Class",
                        "car_number" => "Q241WE",
                        "price" => 5000
                    ],
                ]
            ]
        ];

        collect($branches)->each(function ($item) {
            $item = (object) $item;
            $branch = Branch::create(['name' => $item->name]);
            $branch->cars()->createMany($item->cars);
        });
    }
}
