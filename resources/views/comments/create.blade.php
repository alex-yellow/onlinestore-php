@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Add Comment</h1>

    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('comments.add', ['productId' => $productId]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="text" class="form-label">Comment</label>
            <textarea class="form-control" id="text" name="text" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>
</div>
@endsection
