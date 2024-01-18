@extends('layouts.app', ['title' => 'Product List'])

@section('content')
<div class="container mt-5">
    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif

    <h2>Product List</h2>

    <!-- Добавление ссылки на страницу добавления нового товара -->
    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Add New Product</a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>${{ $product->price }}</td>
                <td>
                    <!-- Ссылка на редактирование -->
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <!-- Форма для удаления -->
                    <form action="{{ route('admin.products.delete', ['id' => $product->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Delete product?')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="links">
        {{ $products->links() }}
    </div>
    <a class="btn btn-primary mt-3" href="/">Back to Home</a>
</div>
@endsection
