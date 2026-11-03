@extends('layouts.main')

@section('title', 'History')
@section('subtitle', 'Your previous searches')

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Search History</div>
                <div class="card-description">Total searches: {{ $searches->count() }}</div>
            </div>
            <a href="{{ route('search') }}" class="view-all">New search</a>
        </div>

        @if ($searches->isEmpty())
            <div class="empty-state">
                <p>You haven't searched anything yet</p>
                <a href="{{ route('search') }}" class="btn primary">Start searching</a>
            </div>
        @else
            <div class="transaction-list">
                @foreach ($searches as $search)
                    <div class="transaction-item">
                        <div class="transaction-icon stake">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-copper)"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>

                        <div class="transaction-info">
                            <div class="transaction-type">{{ $search->address }}</div>
                            <div class="transaction-date">
                                {{ collect([$search->city, $search->state])->filter()->implode(', ') }}
                                ·
                                {{ $search->created_at ? \Illuminate\Support\Carbon::parse($search->created_at)->format('d.m.Y H:i') : '-' }}
                            </div>
                        </div>

                        <div class="transaction-amount">
                            <div class="transaction-value">{{ ucfirst($search->category) }}</div>
                            <span class="transaction-status completed">{{ $search->distance }} km</span>
                        </div>

                        <a href="{{ route('history.search', $search->id) }}" class="add-btn">Details</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
