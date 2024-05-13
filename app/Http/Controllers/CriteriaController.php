<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Pesticide;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCriteriaRequest;
use App\Http\Requests\UpdateCriteriaRequest;
use Illuminate\Support\Facades\Log;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::all();
        // return response()->json($criteria);
        if (request()->is('admin/criteria')) {
            Log::info('admin');
            return view('criteria.index', compact('criteria'));
        } else {
            Log::info('user');
            return view('criteria.manage_criteria', compact('criteria'));
        }
    }

    public function show($id)
    {
        $criteria = Criteria::find($id);
        if (!$criteria) {
            return response()->json(['message' => 'Criteria not found'], 404);
        }
        return response()->json($criteria);
    }

    public function edit($id)
    {
        $criterion = Criteria::find($id);
        if (!$criterion) {
            return response()->json(['message' => 'Criteria not found'], 404);
        }
        return view('criteria.edit', compact('criterion'));
    }

    public function create()
    {
        return view('criteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kind' => 'required|string|max:255',
        ]);

        $criteria = Criteria::create($request->all());

        // Get all pesticides
        $pesticides = Pesticide::all();

        // Attach the newly created criteria to all pesticides with default value null
        foreach ($pesticides as $pesticide) {
            $pesticide->criterias()->attach($criteria, ['description' => '']);
        }

        return redirect()->route('criteria.index')->with('success', 'Criteria created successfully');
    }


    public function update(Request $request, $id)
    {
        $criteria = Criteria::find($id);
        if (!$criteria) {
            return response()->json(['message' => 'Criteria not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'kind' => 'required|string|max:255',
        ]);

        $criteria->update($request->all());

        return redirect()->route('criteria.index')->with('success', 'Criteria updated successfully');
    }

    public function destroy($id)
    {
        $criteria = Criteria::find($id);
        if (!$criteria) {
            return response()->json(['message' => 'Criteria not found'], 404);
        }

        $criteria->delete();

        // return response()->json(['message' => 'Criteria deleted successfully'], 200);
        return redirect()->route('criteria.index')->with('success', 'Criteria deleted successfully');
    }
}
