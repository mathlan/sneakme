<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Keyword;
use App\Service\Color;
use App\Service\Size;
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
        $keywordType = "";
        $answer = [];
        $crudValues = ["ajouter", "modifier", "supprimer", "connecter", "connexion", "compte"];
        $lastAnswer = [];

        // Permet de fetch les infos du dernier mot clé trouvé dans la table answer
        foreach ($words as $word) {
            // Pour chaque mot, on récupère le premier mot clé en BDD qui ressemble le plus à celui de l'input
            // /!\ On ne traite pas les mots inférieurs à 3 caractères
            if (strlen($word) >= 3) {
            $keyword = Keyword::where('name', 'like', '%' . $word . '%')
                ->first();
            }
            // S'il y a un mot clé, on déclare:
            if ($keyword) {
                // - La réponse: Qui est un array dans lequel on merge les données de la réponse en BDD avec celle déjà existante (s'il y en avait une)
                $answer = array_merge(last([$keyword->answer])->toArray(), $answer);
                // - Le type de réponse que l'on push dans la réponse (on stocke la variable type à l'extérieur de la boucle pour la réutiliser)
                $keywordType = $keyword->type;
                $answer['type'] = $keywordType;
            }

            // Si le mot clé est de type "catalogue", on recherche les mots clés dans category
            if ($keywordType == "catalogue") {
                $answer['products'] = [];
                    $category = Category::where('name', 'like', $word)->first();
                    if ($category) {
                        // Si une catégorie est trouvée, on renvoie les produits de la catégories.
                        $products[] = Product::where('category_id', 'like', $category->id)->get();
                        // Ajoute les objets "Produits" qui correspondent à la recherche
                        $answer['products'] = array_merge($products, $answer['products']);
                        $answer['test'] = $category;
                    } else {
                        // Si aucune catégorie n'est trouvée, on renvoie la totalité du catalogue.
                        $catalogue = Category::all();
                        // Ajoute les objets "Catégories" de tout le catalogue
                        $answer['catalogue'] = $catalogue;
                        $answer['keywordType'] = $category;
                    }
                    // On clear la variable extérieure pour éviter de répéter l'opération
                    $keywordType = "";
                    // On redéfini la réponse pour qu'elle corresponde à une demande de catalogue
                    $answer['name'] = $keyword->answer['name'];
            }

            // Si le mot clé est de type 'panier", on recherche ce que l'utilisateur veut faire avec le panier
            if ($keywordType == "panier") {
                $basket = [];
                // Si l'utilisateur entre un mot clé lié au CRUD (array: $crudValues) on garde le dernier en mémoire
                if(count(array_intersect($words, $crudValues)) > 0) {
                    $basket[] = last(array_intersect($words, $crudValues));
                }
                if(count($basket) > 0) {
                    $answer['panier'] = $basket[0];
                }
                // On clear la variable extérieure pour éviter de répéter l'opération
                $keywordType = "";
                // On redéfini la réponse pour qu'elle corresponde à une demande de panier
                $answer['name'] = $keyword->answer['name'];
            }

            // Si le client a demandé une couleur on la capte et on la stock dans le json
            // Tryfrom compare l'input avec tout son contenu
            if (Color::tryFrom($word)) {
                $answer['color'] = Color::tryFrom($word)->value;
            }
            // Si le client a demandé une pointure on la capte et on la stock dans le json
            if (Size::tryFrom((int)$word)) {
                $answer['size'] = Size::tryFrom($word)->value;
            }
        }

        $lastAnswer = $answer;
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
