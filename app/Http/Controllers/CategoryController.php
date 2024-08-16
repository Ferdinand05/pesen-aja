<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia(
            'Category/CategoryView',
            [

                //TODO Buat collection untuk setiap data yg dikirim ke View agar relasi dapat ikut termuat
                'categories' => Category::with('products')->get()
            ]
        );
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
        $data =  $request->validate([
            'name' => ['required', 'string', 'max:100']
        ]);

        Category::create($data);

        return to_route('categories.index')->with('message', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('Category/EditCategoryView', ['category' => $category->load('products')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:100|string'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return to_route('categories.index')->with('message', 'Data UPDATED successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return to_route('categories.index')->with('message', 'Data has been DELETED successfully');
    }
}
