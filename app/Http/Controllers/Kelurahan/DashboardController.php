<?php

namespace App\Http\Controllers\Kelurahan;

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
        return view('kelurahan.dashboard', ['stats' => ['Total data' => 0, 'Draf' => 0, 'Menunggu kecamatan' => 0, 'Perlu perbaikan' => 0]]);
    }
}
