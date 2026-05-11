@extends('layouts.main')

@section('content')
@if ($errors->any())
    <div class="block-error">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="settings-content active" id="profile">
        <div class="card-header">
            <h3 class="card-title">Search menu</h3>
        </div>
        <div class="card">

            <label class="form-label">Select your address</label>
            <form class="form-grid" id="search-form" action="{{ route('search.post') }}" method="POST">
                @csrf

                <input class="form-input" id="address" name="address" autocomplete="billing address-line1"
                    placeholder="Address" required>
                <div class="flex">
                    <input class="form-input" id="city" name="city" autocomplete="billing address-level2"
                        placeholder="City" required>
                    <input class="form-input" id="state" name="state" autocomplete="billing address-level1"
                        placeholder="State" required>
                    <input class="form-input" id="postcode" name="postcode" autocomplete="billing postal-code"
                        placeholder="ZIP / Postcode">
                </div>

                <div class="form-group">
                    <label class="form-label" for="travel-type">Type of travel:</label>
                    <select class="form-select" id="travel-type" name="travel-type" required>
                        <option value="beach">Beach</option>
                        <option value="hiking">Hiking</option>
                        <option value="relax">Relax</option>
                        <option value="culture">Culture</option>
                        <option value="gastronomic">Gastronomic</option>
                        <option value="city">City</option>
                        <option value="nature">Nature</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="travel-distance">Distance of travel:</label>
                    <select class="form-select" id="travel-distance" name="travel-distance" required>
                        <option value="10">Up to 10 km</option>
                        <option value="50">Up to 50 km</option>
                        <option value="100">Up to 100 km</option>
                        <option value="200">Up to 200 km</option>
                        <option value="500">Up to 500 km</option>
                    </select>
                </div>

                <div class="btn-group">
                    <button class="btn primary" type="submit">Search</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Default styling. Feel free to remove! -->
    <link href="https://api.mapbox.com/mapbox-assembly/v1.3.0/assembly.min.css" rel="stylesheet">
    <script id="search-js" defer="" src="https://api.mapbox.com/search-js/v1.5.1/web.js"></script>
    <script>
        const ACCESS_TOKEN = "{{ env('MAPBOX_TOKEN') }}";
        window.addEventListener('load', () => {

            const collection = mapboxsearch.autofill({
                accessToken: ACCESS_TOKEN
            });
        });
    </script>
@endsection
