<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('kelurahan.reports.index', ['title' => 'Laporan Kelurahan', 'scope' => 'Kelurahan Anda']);
    }

    public function print(Request $request): View
    {
        return view('layouts.print', ['title' => 'Laporan Kelurahan', 'scope' => 'Kelurahan Anda']);
    }
}
