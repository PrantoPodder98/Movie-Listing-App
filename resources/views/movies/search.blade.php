@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1>All Movies</h1>
            {{--  <form action="{{ route('movies.search') }}" method="GET">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>  --}}
        </div>
        
        @foreach ($movies as $movie)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $movie['title'] }}</h5>
                    <div class="d-flex">
                        {{--  @if (session('email'))
                            <form action="{{ route('users.favorites.add', $movie['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mx-1">Favorite</button>
                            </form>
                        @endif  --}}
                        <a href="{{ route('movies.details', $movie['id']) }}" class="btn btn-secondary">Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
