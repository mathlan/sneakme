<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        // dd($products); //develop and die, c pour faire un var_dump et un die
        return view('product.admin',[
                'products' => $products
            ]
        );
    }

    public function show(Product $product)
    {
        return view('product.show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit',compact('product','categories'));
        // $product = Product::edit($request->all());
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
        ]);

        $product->update($validatedData);

        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index');
    }

    public function create()
    {
        return view('product.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);


        $product = Product::create($request->all());

        return redirect()->route('product.index');

    }
}
