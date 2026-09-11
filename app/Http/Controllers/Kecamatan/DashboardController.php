<?php

namespace App\Http\Controllers\Kecamatan;

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
        return view('kecamatan.dashboard', ['stats' => ['Menunggu pemeriksaan' => 0, 'Dikembalikan' => 0, 'Lolos ke Kesra' => 0, 'Kelurahan aktif' => 0]]);
    }
}
