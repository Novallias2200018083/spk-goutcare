<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KriteriaSeeder::class,
            SkalaKriteriaSeeder::class,
            ProfileMatchingSeeder::class,
            MakananSeeder::class,
            UserSeeder::class, 
        ]);
    }
}