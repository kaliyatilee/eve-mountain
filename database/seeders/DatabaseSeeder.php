<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        DB::table('users')->insert([
            'name'       => 'Eve Mountain Admin',
            'email'      => 'admin@evemountain.co.zw',
            'password'   => Hash::make('ChangeMe2024!'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Facilities (from PDF price list)
        $facilities = [
            [
                'name'        => 'Dormitory',
                'slug'        => 'dormitory',
                'description' => 'Bunk bed dormitories fitted with hot water geysers. Maximum 40 pax per dormitory. Multiple dormitories available for larger groups up to 75 people.',
                'rate'        => 12.00,
                'rate_unit'   => 'per_person_per_night',
                'capacity'    => 75,
                'icon'        => 'bed',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Auditorium / Gazebo',
                'slug'        => 'auditorium',
                'description' => 'Seats 100 people. Equipped with projector, speakers and printer. Perfect for conferences, worship sessions and presentations.',
                'rate'        => 100.00,
                'rate_unit'   => 'per_day',
                'capacity'    => 100,
                'icon'        => 'building',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Kitchen',
                'slug'        => 'kitchen',
                'description' => 'Gas-powered kitchen with three-plate gas stove, two 50kg gas tanks and a fridge. Note: utensils not provided.',
                'rate'        => 60.00,
                'rate_unit'   => 'per_day',
                'capacity'    => null,
                'icon'        => 'chef-hat',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Chairs',
                'slug'        => 'chairs',
                'description' => 'Chairs available for use in the auditorium and outdoor areas.',
                'rate'        => 0.50,
                'rate_unit'   => 'per_day_per_unit',
                'capacity'    => null,
                'icon'        => 'armchair',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Outdoor Camp',
                'slug'        => 'outdoor-camp',
                'description' => 'Tent camping area for up to 200 people. Includes hot water showers, bathrooms, toilets and a gas-powered cooking area.',
                'rate'        => 8.00,
                'rate_unit'   => 'per_person_per_day',
                'capacity'    => 200,
                'icon'        => 'tent',
                'sort_order'  => 5,
            ],
        ];

        foreach ($facilities as $f) {
            DB::table('facilities')->insert(array_merge($f, [
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Activities (from PDF)
        $activities = [
            [
                'name'            => 'Quad Biking',
                'description'     => 'Thrilling quad bike rides through the mountain terrain. Suitable for all experience levels with safety briefing provided.',
                'cost_per_person' => 5.00,
                'icon'            => 'bike',
                'sort_order'      => 1,
            ],
            [
                'name'            => 'Teambuilding Activities',
                'description'     => 'Structured teambuilding exercises designed for corporate groups, churches and NGOs. Activities tailored to your group\'s goals.',
                'cost_per_person' => 5.00,
                'icon'            => 'users',
                'sort_order'      => 2,
            ],
            [
                'name'            => 'Swimming Pool',
                'description'     => 'Relax and cool off in our outdoor swimming pool set against the mountain backdrop.',
                'cost_per_person' => 5.00,
                'icon'            => 'waves',
                'sort_order'      => 3,
            ],
        ];

        foreach ($activities as $a) {
            DB::table('activities')->insert(array_merge($a, [
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
