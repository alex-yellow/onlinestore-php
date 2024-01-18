@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif
    <h1 class="mb-4">{{ $title }}</h1>

    @if($orders->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->date }}</td>
                <td>{{ $order->product->name }}</td>
                <td class="d-flex">
                    <form action="{{ route('orders.updateQuantityMinus', ['orderId' => $order->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm margin-right-1 w-70">-</button>
                    </form>
                    <span class="num">{{ $order->quantity }}</span>
                    <form action="{{ route('orders.updateQuantityPlus', ['orderId' => $order->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm margin-left-1 w-70">+</button>
                    </form>

                </td>

                <td>
                    @if($order->status)
                    deliver
                    @else
                    inCart
                    @endif
                </td>
                <td>
                    <!-- Ссылка на изменение статуса -->
                    <form action="{{ route('orders.updateStatus', ['orderId' => $order->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Update Status?')">
                        @csrf
                        <button type="submit" class="btn btn-primary">Order</button>
                    </form>
                </td>
                <td>
                    <!-- Форма для удаления заказа -->
                    <form action="{{ route('orders.delete', ['orderId' => $order->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Delete order?')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Delete Order</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No orders available.</p>
    @endif
    <a class="btn btn-primary mt-3" href="/">Back to Home</a>
</div>
@endsection
