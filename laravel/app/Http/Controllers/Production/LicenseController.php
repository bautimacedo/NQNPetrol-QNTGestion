<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $licenses = License::with('pilot')
            ->orderByDesc('expiration_date')
            ->get();

        return view('production.licenses.index', compact('licenses'));
    }
}

