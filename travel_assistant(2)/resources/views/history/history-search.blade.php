@extends('layouts.main')

@section('content')

<div class="container">

    <div class="block-address">
        <h2>Search Details</h2>

        <p>
            {{ $search->address }},
            {{ $search->city }},
            {{ $search->state }},
            {{ $search->postcode }}
        </p>

        <h3>Category:</h3>
        <p>{{ $search->category }}</p>

        <h3>Distance:</h3>
        <p>{{ $search->distance }} km</p>
    </div>

    <h1>Results</h1>

    @if ($search->results->isEmpty())
        <p>No results found</p>
    @else
        <div class="grid">

            @foreach ($search->results as $result)
                <div class="card">

                    <h3>{{ $result->place_name }}</h3>

                    <p>📍 {{ $result->address }}</p>

                    <p>📏 {{ $result->distance ?? 0 }} m</p>

                    <p>⭐ {{ $result->rating }}</p>

                    <p>{{ $result->description }}</p>

                </div>
            @endforeach

        </div>
    @endif

</div>

@endsection