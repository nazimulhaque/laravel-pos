<?php

namespace App\Http\Controllers;

use App\Http\Resources\PriceLevelResource;
use App\Models\PriceLevel;
use Illuminate\Http\Request;
use App\Http\Requests\PriceLevelStoreRequest;
use App\Http\Requests\PriceLevelUpdateRequest;

class PriceLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $price_levels = new PriceLevel();
        if ($request->search) {
            $price_levels = $price_levels->where('description', 'LIKE', "%{$request->search}%");
        }
        $price_levels = $price_levels->latest()->paginate(10);
        if (request()->wantsJson()) {
            return PriceLevelResource::collection($price_levels);
        }
        return view('price_level.index')
            ->with('price_levels', $price_levels);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('price_level.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PriceLevelStoreRequest $request)
    {
        $price_level = PriceLevel::create([
            'description' => $request->description,
        ]);

        if (!$price_level) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the Price Level.');
        }
        return redirect()->route('price_level.index')->with('success', 'Success, your Price Level has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PriceLevel  $price_level
     * @return \Illuminate\Http\Response
     */
    public function show(PriceLevel $price_level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceLevel  $price_level
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceLevel $price_level)
    {
        return view('price_level.edit')
            ->with('price_level', $price_level);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PriceLevel  $price_level
     * @return \Illuminate\Http\Response
     */
    public function update(PriceLevelUpdateRequest $request, PriceLevel $price_level)
    {
        $price_level->description = $request->description;

        if (!$price_level->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating the Price Level.');
        }
        return redirect()->route('price_level.index')->with('success', 'Success, your Price Level has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceLevel  $price_level
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceLevel $price_level)
    {
        $price_level->delete();
        return response()->json([
            'success' => true
        ]);
        // return redirect()->route('price_level.index')->with('success', 'Success, your Price Level has been deleted.');
        // return back();
        // return redirect()->back()->with('success', 'Success, your Price Level has been deleted.');
        // return view('price_level.index')->with('success', 'Success, your Price Level has been deleted.');
    }
}
