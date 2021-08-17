<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationTableDetails;
use App\Http\Resources\LocationTableDetailsResource;
use App\Http\Requests\LocationTableDetailsStoreRequest;
// use App\Http\Requests\LocationTableDetailsUpdateRequest;

use Illuminate\Http\Request;

class LocationTableDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $location_table_details = new LocationTableDetails();
        if ($request->search) {
            $location_table_details = $location_table_details->where('area', 'LIKE', "%{$request->search}%");
        }
        // $location_table_details = $location_table_details->latest()->paginate(10);
        $location_table_details = $location_table_details->orderBy('location_id')->orderBy('start_number')->paginate(10);
        $location_list = Location::select('location_id', 'location_name', 'number_of_tables')->orderBy('location_name')->get();
        if (request()->wantsJson()) {
            return LocationTableDetailsResource::collection($location_table_details);
        }
        return view('location_table_details.index')
            ->with('location_table_details', $location_table_details)
            ->with(compact('location_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location_list = Location::select('location_id', 'location_name', 'number_of_tables')->orderBy('location_name')->get();
        $location_table_details = LocationTableDetails::select('location_table_detail_id', 'location_id', 'start_number', 'end_number', 'area')->orderBy('start_number')->get();
        return view('location_table_details.create')
            ->with(compact('location_list'))
            ->with(compact('location_table_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationTableDetailsStoreRequest $request)
    {
        $location_table_details = LocationTableDetails::create([
            'location_id' => $request->location_id,
            'area' => $request->area,
            'start_number' => $request->start_number,
            'end_number' => $request->end_number,
        ]);

        if (!$location_table_details) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while adding location table details.');
        }

        if ($request->from_route == 'location') {
            $location = Location::select('location_id', 'location_name', 'number_of_tables')->where('location_id', $request->location_id)->get();
            $location_list = Location::select('location_id', 'location_name', 'number_of_tables')->orderBy('location_name')->get();
            $location_table_details = LocationTableDetails::select('location_table_detail_id', 'location_id', 'start_number', 'end_number', 'area')->orderBy('start_number')->get();
            return view('location.show')
                ->with('success', 'Success, location table details has been added.')
                ->with('location', $location)
                ->with(compact('location_list'))
                ->with(compact('location_table_details'));
        }

        return redirect()->route('location_table_details.index')->with('success', 'Success, location table details has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LocationTableDetails  $department
     * @return \Illuminate\Http\Response
     */
    public function show(LocationTableDetails $location_table_details)
    {
        //
    }
}
