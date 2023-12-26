<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;




class UsernameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        $usernames = [];

        foreach (range(1, 30000) as $index) {
            $usernames[] = 
                $faker->userName;
        }

        // Convert the array to JSON
        $jsonContent = json_encode($usernames, JSON_PRETTY_PRINT);

        // Write the JSON content to a file
        File::put(base_path('new_usernames.json'), $jsonContent);
    }
}
