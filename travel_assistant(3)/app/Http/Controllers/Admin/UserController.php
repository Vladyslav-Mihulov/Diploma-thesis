<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(Request $request)
    {
        if (!Auth::user()->roles->contains('name', 'Admin')) {
            abort(403);
        }

        $allowedSorts = [
            'id',
            'f_name',
            'l_name',
            'email',
            'role_name',
            'created_by',
            'created_at',
            'modify_by',
            'modify_at',
        ];

        $sort = $request->query('sort', 'id');
        $direction = $request->query('direction', 'asc');

        $search = trim($request->query('search', ''));

        $query = User::with('roles');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('f_name', 'like', "%{$search}%")
                    ->orWhere('l_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('created_by', 'like', "%{$search}%")
                    ->orWhere('modify_by', 'like', "%{$search}%")
                    ->orWhereHas('roles', function ($roleQuery) use ($search) {
                        $roleQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        if ($sort === 'role_name') {
            $users = (clone $query)
                ->select('users.*')
                ->selectRaw("
            CASE
                WHEN EXISTS (
                    SELECT 1
                    FROM user_role
                    INNER JOIN roles ON roles.id = user_role.roles_id
                    WHERE user_role.users_id = users.id
                    AND roles.name = 'Admin'
                ) THEN 'Admin'
                WHEN EXISTS (
                    SELECT 1
                    FROM user_role
                    INNER JOIN roles ON roles.id = user_role.roles_id
                    WHERE user_role.users_id = users.id
                    AND roles.name = 'User'
                ) THEN 'User'
                ELSE ''
            END AS role_name
        ")
                ->orderBy('role_name', $direction)
                ->orderBy('id')
                ->paginate(15)
                ->withQueryString();
        } else {
            $users = (clone $query)
                ->orderBy($sort, $direction)
                ->orderBy('id')
                ->paginate(15)
                ->withQueryString();
        }

        $roles = Role::all();

        return view('admin.show-users', compact(
            'users',
            'roles',
            'sort',
            'direction',
            'search'
        ));

    }

    public function updateRole(Request $request, User $user)
    {
        if (!Auth::user()->roles->contains('name', 'Admin')) {
            abort(403);
        }

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('admin.users')
                ->withErrors([
                    'error' => 'You cannot change your own role.'
                ]);
        }

        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->roles()->sync([$request->role_id]);

        $user->update([
            'modify_at' => now(),
            'modify_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.users')
            ->with('success', ['User role updated successfully.']);
    }
}
