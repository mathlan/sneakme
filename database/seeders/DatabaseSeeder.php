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

        // Questions de politesses

        \App\Models\Answer::factory()->create([
             'name' => 'Bonjour à vous',
             'type' => 'answer',
         ]);

        \App\Models\Answer::factory()->create([
            'name' => 'Voici notre catalogue',
            'type' => 'multipleChoiceQuestion',
        ]);

        \App\Models\Answer::factory()->create([
            'name' => 'Voici notre gamme de chaussures',
            'type' => 'multipleChoiceQuestion',
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

        // Questions de précision

        \App\Models\Answer::factory()->create([
            'id' => '4',
            'name' => 'Voici les marques que nous possédons',
            'type' => 'multipleChoiceQuestion',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'marques',
            'answer_id' => "4",
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '6',
            'name' => 'Voici les catégories disponible',
            'type' => 'multipleChoiceQuestion',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'catégories',
            'answer_id' => "6",
        ]);

        // Questions Panier

        \App\Models\Answer::factory()->create([
            'id' => '9',
            'name' => 'Voulez vous ajouter cet article ?',
            'type' => 'PolarQuestion',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'ajouter',
            'answer_id' => "9",
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '10',
            'name' => 'Voici votre panier',
            'type' => 'answer',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'panier',
            'answer_id' => "10",
        ]);

        // Questions de login

        \App\Models\Answer::factory()->create([
            'id' => '7',
            'name' => 'Vous Pouvez vous inscrire ici.',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'inscrire',
            'answer_id' => "7",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'inscription',
            'answer_id' => "7",
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '8',
            'name' => 'Connectez vous maintenant',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'connecter',
            'answer_id' => "8",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'connexion',
            'answer_id' => "8",
        ]);



        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
