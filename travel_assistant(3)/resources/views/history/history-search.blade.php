@extends('layouts.main')

@section('title', 'Search Details')
@section('subtitle', collect([$search->address, $search->city, $search->state, $search->postcode])->filter()->implode(', '))

@section('content')
    <div class="market-stats">
        <div class="market-stat">
            <div class="market-stat-label">Category</div>
            <div class="market-stat-value">{{ ucfirst($search->category) }}</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Distance</div>
            <div class="market-stat-value">{{ $search->distance }} km</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Places found</div>
            <div class="market-stat-value">{{ $search->results->count() }}</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Date</div>
            <div class="market-stat-value">
                {{ $search->created_at ? \Illuminate\Support\Carbon::parse($search->created_at)->format('d.m.Y') : '-' }}
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Results</div>
            <a href="{{ route('history') }}" class="view-all">← Back to history</a>
        </div>

        @if ($search->results->isEmpty())
            <div class="empty-state">No results found</div>
        @else
            <div class="staking-grid">
                @foreach ($search->results as $result)
                    <x-place-card :place="$result" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
