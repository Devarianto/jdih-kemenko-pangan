<?php

namespace App\Http\Controllers\ERegulasi;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin_operator,super_admin,masyarakat',
            'unit_kerja' => 'nullable|string|max:255',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'name' => $validated['name'],
            'display_name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'unit_kerja' => $validated['role'] === 'super_admin' ? null : $validated['unit_kerja'],
            'password' => Hash::make($validated['password']),
            'is_enable' => 'Yes',
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin_operator,super_admin,masyarakat',
            'unit_kerja' => 'nullable|string|max:255',
        ]);

        // Cegah menurunkan role super_admin terakhir, supaya sistem tidak kehilangan
        // semua akses approval.
        if ($user->role === 'super_admin' && $validated['role'] !== 'super_admin') {
            $jumlahSuperAdmin = User::where('role', 'super_admin')->count();
            if ($jumlahSuperAdmin <= 1) {
                return back()->with('error', 'Tidak bisa mengubah role: ini Super Admin terakhir di sistem.');
            }
        }

        $user->update([
            'name' => $validated['name'],
            'display_name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'unit_kerja' => $validated['role'] === 'super_admin' ? null : $validated['unit_kerja'],
        ]);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function showResetPassword(User $user)
    {
        return view('users.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('users.index')->with('success', "Password untuk {$user->name} berhasil direset.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        if ($user->role === 'super_admin') {
            $jumlahSuperAdmin = User::where('role', 'super_admin')->count();
            if ($jumlahSuperAdmin <= 1) {
                return back()->with('error', 'Tidak bisa menghapus: ini Super Admin terakhir di sistem.');
            }
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
