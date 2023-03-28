<?php


use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = $request->query('q');
        $search2 = $request->getContent();
        $body = json_decode($search2);
        // $search = Keyword::where('name', 'like', '%' . $search . '%') -> get();
        // return response()->json(["nom"=>"jean"]);
        return response()->json($body->name);

        // $search = $request->query('q');
        // $search2 = $request->getContent();
        // $body = json_decode($search2);
        // $search = Keyword::where('name', 'like', '%' . $search . '%') -> get();
        // return response()->json(["nom"=>"jean"]);
        // return response()->json($body->name);
    }

}
