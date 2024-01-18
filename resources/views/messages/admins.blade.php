@extends('layouts.app', ['title' => 'Admins'])

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Admins</h1>

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
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->name }}</td>
                <td>
                    <a href="{{ route('user.showSendUserToAdminForm', ['adminId' => $admin->id]) }}" class="btn btn-success btn-sm">Send Message</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-primary mt-3" href="/">Back to Home</a>
</div>
@endsection
