@extends('layouts.main')

@section('title', 'Users')
@section('subtitle', 'Manage users, search records and change user roles')

@section('content')
    <form action="{{ route('admin.users') }}" method="GET" class="search-filters">
        <div class="search-box">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Search by ID, name, email, creator ID, modifier ID or role...">
        </div>

        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="direction" value="{{ $direction }}">

        <button type="submit" class="btn primary">Search</button>
        <a href="{{ route('admin.users') }}" class="btn">Clear</a>
    </form>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Users list</div>
                <div class="card-description">Total users found: {{ $users->total() }}</div>
            </div>
        </div>

        @php
            $columns = [
                'id' => 'ID',
                'f_name' => 'First name',
                'l_name' => 'Last name',
                'created_by' => 'Created by',
                'modify_by' => 'Modified by',
                'modify_at' => 'Modified at',
                'email' => 'Email',
                'role_name' => 'Role',
                'created_at' => 'Created at',
            ];
        @endphp

        <div class="table-wrapper">
            <table class="market-table">
                <thead>
                    <tr>
                        @foreach ($columns as $column => $label)
                            <th>
                                <a href="{{ route('admin.users', [
                                    'sort' => $column,
                                    'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
                                    'search' => $search ?? '',
                                ]) }}"
                                    class="{{ $sort === $column ? 'active' : '' }}">
                                    {{ $label }}
                                    @if ($sort === $column)
                                        {{ $direction === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach

                        <th>Change role</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><span class="coin-rank">{{ $user->id }}</span></td>
                            <td><span class="coin-name">{{ $user->f_name }}</span></td>
                            <td><span class="coin-name">{{ $user->l_name }}</span></td>
                            <td class="volume-cell">{{ $user->created_by ?? '-' }}</td>
                            <td class="volume-cell">{{ $user->modify_by ?? '-' }}</td>
                            <td class="volume-cell">{{ $user->modify_at ?? '-' }}</td>
                            <td class="coin-symbol">{{ $user->email }}</td>
                            <td>
                                @forelse ($user->roles as $role)
                                    <span class="profile-badge">{{ $role->name }}</span>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td class="volume-cell">{{ $user->created_at ?? '-' }}</td>

                            <td>
                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST"
                                        class="role-form">
                                        @csrf

                                        <select name="role_id" class="form-select" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @selected($user->roles->contains('id', $role->id))>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="add-btn">Update</button>
                                    </form>
                                @else
                                    <span class="coin-symbol">Current user</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 }}">
                                <div class="empty-state">No users found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links('components.pagination') }}
    </div>
@endsection
