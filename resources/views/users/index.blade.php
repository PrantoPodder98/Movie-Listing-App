@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Users</h1>
    @foreach($users as $email => $favorites)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">{{ $email }}</h5>
                    <a href="{{ route('users.details', ['email' => $email]) }}" class="btn btn-secondary">Details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection