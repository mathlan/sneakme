<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keyword;
use App\Models\Answer;

class KeywordController extends Controller
{
    public function index()
    {
        $keywords = Keyword::all();
        return view('keyword.admin',[
                'keywords' => $keywords
            ]
        );
    }

    public function edit(Keyword $keyword)
    {
        $answers = Answer::all();
        return view('keyword.edit',compact('keyword','answers'));
        // $product = Product::edit($request->all());
    }

    public function update(Request $request, Keyword $keyword)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'answer_id' => 'required|exists:answers,id',
        ]);

        $keyword->update($validatedData);

        return redirect()->route('keyword.index');
    }

    public function create()
    {
        return view('keyword.create', [
            'answers' => Answer::all()
        ]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|min:3|max:255',
            'answer_id' => 'required|exists:answers,id',
            'type' => 'required|min:3|max:255',
        ]);


        $keyword = Keyword::create($request->all());

        return redirect()->route('keyword.index');

    }

    public function show(Keyword $keyword)
    {
        return view('keyword.show', [
            'keyword' => $keyword
        ]);
    }

    public function destroy(Keyword $keyword)
    {
        $keyword->delete();
        return redirect()->route('keyword.index');
    }
}
