<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\Well;
use Illuminate\Http\Request;

class WellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wells = Well::with('drone')->orderBy('name')->get();
        return view('production.wells.index', compact('wells'));
    }
}

