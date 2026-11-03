@extends('layouts.main')

@section('title', 'Favorites')
@section('subtitle', 'Places you have saved')

@section('content')
    <div class="card favorites-page">
        <div class="card-header">
            <div>
                <div class="card-title">Saved places</div>
                <div class="card-description">Click ★ to remove a place from favorites</div>
            </div>
        </div>

        <div class="empty-state" id="favoritesEmpty" @if ($favorites->isNotEmpty()) hidden @endif>
            <p>No favorites yet</p>
            <a href="{{ route('search') }}" class="btn primary">Find places</a>
        </div>

        @if ($favorites->isNotEmpty())
            <div class="staking-grid">
                @foreach ($favorites as $result)
                    <x-place-card :place="$result" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
