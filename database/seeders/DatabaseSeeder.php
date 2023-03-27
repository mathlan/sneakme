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
        \App\Models\Category::factory()->create([
            'id' => '1',
            'name' => 'Nike',
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Product::factory(30)->create();

        \App\Models\Product::factory()->create([
            'name' => 'Nike 1',
            'description' => 'De très belles chaussures Nike',
            'price' => '5',
            'category_id' => '1',
        ]);

        \App\Models\Product::factory()->create([
            'name' => 'Nike 2',
            'description' => 'Des chaussures Nike moins belles',
            'price' => '7',
            'category_id' => '1',
        ]);

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
            'type' => "default"
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'catalogue',
            'answer_id' => "2",
            'type' => "catalogue",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'chaussures',
            'answer_id' => "3",
            'type' => "catalogue",
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
