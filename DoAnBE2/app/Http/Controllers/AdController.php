<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::latest()->paginate(10);
        return view('admin.ad.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ad.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'media_type' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm|max:20480',
            'link_url' => 'nullable|required|url',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('media_type')) {
            $validated['media_type'] = $request->file('media_type')->store('ads', 'public');
        };

        $validated['is_active'] = $request->has('is_active');

        Ad::create($validated);

        return redirect()->route('admin.ad.index')->with('success', 'Quảng cáo đã được tạo thành công');
    }

    public function edit(Ad $ad)
    {
        return view('admin.ad.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'media_type' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm|max:20480',
            'link_url' => 'nullable|required|url',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('media_type')) {
            if ($ad->media_type && Storage::disk('public')->exists($ad->media_type)) {
                Storage::disk('public')->delete($ad->media_type);
            }

            $validated['media_type'] = $request->file('media_type')->store('ads', 'public');
        };

        $validated['is_active'] = $request->has('is_active');

        $ad->update($validated);

        return redirect()->route('admin.ad.index');
    }

    public function destroy(Ad $ad)
    {
        if ($ad->media_type && Storage::disk('public')->exists($ad->media_type)) {
            Storage::disk('public')->delete($ad->media_type);
        }
        $ad->delete();
        return redirect()->route('admin.ad.index');
    }
}
