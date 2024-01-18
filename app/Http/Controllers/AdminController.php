<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showProducts()
    {
        $products = Product::paginate(5);

        return view('admin.index', ['products' => $products])->with('success', 'You have logged in success!');
    }

    public function createProductForm()
    {
        $categories = Category::all();
        return view('admin.create', ['title' => 'Add Product', 'categories' => $categories]);
    }
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($request->only(['name', 'description', 'price', 'stock', 'image', 'category_id']));

        return redirect()->route('admin.products')->with('success', 'Product added success!');
    }

    public function editProductForm($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);

        return view('admin.edit', ['product' => $product, 'categories' => $categories, 'title' => 'Edit Product']);
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'description', 'price', 'stock', 'image', 'category_id']));

        return redirect()->route('admin.products')->with('success', 'Product updated success!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted success!');
    }

    public function showOrders()
    {
        $orders = Order::with(['product', 'user'])->orderBy('id')->get();

        return view('admin.orders', ['orders' => $orders]);
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Order deleted success!');
    }
    public function showUsers()
    {
        $users = User::all();

        return view('admin.users', ['users' => $users]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Удалить все заказы пользователя
        $user->orders()->delete();

        // Удалить все сообщения1 пользователя
        $user->messages1()->delete();

        // Удалить все сообщения2 пользователя
        $user->messages2()->delete();

        // Удалить все комментарии пользователя
        $user->comments()->delete();

        // Удалить пользователя
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User delete success!');
    }
}
