<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('updated_at', 'DESC')->get();
        // dd($products); //develop and die, c pour faire un var_dump et un die
        return view('product.admin',[
                'products' => $products
            ]
        );
    }

    public function show(Product $product)
    {
        $storagePath  = Storage::disk('local')->getDriver();
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
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image-file' => 'required|file',
        ]);

        $image = $request->file('image-file');
        $image_name = $image->getClientOriginalName();
        $path = $request->file('image-file')->storeAs('public/product', $image_name);
        //dd($path);

        $product->update(['image' => $image_name]);

        $product->update($validatedData);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
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
            'image-file' => 'required|file',
        ]);

        $image = $request->file('image-file');
        $image_name = $image->getClientOriginalName();
        $path = $request->file('image-file')->storeAs('public/product', $image_name);
        //dd($path);

        $request->merge(['image' => $image_name]);


        $product = Product::create($request->all());

        return redirect()->route('products.index');

    }
}
