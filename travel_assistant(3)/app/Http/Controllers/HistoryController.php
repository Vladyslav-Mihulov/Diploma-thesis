<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Search;

class HistoryController extends Controller
{
    public function show()
    {
        $searches = Search::where('users_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('history.history', compact('searches'));
    }

    public function show_search($id)
    {
        $search = Search::with('results')
            ->where('users_id', Auth::id())
            ->findOrFail($id);

        return view('history.history-search', compact('search'));
    }
}
