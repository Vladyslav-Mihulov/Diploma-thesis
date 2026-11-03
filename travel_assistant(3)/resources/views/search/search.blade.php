@extends('layouts.main')

@section('title', 'Search')
@section('subtitle', 'Find places to relax near your location')

@php
    $travelTypes = [
        'beach' => 'Beach',
        'hiking' => 'Hiking',
        'relax' => 'Relax',
        'culture' => 'Culture',
        'gastronomic' => 'Gastronomic',
        'city' => 'City',
        'nature' => 'Nature',
    ];

    $distances = [10, 50, 100, 200, 500];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Search menu</div>
                <div class="card-description">Start typing your address and choose it from the suggestions</div>
            </div>
        </div>

        <form class="form-grid" id="search-form" action="{{ route('search.post') }}" method="POST">
            @csrf

            <div class="form-group full-width">
                <label class="form-label" for="address">Address</label>
                <input class="form-input" id="address" name="address" autocomplete="billing address-line1"
                    value="{{ old('address_address-search') }}" placeholder="Street and number" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="city">City</label>
                <input class="form-input" id="city" name="city" autocomplete="billing address-level2"
                    value="{{ old('city') }}" placeholder="City" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="state">State</label>
                <input class="form-input" id="state" name="state" autocomplete="billing address-level1"
                    value="{{ old('state') }}" placeholder="State" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="postcode">ZIP / Postcode</label>
                <input class="form-input" id="postcode" name="postcode" autocomplete="billing postal-code"
                    value="{{ old('postcode') }}" placeholder="ZIP / Postcode">
            </div>

            <div class="form-group">
                <label class="form-label" for="travel-type">Type of travel</label>
                <select class="form-select" id="travel-type" name="travel-type" required>
                    @foreach ($travelTypes as $value => $label)
                        <option value="{{ $value }}" @selected(old('travel-type') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="travel-distance">Distance of travel</label>
                <select class="form-select" id="travel-distance" name="travel-distance" required>
                    @foreach ($distances as $distance)
                        <option value="{{ $distance }}" @selected((int) old('travel-distance') === $distance)>
                            Up to {{ $distance }} km
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group full-width">
                <div class="btn-group">
                    <button class="btn primary" type="submit" id="search-submit">Search</button>
                    <button class="btn" type="reset">Clear</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script id="search-js" defer src="https://api.mapbox.com/search-js/v1.5.1/web.js"></script>
    <script>
        const ACCESS_TOKEN = "{{ env('MAPBOX_TOKEN') }}";

        window.addEventListener('load', () => {
            mapboxsearch.autofill({
                accessToken: ACCESS_TOKEN
            });
        });

        document.getElementById('search-form').addEventListener('submit', () => {
            const btn = document.getElementById('search-submit');
            btn.disabled = true;
            btn.textContent = 'Searching…';
        });
    </script>
@endpush
