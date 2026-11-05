@extends('layouts.app')

@section('page-title', 'Edit User')

@section('content')

    <div style="max-width: 600px;">
        <h2 style="font-size: 20px; font-weight: 700; color: #333; margin-bottom: 24px; border-bottom: 2px solid #1a5c45; padding-bottom: 10px;">
            Edit User — {{ $user->name }}
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

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-group">
                    <label class="form-label">Nama *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori / Tipe User & Hak Akses *</label>
                    <select name="role" class="form-control" id="roleSelect" required>
                        <option value="admin_operator" {{ old('role', $user->role) == 'admin_operator' ? 'selected' : '' }}>
                            Operator e-Regulasi (Hanya Fitur e-Regulasi, Akses CMS JDIH Terbatas)
                        </option>
                        <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>
                            Super Admin (Akses Penuh CMS JDIH & e-Regulasi)
                        </option>
                        <option value="masyarakat" {{ old('role', $user->role) == 'masyarakat' ? 'selected' : '' }}>
                            User Masyarakat / Publik (Partisipasi PUU)
                        </option>
                    </select>
                    @if($user->role === 'super_admin')
                        <small style="color: #cc8800; font-size: 12px; display: block; margin-top: 4px;">⚠️ Jika ini Super Admin terakhir, perubahan role akan ditolak sistem.</small>
                    @else
                        <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">Operator e-Regulasi hanya memiliki akses pada modul penyusunan e-Regulasi.</small>
                    @endif
                </div>

                <div class="form-group" id="unitKerjaGroup">
                    <label class="form-label">Unit Kerja</label>
                    <input type="text" name="unit_kerja" class="form-control" value="{{ old('unit_kerja', $user->unit_kerja) }}"
                        placeholder="Contoh: Biro Hukum">
                    <small style="color: #888; font-size: 12px;">Wajib untuk Admin/Operator. Tidak berlaku untuk Super Admin.</small>
                </div>

                <div style="text-align: right;">
                    <a href="{{ route('users.index') }}" class="btn" style="margin-right: 8px;">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const roleSelect = document.getElementById('roleSelect');
        const unitKerjaGroup = document.getElementById('unitKerjaGroup');

        function toggleUnitKerja() {
            unitKerjaGroup.style.display = roleSelect.value === 'super_admin' ? 'none' : 'block';
        }
        roleSelect.addEventListener('change', toggleUnitKerja);
        toggleUnitKerja();
    </script>

@endsection
