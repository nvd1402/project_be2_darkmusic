<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([


            AdSeeder::class,
            NewsSeeder::class,
            UserSeeder::class,
            ArtistSeeder::class,
            SongSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
