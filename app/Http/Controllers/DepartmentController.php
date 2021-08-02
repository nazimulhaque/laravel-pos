<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = new Department();
        if ($request->search) {
            $departments = $departments->where('department_name', 'LIKE', "%{$request->search}%");
        }
        $departments = $departments->latest()->paginate(10);
        $departmentList = Department::select('department_id', 'parent_department_id', 'department_name')->get();
        if (request()->wantsJson()) {
            return DepartmentResource::collection($departments);
        }
        return view('department.index')
            ->with('departments', $departments)
            ->with(compact('departmentList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departmentList = Department::select('department_id', 'parent_department_id', 'department_name')->get();
        // return $departmentList;
        return view('department.create')
            ->with(compact('departmentList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreRequest $request)
    {
        $department = Department::create([
            'department_name' => $request->department_name,
            'parent_department_id' => $request->parent_department_id,
            'description' => $request->description,
            // 'created_by' => Auth::user()->email
        ]);

        if (!$department) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating the department.');
        }
        return redirect()->route('department.index')->with('success', 'Success, your department has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $departmentList = Department::select('department_id', 'parent_department_id', 'department_name')->get();
        return view('department.edit')
            ->with('department', $department)
            ->with(compact('departmentList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $department->department_name = $request->department_name;
        $department->parent_department_id = $request->parent_department_id;
        $department->description = $request->description;

        if (!$department->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating department.');
        }
        return redirect()->route('department.index')->with('success', 'Success, your department has been updated.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'success' => true
        ]);
        // return redirect()->route('department.index')->with('success', 'Success, your department has been deleted.');
        // return back();
        // return redirect()->back()->with('success', 'Success, your department has been deleted.');
        // return view('department.index')->with('success', 'Success, your department has been deleted.');
    }
}
