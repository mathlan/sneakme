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

        // Réponses

        \App\Models\Answer::factory()->create([
            'id' => '1',
             'name' => 'Bonjour à vous',
         ]);

        \App\Models\Answer::factory()->create([
            'id' => '2',
            'name' => 'Voici notre catalogue',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '3',
            'name' => 'Voici notre gamme de chaussures',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '4',
            'name' => 'Voici les marques que nous possédons',
        ]);

        \App\Models\Answer::factory()->create([
            'name' => 'Shouaitez-vous ajouter cet article a votre panier ?',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '5',
            'name' => 'Votre article a été ajouté',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '6',
            'name' => 'Voici votre panier',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '7',
            'name' => 'Inscrivez-vous',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '8',
            'name' => 'Vous Pouvez vous connecter ici',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '9',
            'name' => 'Shouaitez-vous supprimer cet article de votre panier ?',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '10',
            'name' => 'Comment shouaitez-vous regler ?',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '11',
            'name' => 'Votre commande a été validé',
        ]);

        // Mot-clés

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

        \App\Models\Keyword::factory()->create([
            'name' => 'marques',
            'answer_id' => "4",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'ajouter',
            'answer_id' => "5",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'panier',
            'answer_id' => "6",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'inscrire',
            'answer_id' => "7",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'inscription',
            'answer_id' => "7",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'connecter',
            'answer_id' => "8",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'connexion',
            'answer_id' => "8",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'supprimer',
            'answer_id' => "9",
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'commander',
            'answer_id' => "10",
        ]);




        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
