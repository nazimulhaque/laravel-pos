<?php

namespace App\Http\Controllers;

use App\Http\Resources\PrinterGroupResource;
use App\Models\PrinterGroup;
use Illuminate\Http\Request;
use App\Http\Requests\PrinterGroupStoreRequest;
use App\Http\Requests\PrinterGroupUpdateRequest;

class PrinterGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $printer_groups = new PrinterGroup();
        if ($request->search) {
            $printer_groups = $printer_groups->where('description', 'LIKE', "%{$request->search}%");
        }
        $printer_groups = $printer_groups->latest()->paginate(10);
        if (request()->wantsJson()) {
            return PrinterGroupResource::collection($printer_groups);
        }
        return view('printer_group.index')
            ->with('printer_groups', $printer_groups);
    }

    /**
     * Search result.
     */
    public function search(Request $request)
    {
        $printer_groups = new PrinterGroup();
        if ($request->filled('search')) {
            $printer_groups = $printer_groups->where('description', 'LIKE', "%{$request->search}%")->orderBy('description')->paginate(10);
        }
        return view('printer_group.index')
            ->with('printer_groups', $printer_groups)
            ->with('search', $request->search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('printer_group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrinterGroupStoreRequest $request)
    {
        $printer_group = PrinterGroup::create([
            'type' => $request->type,
            'description' => $request->description,
            'client_print_order' => $request->client_print_order
        ]);

        if (!$printer_group) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the Printer Group.');
        }
        return redirect()->route('printer_group.index')->with('success', 'Success, your Printer Group has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrinterGroup  $printer_group
     * @return \Illuminate\Http\Response
     */
    public function show(PrinterGroup $printer_group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrinterGroup  $printer_group
     * @return \Illuminate\Http\Response
     */
    public function edit(PrinterGroup $printer_group)
    {
        return view('printer_group.edit')
            ->with('printer_group', $printer_group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrinterGroup  $printer_group
     * @return \Illuminate\Http\Response
     */
    public function update(PrinterGroupUpdateRequest $request, PrinterGroup $printer_group)
    {
        $printer_group->description = $request->description;

        if (!$printer_group->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating the Printer Group.');
        }
        return redirect()->route('printer_group.index')->with('success', 'Success, your Printer Group has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrinterGroup  $printer_group
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrinterGroup $printer_group)
    {
        $printer_group->delete();
        return response()->json([
            'success' => true
        ]);
        // return redirect()->route('printer_group.index')->with('success', 'Success, your Printer Group has been deleted.');
        // return back();
        // return redirect()->back()->with('success', 'Success, your Printer Group has been deleted.');
        // return view('printer_group.index')->with('success', 'Success, your Printer Group has been deleted.');
    }
}
