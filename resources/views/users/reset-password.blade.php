@extends('layouts.app')

@section('page-title', 'Reset Password')

@section('content')

    <div style="max-width: 500px;">
        <h2 style="font-size: 20px; font-weight: 700; color: #333; margin-bottom: 24px; border-bottom: 2px solid #1a5c45; padding-bottom: 10px;">
            Reset Password — {{ $user->name }}
        </h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.reset-password', $user) }}" method="POST">
            @csrf

            <div class="form-card">
                <p style="font-size: 13px; color: #666; margin-bottom: 16px;">
                    Password baru akan berlaku langsung. Pastikan disampaikan ke pengguna ({{ $user->email }}) secara aman.
                </p>

                <div class="form-group">
                    <label class="form-label">Password Baru *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div style="text-align: right;">
                    <a href="{{ route('users.index') }}" class="btn" style="margin-right: 8px;">Batal</a>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </div>
        </form>
    </div>

@endsection
