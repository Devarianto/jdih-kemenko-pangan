<?php

namespace App\Http\Controllers\Admin\ERegulasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ERegulasiBridgeController extends Controller
{
    public function getIndex()
    {
        $currentUri = request()->path();

        if (strpos($currentUri, 'eregulasi-dashboard') !== false) {
            return redirect()->route('dashboard');
        } elseif (strpos($currentUri, 'eregulasi-penyusunan') !== false) {
            return redirect()->route('regulasi.index');
        } elseif (strpos($currentUri, 'eregulasi-pengajuan') !== false) {
            return redirect()->route('regulasi.create');
        } elseif (strpos($currentUri, 'eregulasi-partisipasi') !== false) {
            return redirect()->route('admin.partisipasi.index');
        } elseif (strpos($currentUri, 'eregulasi-user') !== false) {
            return redirect()->route('users.index');
        }

        return redirect()->route('dashboard');
    }
}

