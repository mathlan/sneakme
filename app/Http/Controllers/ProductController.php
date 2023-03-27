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
        return view('admin',[
                'products' => $products
            ]
        );
    }

    public function show(Product $product)
    {
        return view('show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('edit',compact('product','categories'));
        // $product = Product::edit($request->all());
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
        ]);

        $product->update($validatedData);

        return redirect()->route('admin', $product);
    }
}
