<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderItemController;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\Order;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\OrderItem;
use App\Models\User;
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
        // Récupère les arguments dans le body de la request JS
        $search = $request->input('keyword');
        // Séparation des mots clés dans un array
        $words = explode(" ", $search);
        // Stockage pour récupérer des mots clés importants
        $keywordType = "";
        $category = null;
        // Array qui va être incrémenté au fur et à mesure pour la réponse de l'API
        $answer = [];
        $answer['name'] = "";
        $answer['products'] = [];
        // Arrays pour les SELECT du front
        $answer['colors'] = Color::pluck('color')->all();
        $answer['sizes'] = Size::pluck('size')->all();
        // Mots clés de type "CRUD" & Connexion
        $crudValues = ["ajouter", "modifier", "supprimer", "connecter", "connexion"];
        $lastAnswer = [];


        // FILTRAGE DES MOTS CLES
        foreach ($words as $word) {
            // Mots à supprimer
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
/*                if($answer['crud'] == "modifier") {
                    $this->displayCart();
                }*/
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

    }

    // Ajouter un article au panier
    public function addNewItem(Request $request): \Illuminate\Http\JsonResponse
    {
        $newItem = $request;

        // ID de l'utilisateur
        $userID = Auth::id();

        if(Auth::check()) {

        //? Fonction de récupération de l'ID de la commande en cours
        $orderID = null;
        function getOrderID ($userID) {
            $orderID = Order::where('user_id', $userID)
                ->where('status', 'En cours')
                ->first()->id;
            return $orderID;
        }

        // On vérifie si l'utilisateur à déjà une commande en cours
        $orderExists = Order::where('user_id', $userID)
            ->where('status', 'En cours')
            ->exists();
        // S'il en a déjà une on définit juste son ID pour lui rajouter des items par la suite
        if ($orderExists) {
            $orderID = getOrderID($userID);
        }
        // S'il n'en a pas déjà une on la crée selon le modèle et on récupère son ID
        if (!$orderExists) {
            // Nouvelle entrée selon le modèle
            $order = new Order();
            $order->status = "En cours";
            $order->total = 0;
            $order->date = date('Ymd');
            $order->user_id = $userID; // $order->user_id = Auth::id();
            $order->save();
            $orderID = getOrderID ($userID);
        }
        // Il faut impérativement respecter le modèle et donc avoir un numéro de commande pour ajouter un item
        // S'il a une commande en cours, on lui ajoute le/les produit(s)
        if ($newItem->quantity > 0) {
        $orderItem = new OrderItem();
        $orderItem->quantity = $newItem->quantity;
        $orderItem->size = $newItem->size;
        $orderItem->color = $newItem->color;
        $orderItem->order_id = $orderID;
        $orderItem->product_id = $newItem->product_id;
        $orderItem->save();

        $answer['name'] = "Hop! Ajouté au panier!";
        } else {
            $answer['name'] = "Merci d'ajouter au moins 1 article.";
        }
        } else {
            $answer['name'] = "Merci de vous connecter.";
        }

        return (response()->json($answer));
    }

    // Supprimer un article du panier
    public function deleteItem(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->id;

        //! Valeur à remplacer par Auth::id()
        $userID = Auth::id();

        //? Fonction de récupération de l'ID de la commande en cours
        $orderID = null;
        function getOrderID ($userID) {
            $orderID = Order::where('user_id', $userID)
                ->where('status', 'En cours')
                ->first()->id;
            return $orderID;
        }

        // On vérifie si l'utilisateur à déjà une commande en cours
        $orderExists = Order::where('user_id', $userID)
            ->where('status', 'En cours')
            ->exists();

        // S'il en a déjà une on définit juste son ID pour lui supprimer des items par la suite
        if ($orderExists) {
            $orderID = getOrderID($userID);
            OrderItem::where('order_id', $userID)->where('id', $id)->delete();
        }

        $answer['name'] = "Supprimé du panier";
        $answer['deletedID'] = $id;
        // $answer['id'] = Auth::id();
        // $answer['check'] = Auth::check();

        return (response()->json($answer));
    }

    // Afficher le panier
    public function displayCart(): \Illuminate\Http\JsonResponse
    {
        //! Valeur à remplacer par Auth::id()
        $userID = Auth::id();

        //? Fonction de récupération de l'ID de la commande en cours
        $orderID = null;
        function getOrderID ($userID) {
            $orderID = Order::where('user_id', $userID)
                ->where('status', 'En cours')
                ->first()->id;
            return $orderID;
        }

        // On vérifie si l'utilisateur à déjà une commande en cours
        $orderExists = Order::where('user_id', $userID)
            ->where('status', 'En cours')
            ->exists();
        // S'il en a déjà une on définit juste son ID pour lui rajouter des items par la suite
        if ($orderExists) {
            $orderID = getOrderID($userID);
        }

        //? Fonction de récupération des items du panier
        function getOrderItems ($orderID) {
            $cart = OrderItem::where('order_id', $orderID)
                ->get();
            return $cart;
        }

        $items = getOrderItems ($orderID);

        // Map des photos correspondantes aux produits dans l'objet à retourner au front
        $itemsAndPics = $items->map(function ($item) {
            // Trouver le produit
            $product = Product::find($item->product_id);
            // Ajouter sa photo
            $item->picture = $product->image;
            $item->name = $product->name;
            return $item;
        });

        $answer['name'] = "Voici votre panier";
        $answer['idToken'] = Auth::id();
        $answer['cart'] = $itemsAndPics;
        // Il faut passer les données dans le cart
        // $answer['cart']['idToken'] = Auth::id();
        return (response()->json($answer));
    }

    // Afficher le panier
    public function orderCart(Request $request): \Illuminate\Http\JsonResponse
    {
        $choice = $request->choice;
        //! Valeur à remplacer par Auth::id()
        $userID = Auth::id();

        //? Fonction de récupération de l'ID de la commande en cours
        $orderID = null;
        function getOrderID ($userID) {
            $orderID = Order::where('user_id', $userID)
                ->where('status', 'En cours')
                ->first()->id;
            return $orderID;
        }

        // On vérifie si l'utilisateur à déjà une commande en cours
        $orderExists = Order::where('user_id', $userID)
            ->where('status', 'En cours')
            ->exists();
        // S'il en a déjà une on définit juste son ID pour lui rajouter des items par la suite
        if ($orderExists && $choice == "yes") {
            Order::where('user_id', $userID)
                ->where('status', "En cours")
                ->update(['status' => 'En attente']);
            $answer['name'] = "Votre commande est désormais en attente de paiement. Merci d'adresser votre paiement à [adresse]. Merci pour votre achat !";
        } else {
            $answer['name'] = "Vous pouvez continuer vos achats.";
        }

        return (response()->json($answer));
    }

    public function connectUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $userInput = $request;

        // Si le mot de passe correspond à l'user

        if (Auth::attempt(['email' => $userInput->email, 'password' => $userInput->password])) {
            $userData = Auth::user();
            $userData['answer'] = "Vous êtes bien connecté";
            $userData['auth'] = true;
        } else {
            $userData['answer'] = "Echec de connexion";
            $userData['auth'] = false;
        }

        return (response()->json($userData));
    }
}
