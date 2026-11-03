@extends('layouts.main')

@section('title', 'Search Results')
@section('subtitle', 'Places found near your location')

@section('content')
    <div class="market-stats">
        <div class="market-stat">
            <div class="market-stat-label">Places found</div>
            <div class="market-stat-value">{{ count($places ?? []) }}</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Average rating</div>
            <div class="market-stat-value">
                ★ {{ number_format((float) collect($places ?? [])->avg('rating'), 1) }}
            </div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Latitude</div>
            <div class="market-stat-value">{{ isset($coordinates) ? round($coordinates['lat'], 5) : '-' }}</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Longitude</div>
            <div class="market-stat-value">{{ isset($coordinates) ? round($coordinates['lng'], 5) : '-' }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Location</div>
            <a href="{{ route('search') }}" class="view-all">New search</a>
        </div>

        <div class="toggle-item">
            <div class="toggle-info">
                <div class="toggle-title">Your search location</div>
                <div class="toggle-description">
                    {{ collect([$formData['address'], $formData['city'], $formData['state'], $formData['postcode']])->filter()->implode(', ') }}
                </div>
            </div>
        </div>
        <div class="toggle-item">
            <div class="toggle-info">
                <div class="toggle-title">Resolved location</div>
                <div class="toggle-description">{{ $resolved_address ?? 'Address not resolved' }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Results</div>
                @guest
                    <div class="card-description">
                        <a href="{{ route('login') }}" class="view-all">Sign in</a> to save places to your favorites
                    </div>
                @endguest
            </div>
        </div>

        @if (empty($places))
            <div class="empty-state">No places found</div>
        @else
            <div class="staking-grid">
                @foreach ($places as $place)
                    <x-place-card :place="$place" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
