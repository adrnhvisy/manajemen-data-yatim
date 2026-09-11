<?php

namespace App\Http\Controllers\Kesra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('kesra.dashboard', ['stats' => ['Menunggu verifikasi' => 0, 'Disetujui' => 0, 'Ditolak' => 0, 'Kecamatan terhubung' => 0]]);
    }
}
