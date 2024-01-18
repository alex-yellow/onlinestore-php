@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif
    <h1 class="mb-4">Comments</h1>

    @foreach($comments as $comment)
    <div class="card mb-3">
        <div class="card-header">
            {{ $comment->user->name }} said:
        </div>
        <div class="card-body">
            <p class="card-text">{{ $comment->text }}</p>
        </div>
        @if(session('admin'))
        <form action="{{ route('comments.delete', ['commentId' => $comment->id]) }}" method="POST" class="card-footer">
            @csrf
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this comment?')">Delete</button>
        </form>
        @endif
    </div>
    @endforeach

    @if(session('user'))
    <div class="mb-3">
        <a href="{{ route('comments.add', ['productId' => $productId]) }}" class="btn btn-primary">Add Comment</a>
    </div>
    @endif
</div>
@endsection
