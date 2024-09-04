<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Inertia\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TemporaryOrder;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $category_name = $request->category;
        $category = Category::where('name', $category_name)->first();
        Session::forget(['snapToken']);
        if ($category_name && $category_name != 'All') {
            $products = Product::with('category')->where('category_id', $category->id)->get();
        } else {
            $products = Product::with('category')->get();
        }


        return Inertia::render(
            'Home',
            [
                'products' => $products,
                'userOrders' => TemporaryOrder::with('product')->where('session_id', session('session_id'))->where('customer_name', session('customer_name'))->where('table_number', session('table_number'))->get(),
                'categories' => Category::all(),
                'clientKey' => env('MIDTRANS_CLIENT_KEY')
            ]
        );
    }
}
