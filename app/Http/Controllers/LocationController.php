<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Models\LocationTableDetails;
use Illuminate\Http\Request;
use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = new Location();
        if ($request->search) {
            $locations = $locations->where('location_name', 'LIKE', "%{$request->search}%");
        }
        // $locations = $locations->latest()->paginate(10);
        $locations = $locations->orderBy('location_name')->paginate(10);
        if (request()->wantsJson()) {
            return LocationResource::collection($locations);
        }
        return view('location.index')
            ->with('locations', $locations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        $location = Location::create([
            'location_name' => $request->location_name,
            'number_of_tables' => $request->number_of_tables
        ]);

        if (!$location) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the location.');
        }
        return redirect()->route('location.index')->with('success', 'Success, your location has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $location_list = Location::select('location_id', 'location_name', 'number_of_tables')->orderBy('location_name')->get();
        $location_table_details = LocationTableDetails::select('location_table_detail_id', 'location_id', 'start_number', 'end_number', 'area')->orderBy('start_number')->get();
        return view('location.show')
            ->with('location', $location)
            ->with(compact('location_list'))
            ->with(compact('location_table_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('location.edit')
            ->with('location', $location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(LocationUpdateRequest $request, Location $location)
    {
        $location->location_name = $request->location_name;
        $location->number_of_tables = $request->number_of_tables;

        if (!$location->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating the location.');
        }
        return redirect()->route('location.index')->with('success', 'Success, the location has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return response()->json([
            'success' => true
        ]);
        // return redirect()->route('location.index')->with('success', 'Success, your location has been deleted.');
        // return back();
        // return redirect()->back()->with('success', 'Success, your location has been deleted.');
        // return view('location.index')->with('success', 'Success, your location has been deleted.');
    }
}
