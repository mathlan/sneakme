<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Keyword;
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
        $results = [];
        foreach ($words as $word) {
            $keyword = Keyword::where('name', 'like', '%' . $word . '%')->first();
            if($keyword) {
            $results[] = $keyword->answer->name;
            }
        }


        return response()->json(['answer' => last($results)]);


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
        return response()->json(['answer' => last($results)]);

    }

}
