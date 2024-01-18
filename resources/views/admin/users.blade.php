@extends('layouts.app', ['title' => 'Users'])

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Users</h1>

    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    <a href="{{ route('admin.showSendMessageForm', ['userId' => $user->id]) }}" class="btn btn-success btn-sm">Send Message</a>
                    <form action="{{ route('admin.users.delete', ['id' => $user->id]) }}" method="POST" class="d-inline">
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
