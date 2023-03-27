<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Product::factory(30)->create();

        \App\Models\Answer::factory()->create([
             'name' => 'Bonjour à vous',
         ]);

        \App\Models\Answer::factory()->create([
            'name' => 'Voici notre catalogue',
        ]);

        \App\Models\Answer::factory()->create([
            'name' => 'Voici notre gamme de chaussures',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'bonjour',
            'answer_id' => "1",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'catalogue',
            'answer_id' => "2",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'chaussures',
            'answer_id' => "3",
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
