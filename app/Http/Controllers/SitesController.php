<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class SitesController extends Controller
{
    public function index()
    {
        return view('backoffice.site.index');
    }

    public function edit()
    {
        return view('backoffice.site.form');
    }

    public function update(Request $request)
    {
        $dataUpdated = [
            'name_application' => $request->name,
            'phone' => $request->phone
        ];

        if ($request->hasFile('logo')) {
            $dataUpdated['logo'] = $request->file('logo')->store('site', 'public');
        }
        if ($request->hasFile('favicon')) {
            $dataUpdated['favicon'] = $request->file('favicon')->store('site', 'public');
        }

        $result = Site::where('id', 1)->update($dataUpdated);

        return response()->json($result);
    }
}
