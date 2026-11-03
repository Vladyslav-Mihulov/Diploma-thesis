@extends('layouts.main')

@section('title', 'Profile')
@section('subtitle', 'Your account information')

@section('content')
    <div class="card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->f_name, 0, 1)) }}{{ strtoupper(substr($user->l_name, 0, 1)) }}
            </div>

            <div class="profile-info">
                <h2>{{ $user->f_name }} {{ $user->l_name }}</h2>
                <p>{{ $user->email }}</p>

                @foreach ($user->roles as $role)
                    <span class="profile-badge">{{ $role->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">First Name</label>
                <input type="text" class="form-input" value="{{ $user->f_name }}" disabled>
            </div>

            <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-input" value="{{ $user->l_name }}" disabled>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" value="{{ $user->email }}" disabled>
            </div>

            <div class="form-group">
                <label class="form-label">Roles</label>
                <input type="text" class="form-input" value="{{ $user->roles->pluck('name')->implode(', ') }}" disabled>
            </div>
        </div>
    </div>
@endsection
