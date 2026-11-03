@php
    $id = is_array($place) ? $place['db_id'] ?? null : $place->id ?? null;
    $name = is_array($place) ? $place['name'] ?? null : $place->place_name ?? null;
    $address = is_array($place) ? $place['address'] ?? null : $place->address ?? null;
    $distance = is_array($place) ? $place['distance'] ?? 0 : $place->distance ?? 0;
    $rating = is_array($place) ? $place['rating'] ?? 0 : $place->rating ?? 0;
    $description = is_array($place) ? $place['description'] ?? null : $place->description ?? null;

    $isFavorite = $id && auth()->check() && auth()->user()->favorites->contains($id);
    $distanceLabel = $distance >= 1000 ? round($distance / 1000, 1) . ' km' : round((float) $distance) . ' m';
@endphp

<div class="staking-card place-card">

    <div class="staking-header">
        <div class="staking-icon">{{ mb_strtoupper(mb_substr($name ?? '?', 0, 1)) }}</div>

        <div class="staking-title">
            <div class="staking-name">{{ $name ?? 'Unnamed place' }}</div>
            <div class="staking-apy">★ {{ number_format((float) $rating, 1) }} / 5</div>
        </div>

        @if ($id)
            <button type="button" class="star-btn {{ $isFavorite ? 'active' : '' }}" data-id="{{ $id }}"
                aria-label="Toggle favorite">{{ $isFavorite ? '★' : '☆' }}</button>
        @endif
    </div>

    @if ($description)
        <p class="place-description">{{ $description }}</p>
    @endif

    <div class="staking-details">
        <span class="staking-label">Address</span>
        <span class="staking-value">{{ $address ?? '-' }}</span>
    </div>

    <div class="staking-details">
        <span class="staking-label">Distance</span>
        <span class="staking-value">{{ $distanceLabel }}</span>
    </div>

    @if ($name)
        <a class="staking-btn"
            href="https://www.google.com/maps/search/?api=1&query={{ urlencode($name . ($address ? ', ' . $address : '')) }}"
            target="_blank" rel="noopener noreferrer">
            Show on map
        </a>
    @endif

</div>
