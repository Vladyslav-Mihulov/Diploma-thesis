@extends('layouts.main')
@section('content')
    <div class="page-header">
        <h1>Settings</h1>
        <p>Manage your account preferences and security</p>
    </div>

    <div class="settings-content active" id="profile">
        <div class="card">

            <div class="profile-header">

                <div class="profile-avatar">
                    {{ strtoupper(substr($user->f_name, 0, 1)) }}{{ strtoupper(substr($user->l_name, 0, 1)) }}

                    <div class="avatar-edit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                    </div>
                </div>

                <div class="profile-info">
                    <h2>{{ $user->f_name }} {{ $user->l_name }}</h2>

                    <p>{{ $user->email }}</p>

                    <div class="roles-wrapper">
                        @foreach ($user->roles as $role)
                            <span class="profile-badge">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
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

                <div class="form-group full-width">
                    <label class="form-label">Roles</label>

                    <input type="text" class="form-input"
                        value="@foreach ($user->roles as $role){{ $role->name }}@if (!$loop->last), @endif @endforeach"
                        disabled>
                </div>

            </div>

        </div>
    </div>
@endsection
