<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\Product;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = $request->input('keyword');
        $words = explode(" ", $search);
        $keywords = [];
        $results = [];
        $answer = [];
        $types = [];
        $crudValues = ["ajouter", "modifier", "supprimer"];

        // Permet de fetch les infos du dernier mot clé trouvé dans la table answer
        foreach ($words as $word) {
            $keyword = Keyword::where('name', 'like', '%' . $word . '%')
                ->first();

            // Création de la réponse
            if ($keyword) {
                $answer = array_merge(last([$keyword->answer])->toArray(), $answer);

                $type = $keyword->type;
                $answer['type'] = $type;
            }
        }

        // S'il y a au moins une réponse retournée par la recherche (un mot clé trouvé) on continue de la traiter
        if ($answer != []) {

            // Si le mot clé est de type "catalogue", on recherche les mots clés dans category
            if (in_array("catalogue", $words)) {
                $answer['products'] = [];
                foreach ($words as $word) {
                    $category = Category::where('name', 'like', $word)->first();
                    if ($category) {
                        // Si une catégorie est trouvée, on renvoie les produits de la catégories.
                        $products[] = Product::where('category_id', 'like', $category->id)->get();
                        // Ajoute les objets "Produits" qui correspondent à la recherche
                        $answer['products'] = array_merge($products, $answer['products']);
                    } else {
                        // Si aucune catégorie n'est trouvée, on renvoie la totalité du catalogue.
                        $catalogue = Category::all();
                        // Ajoute les objets "Catégories" de tout le catalogue
                        $answer['catalogue'] = $catalogue;
                    }
                }
            }

            // Si le mot clé est de type "panier", on recherche ce que l'utilisateur veut faire avec le panier
            if (in_array("panier", $words)) {
                $basket = [];
                // Si l'utilisateur entre un mot clé lié au CRUD (array: $crudValues) on garde le dernier en mémoire
                if(count(array_intersect($words, $crudValues)) > 0) {
                    $basket[] = last(array_intersect($words, $crudValues));
                }
                if(count($basket) > 0) {
                    $answer['panier'] = $basket[0];
                }
            }

        }
        return response()->json($answer);


        // if (type egal catalogue)
        //     rechercher en bdd  une categorie
        //     if une categorie
        //         return la liste des produits de la categorie;

        // Afficher la réponse à un seul mot clé

        // $keyword = Keyword::where('name', 'like', '%' . $search . '%')->first();
        // return response()->json(['answer' => $keyword->answer->name]);

        // Découpe la phrase et sélectionne la réponse liée au dernier mot clé

        // $search = $request->input('keyword');
        // $words = explode(" ", $search);
        // $results = [];
        // foreach ($words as $word) {
        //     $keyword = Keyword::where('name', 'like', '%' . $word . '%')->first();
        //     if($keyword) {
        //         $results[] = $keyword->answer->name;
        //     }
        // }
        // return response()->json(['answer' => last($results)]);

        // Affichae une réponse ou le catalogue demandé

        // $search = $request->input('keyword');
        // $words = explode(" ", $search);
        // $results = [];
        // foreach ($words as $word) {
        //     $keyword = Keyword::where('name', 'like', '%' . $word . '%')->first();
        //     // Si on rencontre un mot clé -> Evite les erreurs s'il n'y a pas de résultat
        //     if ($keyword) {
        //         $results[] = $keyword->answer;
        //         // Si le mot clé est de type "catalogue", on recherche les mots clés dans category
        //         if ($keyword->type == "catalogue") {
        //             foreach ($words as $word) {
        //                 $category = Category::where('name', 'like', $word)->first();
        //                 if ($category) {
        //                     $products = Product::where('category_id', 'like', $category->id)->get();
        //                     $answerProduct = last($results)->toArray();
        //                     $answerProduct['products'] = $products;
        //                     return response()->json($answerProduct);
        //                     // return response()->json($category);
        //                 }
        //             }
        //         }
        //     }
        // }
        // return response()->json(last($results));


/*        $search = $request->input('keyword');
        $words = explode(" ", $search);
        $results = [];
        $answer = [];
        /*        $crudValues = [0 => "ajouter", 1 => "modifier", 2 =>"supprimer"];*/

/*        foreach ($words as $word) {
            $keyword = Keyword::where('name', 'like', '%' . $word . '%')->first();
            // Si on rencontre un mot clé -> Evite les erreurs s'il n'y a pas de résultat
            if ($keyword) {
                $results[] = $keyword->answer;
                $answer = array_merge(last($results)->toArray(), $answer);
            }

            if ($word == "modifier") {
                $answer['request'] = $word;
            }
        }*/


/*        foreach ($words as $word) {
            $keyword = Keyword::where('name', 'like', '%' . $word . '%')->first();
            // Si on rencontre un mot clé -> Evite les erreurs s'il n'y a pas de résultat
            if ($keyword) {
                // Si le mot clé est de type "catalogue", on recherche les mots clés dans category
                if ($keyword->type == "catalogue") {
                    foreach ($words as $word) {
                        $category = Category::where('name', 'like', $word)->first();
                        if ($category) {
                            $products = Product::where('category_id', 'like', $category->id)->get();
                            // Ajoute les objets "Produits" qui correspondent à la recherche
                            $answer['products'] = $products;
                            return response()->json($answer);
                        }
                    }
                    // Si aucune catégorie n'est trouvée, on renvoie la totalité du catalogue.
                    $catalogue = Category::all();
                    // Ajoute les objets "Catégories" de tout le catalogue
                    $answer['catalogue'] = $catalogue;
                    return response()->json($answer);
                }

                // if ($keyword->type == "panier") {
                //     $keyword = Keyword::where('name', 'like', '%' . $word . '%')->first();
                // }
            }
        }*/
        /*return response()->json($answer);*/


        // TEST TEST TEST TEST TEST
        // else {
        //     $catalogue = Category::all();
        //     $answerData['catalogue'] = $catalogue;
        // }
        //     return response()->json($answerData);

    }

}
