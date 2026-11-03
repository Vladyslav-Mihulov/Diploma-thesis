<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Search;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function show()
    {
        if (!Auth::user()->roles->contains('name', 'Admin')) {
            abort(403);
        }

        $totalRequests = Search::count();

        $userSearches = Search::whereNotNull('users_id')->count();
        $guestSearches = Search::whereNull('users_id')->count();

        $successfulRequests = Search::whereHas('results', function ($query) {
            $query->whereNotNull('description')
                ->where('description', '!=', 'Description unavailable');
        })->count();

        $failedRequests = $totalRequests - $successfulRequests;

        $successRate = $totalRequests > 0
            ? round(($successfulRequests / $totalRequests) * 100, 1)
            : 0;

        $travelTypes = Search::select('category')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $totalUsers = User::count();

        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->count();

        $regularUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->count();

        return view('admin.statistics', compact(
            'totalRequests',
            'successfulRequests',
            'failedRequests',
            'successRate',
            'userSearches',
            'guestSearches',
            'travelTypes',
            'totalUsers',
            'adminUsers',
            'regularUsers'
        ));
    }
}