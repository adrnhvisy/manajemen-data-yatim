<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ReviewController extends Controller
{
    //
    public function index(): View
    {
        return view('kecamatan.reviews.index', ['children' => collect()]);
    }

    public function show(string $childRecord): View
    {
        return view('kecamatan.reviews.show', ['childRecord' => null]);
    }

    public function return(string $childRecord)
    {
        return back()->with('status', 'Data dikembalikan untuk perbaikan.');
    }

    public function forward(string $childRecord)
    {
        return back()->with('status', 'Data diteruskan ke Kesra.');
    }
}
