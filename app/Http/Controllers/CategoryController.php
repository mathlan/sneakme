<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        // dd($products); //develop and die, c pour faire un var_dump et un die
        return view('categories.admin',[
                'categories' => $categories
            ]
        );
    }

    public function create()
    {
        return view('categories.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|min:3|max:255',
        ]);


        $categorie = Category::create($request->all());

        return redirect()->route('categories.index');

    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('categories.edit',compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
