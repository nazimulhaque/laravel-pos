<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModifiersCategoryResource;
use App\Models\ModifiersCategory;
use Illuminate\Http\Request;
use App\Http\Requests\ModifiersCategoryStoreRequest;
use App\Http\Requests\ModifiersCategoryUpdateRequest;

class ModifiersCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modifiers_categories = new ModifiersCategory();
        if ($request->search) {
            $modifiers_categories = $modifiers_categories->where('description', 'LIKE', "%{$request->search}%");
        }
        $modifiers_categories = $modifiers_categories->latest()->paginate(10);
        if (request()->wantsJson()) {
            return ModifiersCategoryResource::collection($modifiers_categories);
        }
        return view('modifiers_category.index')
            ->with('modifiers_categories', $modifiers_categories);
    }

    /**
     * Search result.
     */
    public function search(Request $request)
    {
        $modifiers_categories = new ModifiersCategory();
        if ($request->filled('search')) {
            $modifiers_categories = $modifiers_categories->where('description', 'LIKE', "%{$request->search}%")->orderBy('description')->paginate(10);
        }
        return view('modifiers_category.index')
            ->with('modifiers_categories', $modifiers_categories)
            ->with('search', $request->search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modifiers_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModifiersCategoryStoreRequest $request)
    {
        $modifiers_category = ModifiersCategory::create([
            'description' => $request->description,
        ]);

        if (!$modifiers_category) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the Modifiers Category.');
        }
        return redirect()->route('modifiers_category.index')->with('success', 'Success, your Modifiers Category has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModifiersCategory  $modifiers_category
     * @return \Illuminate\Http\Response
     */
    public function show(ModifiersCategory $modifiers_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModifiersCategory  $modifiers_category
     * @return \Illuminate\Http\Response
     */
    public function edit(ModifiersCategory $modifiers_category)
    {
        return view('modifiers_category.edit')
            ->with('modifiers_category', $modifiers_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModifiersCategory  $modifiers_category
     * @return \Illuminate\Http\Response
     */
    public function update(ModifiersCategoryUpdateRequest $request, ModifiersCategory $modifiers_category)
    {
        $modifiers_category->description = $request->description;

        if (!$modifiers_category->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating the Modifiers Category.');
        }
        return redirect()->route('modifiers_category.index')->with('success', 'Success, your Modifiers Category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModifiersCategory  $modifiers_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModifiersCategory $modifiers_category)
    {
        $modifiers_category->delete();
        return response()->json([
            'success' => true
        ]);
        // return redirect()->route('modifiers_category.index')->with('success', 'Success, your modifiers_category has been deleted.');
        // return back();
        // return redirect()->back()->with('success', 'Success, your modifiers_category has been deleted.');
        // return view('modifiers_category.index')->with('success', 'Success, your modifiers_category has been deleted.');
    }
}
