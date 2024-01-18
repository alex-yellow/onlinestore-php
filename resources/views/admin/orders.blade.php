@extends('layouts.app', ['title' => 'Admin Orders'])

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Admin Orders</h1>

    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Product Name</th>
                <th>User Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->date }}</td>
                <td>{{ $order->product->name }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>
                    @if($order->status == 0)
                    inCart
                    @else
                    deliver
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.orders.delete', ['id' => $order->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-primary mt-3" href="/">Back to Home</a>
</div>
@endsection
