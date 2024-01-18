@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif
    <h1 class="mb-4">Product List</h1>
    <form method="GET" action="{{ url('/') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="category_id" id="category_id" class="form-select">
                    <option value="" selected disabled>Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search" value="{{ $searchQuery }}">
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <a href="{{ url('/products', ['id' => $product->id]) }}" class="text-decoration-none">
                <div class="card d-flex h-100">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text flex-fill">Stock: {{ $product->stock }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
