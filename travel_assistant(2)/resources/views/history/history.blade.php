@extends('layouts.main')

@section('content')
    <div class="card">
        <h2>Search History</h2>

        @foreach ($searches as $search)
            <div style="padding:15px;border:1px solid #ddd;margin-bottom:10px;border-radius:8px;">

                <div>
                    <strong>{{ $search->address }}</strong>
                </div>

                <div>
                    {{ $search->city }}, {{ $search->state }}
                </div>

                <div>
                    <span>Category:</span> {{ $search->category }}
                </div>

                <div>
                    <span>Distance:</span> {{ $search->distance }} km
                </div>

                <div style="font-size:12px;color:#666;">
                    {{ $search->created_at }}
                </div>

                <a href="{{ route('history.search', $search->id) }}">
                    Show details
                </a>

            </div>
        @endforeach

    </div>
@endsection