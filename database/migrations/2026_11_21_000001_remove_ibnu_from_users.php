<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Hapus nama "Ibnu" dari kolom name/display_name pada seluruh akun admin/operator.
     */
    public function up(): void
    {
        $users = DB::table('users')
            ->where(function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%ibnu%'])
                    ->orWhereRaw('LOWER(display_name) LIKE ?', ['%ibnu%']);
            })
            ->get(['id', 'name', 'display_name', 'role', 'unit_kerja']);

        foreach ($users as $u) {
            $fallback = $u->role === 'super_admin'
                ? 'Super Admin'
                : ($u->unit_kerja ? 'Operator ' . $u->unit_kerja : 'Operator e-Regulasi');

            $newName = (!$u->name || stripos($u->name, 'ibnu') !== false) ? $fallback : $u->name;
            $newDisplay = (!$u->display_name || stripos($u->display_name, 'ibnu') !== false) ? $newName : $u->display_name;

            DB::table('users')->where('id', $u->id)->update([
                'name' => $newName,
                'display_name' => $newDisplay,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak mengembalikan nama personal yang telah dihapus.
    }
};
