@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1>All Movies</h1>
            <form action="{{ route('movies.search') }}" method="POST" class="mb-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Search Title/Cast/Category">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        
        @foreach ($movies as $movie)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $movie['title'] }}</h5>
                    <div class="d-flex">
                        @if (session('email'))
                            <form action="{{ route('users.favorites.add', $movie['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mx-1">Favorite</button>
                            </form>
                        @endif
                        <a href="{{ route('movies.details', $movie['id']) }}" class="btn btn-secondary">Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
