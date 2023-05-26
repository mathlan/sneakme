<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Service\ColorSelected;
use App\Service\SizeSelected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $category = null;
        $answer = [];
        $answer['name'] = "";
        $answer['products'] = [];
        $answer['colors'] = Color::pluck('color')->all();
        $answer['sizes'] = Size::pluck('size')->all();
        $crudValues = ["ajouter", "modifier", "supprimer", "connecter", "connexion"];
        $lastAnswer = [];

/*        if (Auth::check()) {
            if($search == "test") {
                $answer['name'] = "Connecté";
            }
        }*/

        // FILTRAGE DES MOTS CLES
        foreach ($words as $word) {
            $wordsToRemove = [];
            // MOTS COURTS // On filtre d'abord les mots inférieurs à trois caractères et qui ne sont pas des INT pour épurer la recherche // Il faudrait éventuellement une liste d'exceptions
            if (strlen($word) < 3 && !is_numeric($word)) {
                array_push($wordsToRemove, $word);
            }
            // Si le mot fait 3 lettres ou +
            else if (strlen($word) >= 3) {
                // PRODUIT // Permet de définir si le client recherche un produit ($category) et de supprimer le superflu (type: "catalogue", "default")
                // Extraction de la marque
                $category = Category::where('name', 'like', '%' . $word . '%')->first();
                // Quand la boucle trouve en enfin une marque, elle affiche ses produits
                if ($category) {
                    $answer['products'] = $category->products;
                    // On supprime ce mot de la liste de mots clés
                    array_push($wordsToRemove, $word);
                    // Dans le cas où l'utilisateur n'aurait mis que le nom de la marque, on retourne une réponse.
                    $answer['name'] = "Voici les produits de la marque "  . $category->name;
                }

                // CRUD KEYWORD // Si l'utilisateur entre un mot clé lié au CRUD (array: $crudValues) on garde le dernier en mémoire
                if(count(array_intersect($words, $crudValues)) > 0) {
                    $crud[] = last(array_intersect($words, $crudValues));
                    if(count($crud) > 0) {
                        $answer['crud'] = $crud[0];
                        // Et on supprime le mot clé
                        array_push($wordsToRemove, $crud[0]);
                    }
                }
            }
            $words = array_filter($words, function($newWord) use ($wordsToRemove) {
                return !in_array($newWord, $wordsToRemove);
            });
        }


        // Permet de fetch les infos du dernier mot clé trouvé dans la table answer
        foreach ($words as $word) {
            // Pour chaque mot, on récupère le premier mot clé en BDD qui ressemble le plus à celui de l'input
            // /!\ On ne traite pas les mots inférieurs à 3 caractères
            if (strlen($word) >= 3) {
                // Extraction d'un mot clé
                $keyword = Keyword::where('name', 'like', '%' . $word . '%')->first();
                // Une première réponse est définie
                if ($keyword) {
                $answer['name'] = $keyword->answer['name'];
                }
            }

            // KEYWORD & KEYWORD TYPE // S'il y a un mot clé, on déclare:
            if ($keyword) {
                // - La réponse: Qui est un array dans lequel on merge les données de la réponse en BDD avec celle déjà existante (s'il y en avait une)
                $answer = array_merge(last([$keyword->answer])->toArray(), $answer);
                // - Le type de réponse que l'on push dans la réponse (on stocke la variable type à l'extérieur de la boucle pour la réutiliser)
                $keywordType = $keyword->type;
                $answer['type'] = $keywordType;
            }

            // TYPE CATALOGUE // Si le mot clé est de type "catalogue"
            if ($keywordType == "catalogue") {
                // Ajoute les objets "Catégories" de tout le catalogue s'il n'y a pas d'objet Products
                if ($answer['products'] == []) {
                $answer['catalogue'] = Category::all();
                }
                if ($keyword) {
                // On redéfinit la réponse pour qu'elle corresponde à une demande de catalogue
                $answer['name'] = $keyword->answer['name'];
                }
            }

            // TYPE PANIER & COMPTE // Si le mot clé est de type 'panier" ou "compte", on recherche ce que l'utilisateur veut faire avec ce dernier
            if ($keywordType == "panier" || $keywordType == "compte") {
                // On clear la variable extérieure pour éviter de répéter l'opération
                $keywordType = "";
                // On redéfinit la réponse pour qu'elle corresponde à une demande de panier/compte
                $answer['name'] = $keyword->answer['name'];
            }

            // COULEUR // Si le client a demandé une couleur on la capte et on la stock dans le json
            // Tryfrom compare l'input avec tout son contenu
            if (ColorSelected::tryFrom($word)) {
                $answer['color'] = ColorSelected::tryFrom($word)->value;
            }
            // POINTURE // Si le client a demandé une pointure on la capte et on la stock dans le json
            if (SizeSelected::tryFrom((int)$word)) {
                $answer['size'] = SizeSelected::tryFrom($word)->value;
            }
        }
        // S'il n'y a pas de réponse, on invite l'utilisateur à reformuler sa demande
        if (!$answer['name']) {
            $answer['name'] = "Merci de reformuler votre demande.";
        }

        $lastAnswer = $answer;
        return response()->json($answer);

/*        if (Auth::check()) {
            // Connecté
        } else {
            // Pas connecté return response()->json(["message" => "Il faut être connecté"]);
        }*/

        // up

    }

}
