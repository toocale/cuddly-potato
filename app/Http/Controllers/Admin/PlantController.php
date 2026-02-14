<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->user()->isAdmin() && !$request->user()->hasPermission('assets.create')) {
            abort(403, 'Unauthorized to create assets.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        Plant::create($validated);

        return redirect()->back()->with('success', 'Plant created.');
    }

    public function update(Request $request, Plant $plant)
    {
        if (!$request->user()->isAdmin() && !$request->user()->hasPermission('assets.update')) {
            abort(403, 'Unauthorized to edit assets.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $plant->update($validated);

        return redirect()->back()->with('success', 'Plant updated.');
    }

    public function destroy(Request $request, Plant $plant)
    {
        if (!$request->user()->isAdmin() && !$request->user()->hasPermission('assets.delete')) {
            abort(403, 'Unauthorized to delete assets.');
        }

        $plant->delete();
        return redirect()->back()->with('success', 'Plant deleted.');
    }
}
