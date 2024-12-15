<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        return view('backoffice.banner.index');
    }

    public function show()
    {
        return response()->json(Banner::orderBy('order', 'asc')->get(['id', 'patch', 'order']));
    }

    public function store(Request $request)
    {

        $lastPosition = Banner::orderBy('order', 'desc')->value('order');
        $lastPosition = ($lastPosition !== null) ? $lastPosition + 1 : 1;

        Banner::create([
            'patch' => $request->file('file')->store('banner', 'public'),
            'order' => $lastPosition,
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            Banner::where('id', $value['id'])->update(['order' => $value['order']]);
        }
    }

    public function destroy(Banner $banner)
    {
        $patchFile = $banner->patch;
        $banner->delete();
        if ($patchFile) Storage::disk('public')->delete($patchFile);

        return to_route('backoffice.banner.index')->with('success', 'Banner deleted successfully');
    }

    public function destroyAll()
    {
        foreach (Banner::all() as $banner) {
            $patchFile = $banner->patch;
            $banner->delete();
            if ($patchFile) Storage::disk('public')->delete($patchFile);
        }

        return to_route('backoffice.banner.index')->with('success', 'Banners delete successfully');
    }
}
