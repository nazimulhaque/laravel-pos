<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $units = new Unit();
        if ($request->search) {
            $units = $units->where('description', 'LIKE', "%{$request->search}%");
        }
        $units = $units->latest()->paginate(10);
        if (request()->wantsJson()) {
            return UnitResource::collection($units);
        }
        return view('unit.index')
            ->with('units', $units);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitStoreRequest $request)
    {
        $unit = Unit::create([
            'description' => $request->description,
        ]);

        if (!$unit) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the unit.');
        }
        return redirect()->route('unit.index')->with('success', 'Success, your unit has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return view('unit.edit')
            ->with('unit', $unit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UnitUpdateRequest $request, Unit $unit)
    {
        $unit->description = $request->description;

        if (!$unit->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating the unit.');
        }
        return redirect()->route('unit.index')->with('success', 'Success, your unit has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->json([
            'success' => true
        ]);
        // return redirect()->route('unit.index')->with('success', 'Success, your unit has been deleted.');
        // return back();
        // return redirect()->back()->with('success', 'Success, your unit has been deleted.');
        // return view('unit.index')->with('success', 'Success, your unit has been deleted.');
    }
}
