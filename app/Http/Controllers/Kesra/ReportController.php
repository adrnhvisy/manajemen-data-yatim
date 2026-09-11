<?php

namespace App\Http\Controllers\Kesra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('kesra.reports.index', ['title' => 'Laporan Kesra', 'scope' => 'Lintas kecamatan dan kelurahan']);
    }

    public function print(Request $request): View
    {
        return view('layouts.print', ['title' => 'Laporan Kesra', 'scope' => 'Lintas kecamatan dan kelurahan']);
    }
}
