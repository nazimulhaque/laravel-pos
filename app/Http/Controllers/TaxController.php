<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaxResource;
use App\Models\Tax;
use Illuminate\Http\Request;
use App\Http\Requests\TaxStoreRequest;
use App\Http\Requests\TaxUpdateRequest;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $taxes = new Tax();
        if ($request->search) {
            $taxes = $taxes->where('description', 'LIKE', "%{$request->search}%");
        }
        $taxes = $taxes->latest()->paginate(10);
        if (request()->wantsJson()) {
            return TaxResource::collection($taxes);
        }
        return view('tax.index')
            ->with('taxes', $taxes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tax.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxStoreRequest $request)
    {
        $tax = Tax::create([
            'description' => $request->description,
            'rate' => $request->rate,
        ]);

        if (!$tax) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the tax.');
        }
        return redirect()->route('tax.index')->with('success', 'Success, your tax has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        return view('tax.edit')
            ->with('tax', $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(TaxUpdateRequest $request, Tax $tax)
    {
        $tax->description = $request->description;
        $tax->rate = $request->rate;

        if (!$tax->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating the tax.');
        }
        return redirect()->route('tax.index')->with('success', 'Success, your tax has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();
        return response()->json([
            'success' => true
        ]);
        // return redirect()->route('tax.index')->with('success', 'Success, your tax has been deleted.');
        // return back();
        // return redirect()->back()->with('success', 'Success, your tax has been deleted.');
        // return view('tax.index')->with('success', 'Success, your tax has been deleted.');
    }
}
