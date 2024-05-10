<?php

namespace App\Http\Controllers;

use App\Models\Pesticide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Criteria;

class PesticideController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        // $pesticides = Pesticide::with('criterias')->get();
        $pesticides = Pesticide::whereHas('criterias')->with('criterias')->get();

        Log::info('Pesticidesssss: ' . $request->user()->role);

        $response = [];
        foreach ($pesticides as $pesticide) {
            $response[] = [
                'id' => $pesticide->id,
                'name' => $pesticide->name,
                'criteria' => $pesticide->criterias->map(function ($criteria) {
                    return [
                        'id' => $criteria->id,
                        'name' => $criteria->name,
                        'description' => $criteria->pivot->description,
                    ];
                }),
            ];
        }
        if ($request->is('admin/pesticides')) {
            return view('pesticides.manage_pesticides', compact('response'));
        } else {
            return view('pesticides.index', compact('response'));
        }
    }

    public function show($id)
    {
        $pesticide = Pesticide::with('criteria')->find($id);
        if (!$pesticide) {
            return response()->json(['message' => 'Pesticide not found'], 404);
        }
        return response()->json($pesticide);
    }

    public function create()
    {
        $criteria = Criteria::all();
        return view('pesticides.create', compact('criteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'criterias.*.description' => 'required|string|max:255',
        ]);

        $pesticide = Pesticide::create($request->only('name'));

        foreach ($request->criterias as $criteria) {
            $criterion = Criteria::findOrFail($criteria['id']);
            $pesticide->criterias()->attach($criterion->id, ['description' => $criteria['description']]);
        }

        // return response()->json($pesticide, 201);
        return redirect()->route('pesticides.home')->with('success', 'Pesticide created successfully');
    }



    // public function update(Request $request, $id)
    // {
    //     $pesticide = Pesticide::find($id);
    //     if (!$pesticide) {
    //         return response()->json(['message' => 'Pesticide not found'], 404);
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'criteria_id' => 'required|exists:criterias,id',
    //     ]);

    //     $pesticide->update($request->all());

    //     return response()->json($pesticide, 200);
    // }

    // public function update(Request $request, $id)
    // {
    //     $pesticide = Pesticide::find($id);
    //     if (!$pesticide) {
    //         return response()->json(['message' => 'Pesticide not found'], 404);
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'criterias' => 'required|array',
    //         'criterias.*.id' => 'required|exists:criterias,id',
    //         'criterias.*.description' => 'required|string|max:255',
    //     ]);

    //     // Update nama pestisida
    //     $pesticide->update($request->only('name'));

    //     // Sync kriteria dengan deskripsi yang baru
    //     $updatedCriterias = [];
    //     foreach ($request->criterias as $criteria) {
    //         $updatedCriterias[$criteria['id']] = ['description' => $criteria['description']];
    //     }
    //     $pesticide->criterias()->sync($updatedCriterias);

    //     return response()->json($pesticide, 200);
    // }

    public function edit(Pesticide $pesticide)
    {
        $criteria = Criteria::all();
        return view('pesticides.edit', compact('pesticide', 'criteria'));
    }


    public function update(Request $request, Pesticide $pesticide)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'criterias.*.description' => 'required|string|max:255',
        ]);

        $pesticide->update($request->only('name'));

        foreach ($request->criterias as $criterionId => $criteria) {
            $pesticide->criterias()->updateExistingPivot($criterionId, ['description' => $criteria['description']]);
        }

        return redirect()->route('pesticides.home')->with('success', 'Pesticide updated successfully');
    }

    public function destroy($id)
    {
        $pesticide = Pesticide::find($id);
        if (!$pesticide) {
            return response()->json(['message' => 'Pesticide not found'], 404);
        }

        $pesticide->delete();

        return redirect()->route('pesticides.home')->with('success', 'Pesticide deleted successfully');
    }
}
