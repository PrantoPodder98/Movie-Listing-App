@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Movie Details</h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{ $movie->title }}</h4>
            <p class="card-text"><strong>Cast:</strong> 
                @foreach($movie->cast as $castMember)
                    {{ $castMember }}@if(!$loop->last), @endif
                @endforeach
                </p>
            <p class="card-text"><strong>Category:</strong> {{ $movie->category }}</p>
            <p class="card-text"><strong>Release Date:</strong> {{ $movie->release_date }}</p>
            <p class="card-text"><strong>Budget:</strong> {{ $movie->budget }}$</p>
        </div>
    </div>
</div>
@endsection