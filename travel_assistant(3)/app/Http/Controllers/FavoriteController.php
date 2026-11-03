<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $exists = $user->favorites()
            ->where('result_id', $id)
            ->exists();

        if ($exists) {

            $user->favorites()->detach($id);


            return response()->json([
                'status' => 'removed'
            ]);
        }

        $user->favorites()->attach($id);

        return response()->json([
            'status' => 'added'
        ]);
    }

    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        $favorites = $user->favorites()
            ->orderBy('favorites.created_at', 'desc')
            ->get();

        return view('favorites', compact('favorites'));
    }
}
