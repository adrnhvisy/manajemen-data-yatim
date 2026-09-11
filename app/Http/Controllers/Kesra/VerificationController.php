<?php

namespace App\Http\Controllers\Kesra;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class VerificationController extends Controller
{
    //
    public function index(): View
    {
        return view('kesra.verifications.index', ['children' => collect()]);
    }

    public function show(string $childRecord): View
    {
        return view('kesra.verifications.show', ['childRecord' => null]);
    }

    public function approve(string $childRecord)
    {
        return back()->with('status', 'Data disetujui.');
    }

    public function reject(string $childRecord)
    {
        return back()->with('status', 'Data ditolak dengan catatan.');
    }
}
