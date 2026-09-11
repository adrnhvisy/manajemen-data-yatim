<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('kecamatan.reports.index', ['title' => 'Laporan Kecamatan', 'scope' => 'Seluruh kelurahan dalam kecamatan']);
    }

    public function print(Request $request): View
    {
        return view('layouts.print', ['title' => 'Laporan Kecamatan', 'scope' => 'Seluruh kelurahan dalam kecamatan']);
    }
}
