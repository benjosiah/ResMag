<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter??'';
        if ($request->has('filter') && $filter !== '') {
            $resources=Resource::where('type', $request->filter)->get();
        }else {
            $resources=Resource::all();
        }
        return view('welcome', [
            'resources' => $resources,
            'filter'=> $filter
        ]);
    }

    public function admin(Request $request)
    {
        $filter = $request->filter??'';
        if ($request->has('filter') && $filter !== '') {
            $resources=Resource::where('type', $request->filter)->get();
        }else {
            $resources=Resource::all();
        }
        return Inertia::render('Dashboard', [
            'resources' => $resources,
            'filter'=> $filter
        ]);
    }
}
