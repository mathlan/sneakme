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

        \App\Models\User::factory()->create([
            'id' => '1',
            'lastname' => 'Super',
            'firstname' => 'Admin',
            'email' => 'superadmin@example.com',
            'role' => 'admin',
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Color::factory(10)->create();
        // \App\Models\Product::factory(30)->create();

        // Tailles disponibles
        for ($size = 34; $size <= 49; $size++) {
            \App\Models\Size::factory()->create([
                'id' => $size - 33,
                'size' => $size,
            ]);
        }

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
            'name' => 'Voici ce que nous proposons',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '5',
            'name' => 'Souhaitez-vous ajouter cet article a votre panier ?',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '6',
            'name' => 'Voici votre panier',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '7',
            'name' => 'Inscrivez-vous ici',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '8',
            'name' => 'Vous pouvez vous connecter ici',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '9',
            'name' => 'Souhaitez-vous supprimer cet article de votre panier ?',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '10',
            'name' => 'Souhaitez vous finaliser votre commande ?',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '11',
            'name' => 'Votre commande a été validé',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '12',
            'name' => 'Votre article a été ajouté',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '13',
            'name' => 'Voila les categories disponible',
        ]);

        \App\Models\Answer::factory()->create([
            'id' => '14',
            'name' => 'Si vous souhaitez valider votre panier, dites "valider", pour afficher le catalogue dites "catalogue"',
        ]);
        \App\Models\Answer::factory()->create([
            'id' => '15',
            'name' => 'Validation du panier',
        ]);

        // Mot-clés

        \App\Models\Keyword::factory()->create([
            'name' => 'bonjour',
            'answer_id' => "1",
            'type' => 'default',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'catalogue',
            'answer_id' => "2",
            'type' => 'catalogue',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'chaussures',
            'answer_id' => "3",
            'type' => 'catalogue',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'marques',
            'answer_id' => "4",
            'type' => 'catalogue',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'ajouter',
            'answer_id' => "5",
            'type' => 'panier',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'panier',
            'answer_id' => "6",
            'type' => 'panier',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'inscrire',
            'answer_id' => "7",
            'type' => 'inscrire',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'inscription',
            'answer_id' => "7",
            'type' => 'inscrire',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'connecter',
            'answer_id' => "8",
            'type' => 'compte',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'connexion',
            'answer_id' => "8",
            'type' => 'compte',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'compte',
            'answer_id' => "8",
            'type' => 'compte',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'supprimer',
            'answer_id' => "9",
            'type' => 'panier',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'commander',
            'answer_id' => "10",
            'type' => 'panier',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'categories',
            'answer_id' => "13",
            'type' => 'catalogue',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'acheter',
            'answer_id' => "14",
            'type' => 'panier',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'valider',
            'answer_id' => "15",
            'type' => 'panier',
        ]);

        \App\Models\Keyword::factory()->create([
            'name' => 'payer',
            'answer_id' => "10",
            'type' => 'panier',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '1',
            'name' => 'Dunk High Panda',
            'image' => 'Dunk High Panda (2021).jpg',
            'description' => fake()->text(200),
            'price' => '160',
            'category_id' => '1',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '2',
            'name' => 'Nike Air Trainer 1',
            'image' => 'Nike Air Trainer 1.jpg',
            'description' => fake()->text(200),
            'price' => '130',
            'category_id' => '1',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '3',
            'name' => 'Air Jordan 1 Mid',
            'image' => 'Air Jordan 1 Mid.jpg',
            'description' => fake()->text(200),
            'price' => '130',
            'category_id' => '1',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '4',
            'name' => 'Nike Dunk Low',
            'image' => 'Nike Dunk Low.jpg',
            'description' => fake()->text(200),
            'price' => '110',
            'category_id' => '1',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '5',
            'name' => 'Nike Air Max Plus',
            'image' => 'Nike Air Max Plus.jpg',
            'description' => fake()->text(200),
            'price' => '200',
            'category_id' => '1',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '6',
            'name' => 'Nike Air Max 90',
            'image' => 'Nike Air Max 90.jpg',
            'description' => fake()->text(200),
            'price' => '150',
            'category_id' => '1',
        ]);




        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
