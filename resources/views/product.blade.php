@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>{{ $product->name }}</h1>
    <div class="card">
        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text">Price: ${{ $product->price }}</p>
            <p class="card-text">Stock: {{ $product->stock }}</p>

            <h3 class="card-text">
                <a href="{{ route('comments.show', ['productId' => $productId]) }}" class="text-decoration-none">Comments</a>
            </h3>
            <form action="{{ route('orders.addToCart', ['productId' => $productId]) }}" method="post" class="d-inline" onsubmit="return confirm('Add Product?')">
                @csrf
                <div class="form-group mt-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control mt-3" name="quantity" id="quantity" value="1">

                    @if ($user)
                    <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
                    @else
                    <h3 class="mt-3">To add an item to the shopping cart, log in</h3>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
