<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCriteriaRequest;
use App\Http\Requests\UpdateCriteriaRequest;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::all();
        // return response()->json($criteria);
        if (request()->is('criteria')) {
            return view('criteria.index', compact('criteria'));
        } else {
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

        // return response()->json($criteria, 201);
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
