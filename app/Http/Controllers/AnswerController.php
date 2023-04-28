<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Keyword;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::all();
        return view('answer.admin',[
                'answers' => $answers
            ]
        );
    }

    public function create()
    {
        return view('answer.create', [
            'answers' => Answer::all()
        ]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|min:3|max:255',
        ]);


        $answer = Answer::create($request->all());

        return redirect()->route('answer.index');

    }

    public function show(Answer $answer)
    {
        return view('answer.show', [
            'answer' => $answer
        ]);
    }

    public function edit(Answer $answer)
    {
        //$keywords = Keyword::all();
        return view('answer.edit',compact('answer'/*,'keywords'*/));
        // $product = Product::edit($request->all());
    }

    public function update(Request $request, Answer $answer)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
        ]);

        $answer->update($validatedData);

        return redirect()->route('answer.index');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();
        return redirect()->route('answer.index');
    }
}
