<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('user');
        $admin = $request->session()->get('admin');

        $category_id = $request->input('category_id');
        $search = $request->input('search');

        $productsQuery = Product::query();
        if ($category_id) {
            $productsQuery->where('category_id', $category_id);
        }

        if ($search) {
            $productsQuery->where('name', 'LIKE', '%' . $search . '%');
        }

        $products = $productsQuery->get();

        $categories = Category::all();

        return view('index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category_id,
            'searchQuery' => $search,
            'user' => $user,
            'admin' => $admin,
            'title' => 'Products'
        ]);
    }
    public function showProduct(Request $request, $id)
    {
        $user = $request->session()->get('user');
        $admin = $request->session()->get('admin');

        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('index');
        }
        $productId = $product->id;
        return view('product', [
            'product' => $product,
            'user' => $user,
            'admin' => $admin,
            'title' => $product->name,
            'productId' => $productId,
        ]);
    }
}
