<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Product/ProductView', ['categories' => Category::all(), 'products' => Product::with('category')->orderBy('name', 'asc')->paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'category_id' => ['required'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg']
        ]);

        $image = $request->image;
        if ($image) {
            $name = Str::random(15);
            $ext = $image->getClientOriginalExtension();
            $imageName = $name . '.' . $ext;
            $image->storeAs('product-image', $imageName);
        } else {
            $imageName = null;
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imageName
        ]);

        return to_route('products.index')->with('message', 'Success!! Product CREATED');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return Inertia::render('Product/EditProductView', ['product' => Product::find($id), 'categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'category_id' => ['required'],
            'image' => ['image', 'mimes:png,jpg,jpeg', 'nullable']
        ]);

        $image = $request->image;
        $product = Product::whereId($id)->first();
        if ($image) {
            $name = Str::random(15);
            $ext = $image->getClientOriginalExtension();
            $imageName = $name . '.' . $ext;

            $image->storeAs('product-image', $imageName);
            Storage::delete('product-image/' . $product->image);
        } else {
            $imageName = $product->image;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imageName
        ]);

        return to_route('products.index')->with('message', 'Product UPDATED');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete('product-image/' . $product->image);
        $product->delete();

        return to_route('products.index')->with('message', 'Product DELETED');
    }
}
