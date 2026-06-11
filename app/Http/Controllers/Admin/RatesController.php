<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Facility;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('sort_order')->get();
        $activities = Activity::orderBy('sort_order')->get();
        return view('admin.rates.index', compact('facilities', 'activities'));
    }

    public function updateFacility(Request $request, Facility $facility)
    {
        $request->validate([
            'rate'        => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'is_active'   => 'nullable|boolean',
        ]);

        $facility->update([
            'rate'        => $request->rate,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success', "Rate for '{$facility->name}' updated.");
    }

    public function updateActivity(Request $request, Activity $activity)
    {
        $request->validate([
            'cost_per_person' => 'required|numeric|min:0',
            'description'     => 'nullable|string|max:500',
            'is_active'       => 'nullable|boolean',
        ]);

        $activity->update([
            'cost_per_person' => $request->cost_per_person,
            'description'     => $request->description,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return back()->with('success', "Rate for '{$activity->name}' updated.");
    }
}
