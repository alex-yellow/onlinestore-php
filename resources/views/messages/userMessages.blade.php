@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if (session('success'))
    <div class="alert alert-success" role="alert" id="mess">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <h2 class="card-title">My Messages</h2>

            @if($messages->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-md-3">Date</th>
                        <th class="col-md-6">Text</th>
                        <th class="col-md-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                    <tr>
                        <td id="myDate">{{ $message->created_at }}</td>
                        <td>{{ $message->message_text }}</td>
                        <td>
                            <a href="{{ route('user.showSendUserToAdminForm', ['userId' => $user->id, 'adminId' => $message->admin_id]) }}" class="btn btn-primary">Reply</a>
                            <form action="{{ route('user.deleteUserMessage', ['userId' => $user->id, 'messageId' => $message->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No messages for this user.</p>
            @endif
        </div>
    </div>

    <a class="btn btn-primary mt-3" href="/">Back to Home</a>
</div>
@endsection
