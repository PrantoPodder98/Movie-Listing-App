@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-header mb-3">User Details</h1>
                <h5>Email: {{ $user->email }}</h5>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between card-header mb-4">
                    <h2>Favourite Movie</h2>
                    <form action="{{ route('users.favorites.search', $user->email) }}" method="GET" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Search Title/Cast/Category">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <ul>
                    @foreach ($movieNames as $movie)
                        <li>
                            <div class="d-flex">
                                {{ $movie['title'] }}
                                <a class="mx-1" href="{{ route('movies.details', $movie['id']) }}">(Details)</a>
                                @if(session ('email') === $user->email)
                                <form action="{{ route('users.favorites.remove', $movie['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm my-1">Delete</button>
                                </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
