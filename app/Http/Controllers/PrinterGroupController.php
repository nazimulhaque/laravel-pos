<?php

namespace App\Http\Controllers;

// use App\Http\Requests\PrinterGroupStoreRequest;
// use App\Http\Requests\PrinterGroupUpdateRequest;
use App\Http\Resources\PrinterGroupResource;
use App\Models\PrinterGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PrinterGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $printerGroups = new PrinterGroup();
        if ($request->search) {
            $printerGroups = $printerGroups->where('description', 'LIKE', "%{$request->search}%");
        }
        $printerGroups = $printerGroups->latest()->paginate(10);
        if (request()->wantsJson()) {
            return PrinterGroupResource::collection($printerGroups);
        }
        return view('printer_group.index')
            ->with('printerGroups', $printerGroups);
    }
}
