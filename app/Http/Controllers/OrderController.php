<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function showUserOrders($userId)
    {
        $userId = session('user')['id'];
        $orders = Order::where('user_id', $userId)->get();

        return view('orders.index', ['orders' => $orders, 'title' => 'My Orders']);
    }

    public function addToCart(Request $request, $productId)
    {
        $userId = session('user')['id'];
        $quantity = $request->input('quantity', 1);

        // Проверка, есть ли уже товар в корзине для данного пользователя
        $existingOrder = Order::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingOrder) {
            if ($existingOrder->status !== 1) {
                // Если товар уже есть в корзине, увеличиваем количество
                $existingOrder->increment('quantity');
            } else {
                // Если товар уже был заказан, создаем новый заказ
                Order::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'status' => 0,
                ]);
            }
        } else {
            // Если товара нет в корзине, создаем новый заказ
            Order::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'status' => 0,
            ]);
        }

        return redirect()->route('orders.showUserOrders', ['userId' => $userId])->with('success', 'Order created success!');
    }

    public function updateQuantityPlus($orderId)
    {
        $userId = session('user')['id'];
        $order = Order::find($orderId);

        if ($order && $order->status !== 1) {
            $order->increment('quantity');
        }

        return redirect()->route('orders.showUserOrders', ['userId' => $userId]);
    }

    public function updateQuantityMinus($orderId)
    {
        $userId = session('user')['id'];
        $order = Order::find($orderId);

        if ($order && $order->quantity > 1 && $order->status !== 1) {
            $order->decrement('quantity');
        }

        return redirect()->route('orders.showUserOrders', ['userId' => $userId]);
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $userId = session('user')['id'];

        // Получаем текущий заказ
        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $quantity = $order->quantity;

        // Если заказ еще не обработан
        if ($order->status !== 1) {
            // Обновляем значение Status в 1
            $order->update(['status' => 1]);

            // Получаем информацию о товаре
            $product = Product::find($order->product_id);

            if ($product) {
                $stock = $product->stock;
                $newStock = $stock - $quantity;

                // Обновляем количество товара в базе данных
                $product->update(['stock' => $newStock]);
            }
        }

        return redirect()->route('orders.showUserOrders', ['userId' => $userId])->with('success', 'Order status updated success!');
    }

    public function deleteOrder($orderId)
    {
        $userId = session('user')['id'];
        // Удаление заказа из базы данных
        Order::where('id', $orderId)->delete();

        return redirect()->route('orders.showUserOrders', ['userId' => $userId])->with('success', 'Order deleted success!');
    }
}
