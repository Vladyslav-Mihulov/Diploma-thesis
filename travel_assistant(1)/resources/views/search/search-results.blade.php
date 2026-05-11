@extends('layouts.main')

@section('content')


    <div class="block-address">
        <h3>Your search location:</h3>

        <p>
            {{ $formData['address'] }},
            {{ $formData['city'] }},
            {{ $formData['state'] }},
            {{ $formData['postcode'] }}
        </p>

        <h2>
            Searched location:
        </h2>

        <p>
            {{ $resolved_address ?? 'Address not resolved' }}
        </p>

        <h2>
            Coordinates:
        </h2>
        @if (isset($coordinates))
            <p> Longitude: {{ $coordinates['lng'] }}</p>
            <p> Latitude: {{ $coordinates['lat'] }}</p>
        @endif
    </div>
    <div class="container">

        <h1>Results</h1>

        @if (empty($places))
            <p>No places found</p>
        @else
            <div class="grid">

                @foreach ($places as $place)
                    <div class="card">

                        <h3>{{ $place['name'] }}</h3>

                        <p>
                            📍 {{ $place['address'] }}
                        </p>

                        <p>
                            📏 {{ $place['distance'] ?? 0 }} m
                        </p>

                        <p>
                            ⭐ {{ $place['rating'] }}
                        </p>

                        <p>
                            {{ $place['description'] }}
                        </p>

                    </div>
                @endforeach

            </div>
        @endif

    </div>

@endsection
