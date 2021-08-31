<?php

namespace Database\Seeders;

use App\Models\Element;
use App\Models\Property;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $locations_array = [
            [
                'name' => 'Парки и набережные',
                'events' => [],
                'locations' => [
                    [
                        'name' => 'Парк Горького'
                    ],
                    [
                        'name' => 'Горкинско-Ометьевский лес'
                    ]
                ]
            ],
            [
                'name' => 'Музеи и галереи',
                'events' => [],
                'locations' => [

                ]
            ],
            [
                'name' => 'Заведения',
                'events' => [],
                'locations' => [

                ]
            ],
            [
                'name' => 'Творческие пространства и коворкинги',
                'events' => [],
                'locations' => [

                ]
            ],
            [
                'name' => 'Онлайн',
                'events' => [],
                'locations' => [

                ]
            ],
            [
                'name' => 'Экскурсии',
                'events' => [],
                'locations' => [

                ]
            ],
            [
                'name' => 'Красота',
                'events' => [],
                'locations' => [

                ]
            ],
            [
                'name' => 'Другое',
                'events' => [],
                'locations' => [

                ]
            ],
            [
                'name' => 'Животные',
                'events' => [],
                'locations' => [

                ]
            ]
        ];

        $sq_location = Section::create([
           'name' => 'Места',
           'code' => 'locations'
        ]);

        foreach ($locations_array as $location) {

            $new_loc = Section::create([
                'name' => $location['name'],
                'code' => str_slug($location['name']),
                'parent_section' => $sq_location->id
            ]);

            if (!empty($location['locations'])) {
                foreach ($location['locations'] as $sublocation) {
                    $new_sub_loc = Section::create([
                        'name' => $sublocation['name'],
                        'code' => str_slug($sublocation['name']),
                        'parent_section' => $new_loc->id
                    ]);
                }
            }
        }

    }
}
