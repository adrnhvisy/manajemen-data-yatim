<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kelurahan\StoreChildRecordRequest;
use App\Http\Requests\Kelurahan\UpdateChildRecordRequest;
use App\Models\ChildRecord;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChildRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('kelurahan.children.index', ['children' => ChildRecord::latest()->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('kelurahan.children.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildRecordRequest $request)
    {
        $record = ChildRecord::create($request->validated() + ['submission_number' => 'DRAFT-'.now()->format('YmdHis'), 'created_by' => 1, 'office_id' => $request->input('office_id')]);
        return to_route('kelurahan.anak.show', $record);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildRecord $childRecord): View
    {
        return view('kelurahan.children.show', compact('childRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildRecord $childRecord): View
    {
        return view('kelurahan.children.edit', compact('childRecord'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildRecordRequest $request, ChildRecord $childRecord)
    {
        $childRecord->update($request->validated());
        return to_route('kelurahan.anak.show', $childRecord);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildRecord $childRecord)
    {
        $childRecord->delete();
        return to_route('kelurahan.anak.index');
    }
}
