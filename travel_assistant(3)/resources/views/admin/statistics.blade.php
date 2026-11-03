@extends('layouts.main')

@section('title', 'Statistics')
@section('subtitle', 'Application and AI usage statistics')

@php($travelTypesTotal = $travelTypes->sum('total'))

@section('content')
    <h2 class="section-title">AI Statistics</h2>

    <div class="market-stats">
        <div class="market-stat">
            <div class="market-stat-label">Total AI requests</div>
            <div class="market-stat-value">{{ $totalRequests }}</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Successful requests</div>
            <div class="market-stat-value">{{ $successfulRequests }}</div>
            <div class="market-stat-change positive">With AI descriptions</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Failed requests</div>
            <div class="market-stat-value">{{ $failedRequests }}</div>
            <div class="market-stat-change negative">Description unavailable</div>
        </div>
        <div class="market-stat">
            <div class="market-stat-label">Success rate</div>
            <div class="market-stat-value">{{ $successRate }}%</div>
        </div>
    </div>

    <div class="content-grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Popular Travel Types</div>
                    <div class="card-description">Number of searches for each travel type</div>
                </div>
            </div>

            @if ($travelTypes->isEmpty())
                <div class="empty-state">No searches yet</div>
            @else
                <div class="trending-list">
                    @foreach ($travelTypes as $travelType)
                        <div class="trending-item">
                            <div class="trending-rank">{{ $loop->iteration }}</div>
                            <div class="trending-coin">
                                <div>
                                    <div class="trending-name">{{ ucfirst($travelType->category) }}</div>
                                    <div class="trending-symbol">{{ $travelType->total }} searches</div>
                                </div>
                            </div>
                            <div class="trending-change positive">
                                {{ $travelTypesTotal > 0 ? round(($travelType->total / $travelTypesTotal) * 100, 1) : 0 }}%
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">AI Success Rate</div>
                    <div class="card-description">Share of searches with AI descriptions</div>
                </div>
            </div>

            <div class="fear-greed">
                <div class="fear-greed-meter">
                    <div class="fear-greed-indicator" style="left: {{ min(max($successRate, 0), 100) }}%;"></div>
                </div>
                <div class="fear-greed-labels">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
                <div class="fear-greed-value">
                    <div class="fear-greed-number">{{ $successRate }}%</div>
                    <div class="fear-greed-label">{{ $successfulRequests }} of {{ $totalRequests }} requests</div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="section-title">Search Statistics</h2>

    <div class="balance-cards">
        <div class="balance-card primary">
            <div class="balance-label">Total searches</div>
            <div class="balance-value">{{ $totalRequests }}</div>
            <div class="balance-change">All saved searches</div>
        </div>
        <div class="balance-card">
            <div class="balance-label">Searches by users</div>
            <div class="balance-value">{{ $userSearches }}</div>
            <div class="balance-change">
                {{ $totalRequests > 0 ? round(($userSearches / $totalRequests) * 100, 1) : 0 }}% of all searches
            </div>
        </div>
        <div class="balance-card">
            <div class="balance-label">Searches by guests</div>
            <div class="balance-value">{{ $guestSearches }}</div>
            <div class="balance-change">
                {{ $totalRequests > 0 ? round(($guestSearches / $totalRequests) * 100, 1) : 0 }}% of all searches
            </div>
        </div>
    </div>

    <h2 class="section-title">User Statistics</h2>

    <div class="balance-cards">
        <div class="balance-card primary">
            <div class="balance-label">Total users</div>
            <div class="balance-value">{{ $totalUsers }}</div>
            <div class="balance-change">Registered accounts</div>
        </div>
        <div class="balance-card">
            <div class="balance-label">Administrators</div>
            <div class="balance-value">{{ $adminUsers }}</div>
            <div class="balance-change">Role: Admin</div>
        </div>
        <div class="balance-card">
            <div class="balance-label">Regular users</div>
            <div class="balance-value">{{ $regularUsers }}</div>
            <div class="balance-change">Role: User</div>
        </div>
    </div>
@endsection
