@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h5 class="card-title mb-4">Send Message to {{ $admin->name }}</h5>
    <form action="{{ route('user.sendUserToAdminMessage', ['adminId' => $admin->id]) }}" method="post">
        @csrf
        <div class="form-group mt-3">
            <label for="messageText">Message:</label>
            <textarea class="form-control mt-3" id="messageText" name="messageText" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Send Message</button>
    </form>

    <!-- Ссылка на возврат назад -->
    <a href="{{ route('users.messages', ['userId' => $user['id']]) }}" class="btn btn-secondary mt-3">Back to User Messages</a>
</div>
@endsection
