<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Requests\LocationStoreRequest;
// use App\Http\Requests\LocationUpdateRequest;

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
        $locations = $locations->latest()->paginate(10);
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
            'location_name' => $request->location_name
        ]);

        if (!$location) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the location.');
        }
        return redirect()->route('location.index')->with('success', 'Success, your location has been created.');
    }
}
