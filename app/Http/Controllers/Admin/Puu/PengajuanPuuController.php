<?php

namespace App\Http\Controllers\Admin\Puu;

use App\Http\Controllers\Controller;

class PengajuanPuuController extends Controller
{
    public function getIndex()
    {
        return redirect()->route('regulasi.index');
    }
}

