@extends('layouts.app')

@section('page-title', 'Manajemen User')

@section('content')

    @php
        $roleLabels = [
            'super_admin' => 'Super Admin (Akses Penuh JDIH & e-Regulasi)',
            'admin_operator' => 'Operator e-Regulasi (Khusus e-Regulasi)',
            'masyarakat' => 'User Masyarakat / Publik',
        ];
        $roleBadge = [
            'super_admin' => 'reg-status-dot role-super',
            'admin_operator' => 'reg-status-dot role-operator',
            'masyarakat' => 'reg-status-dot role-masyarakat',
        ];
    @endphp

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 18px; font-weight: 600; color: #333;">Manajemen User</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary" style="font-size: 13px;">+ Tambah User</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 16px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 16px;">{{ session('error') }}</div>
    @endif

    <div class="dash-card" style="padding: 8px 20px;">
        <div class="user-list-head">
            <span>Nama</span>
            <span>Role</span>
            <span>Unit Kerja</span>
            <span style="text-align: right;">Aksi</span>
        </div>

        @foreach($users as $u)
            <div class="user-row">
                <div class="user-col-name">
                    <div class="user-name">
                        {{ $u->name }}
                        @if($u->id === auth()->id())
                            <span class="user-you-tag">Anda</span>
                        @endif
                    </div>
                    <div class="user-email">{{ $u->email }}</div>
                </div>

                <div>
                    <span class="{{ $roleBadge[$u->role] ?? 'reg-status-dot' }}">
                        <span class="reg-status-dot-circle"></span>
                        {{ $roleLabels[$u->role] ?? $u->role }}
                    </span>
                </div>

                <div class="user-unit">{{ $u->unit_kerja ?? '—' }}</div>

                <div class="user-actions">
                    <a href="{{ route('users.edit', $u) }}" class="action-btn action-edit">Edit</a>
                    <a href="{{ route('users.reset-password.show', $u) }}" class="action-btn action-reset">Reset Password</a>
                    @if($u->id !== auth()->id())
                        <form action="{{ route('users.destroy', $u) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus user {{ $u->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn action-delete">Hapus</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <style>
        /* ── Role dot — konsisten dengan status dot ── */
        .reg-status-dot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            color: #5a6380;
            background: #f4f5f9;
            border: 1px solid #e8eaf2;
            border-radius: 20px;
            padding: 4px 10px 4px 8px;
            white-space: nowrap;
            text-transform: none;
            letter-spacing: 0;
        }

        .reg-status-dot-circle {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
            background: #c5c8d6;
        }

        .role-super .reg-status-dot-circle {
            background: #e08a2c;
        }

        .role-operator .reg-status-dot-circle {
            background: #5b8def;
        }

        .role-masyarakat .reg-status-dot-circle {
            background: #b0b4c4;
        }

        .role-super {
            color: #8a4c0f;
            background: #fdf4ec;
            border-color: #f5d9b8;
        }

        .role-operator {
            color: #3a5fa8;
            background: #f0f4ff;
            border-color: #d4e0fb;
        }

        .user-list-head {
            display: grid;
            grid-template-columns: 2.2fr 1fr 1.4fr 1.8fr;
            gap: 16px;
            padding: 14px 12px;
            font-size: 11px;
            font-weight: 700;
            color: #9aa1b1;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 2px solid #f0f2f7;
        }

        .user-row {
            display: grid;
            grid-template-columns: 2.2fr 1fr 1.4fr 1.8fr;
            gap: 16px;
            align-items: center;
            padding: 16px 12px;
            border-bottom: 1px solid #f3f5fa;
            transition: background 0.15s ease;
        }

        .user-row:last-child {
            border-bottom: none;
        }

        .user-row:hover {
            background: #f8faff;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .user-you-tag {
            display: inline-block;
            margin-left: 6px;
            font-size: 10px;
            font-weight: 600;
            color: #9aa1b1;
            background: #f0f2f7;
            padding: 1px 7px;
            border-radius: 10px;
            text-transform: none;
        }

        .user-email {
            font-size: 12px;
            color: #9aa1b1;
            margin-top: 2px;
        }

        .user-unit {
            font-size: 13px;
            color: #2d3a55;
        }

        .user-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 7px 12px;
            border-radius: 7px;
            border: 1px solid transparent;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease;
            white-space: nowrap;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .action-edit {
            background: #0d1b3e;
            color: white;
        }

        .action-edit:hover {
            background: #142a5c;
        }

        .action-reset {
            background: white;
            color: #2d3a55;
            border-color: #dadfe8;
        }

        .action-reset:hover {
            background: #f5f6fa;
        }

        .action-delete {
            background: #fdf0f0;
            color: #a32626;
            border-color: #f0c9c9;
        }

        .action-delete:hover {
            background: #fbe2e2;
        }

        @media (max-width: 900px) {
            .user-list-head {
                display: none;
            }

            .user-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .user-actions {
                justify-content: flex-start;
            }
        }
    </style>

@endsection