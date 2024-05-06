<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComparisonMatrix;
use App\Models\Pesticide;
use Illuminate\Support\Facades\DB;
use App\Models\Criteria;
use Illuminate\Support\Facades\Log;

class AlternatifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show($group_id)
    {
        $comparisonMatrix = ComparisonMatrix::where('group_id', $group_id)->first();
        $criteriaNames = json_decode($comparisonMatrix->criteria_name);
        $comparisonData = json_decode($comparisonMatrix->comparison_data);
        Log::info($comparisonData);
        Log::info($criteriaNames);
        // dd($comparisonData, $criteriaNames);

        // Ubah format data agar sesuai dengan yang diharapkan oleh calculateConsistency
        $criteriaMatrix = $this->buildShowCriteriaMatrix($comparisonData, $criteriaNames);
        $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);
        // dd($consistency);
        return view('ShowComparison', $consistency);
    }

    public function index($index)
    {
        $criteriaNames = Criteria::all(['id', 'name']);
        if ($index <= count($criteriaNames) - 1) {
            $firstCriteriaName = $criteriaNames[$index]->name;
        }
        $alternatives = Pesticide::all();
        $index = intval($index);
        if ($index === count($criteriaNames)) {
            Log::info('Criteria sssNames: ' .  count($criteriaNames) . "Index: " . $index);
            return redirect()->route('pesticides.home')->with('success', 'All criteria have been compared');
        }
        // Log::info('Criteria Names: ' .  count($criteriaNames) . "Index: " . $index);
        return view('home', compact('criteriaNames', 'alternatives', 'firstCriteriaName', 'index'));
    }


    public function storeComparisonAlternatif(Request $request, $index)
    {
        $comparisonData = $request->comparison;
        $criteriaNames = Pesticide::all()->pluck('name');
        $criteriaMatrix = $this->buildCriteriaMatrix($comparisonData, $criteriaNames);
        $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);
        $nextIndex = $index + 1;
        DB::transaction((function () use ($criteriaNames, $criteriaMatrix, $consistency) {
            $group_id = ComparisonMatrix::max('group_id');
            ComparisonMatrix::create([
                'criteria_name' => json_encode($criteriaNames),
                'comparison_data' => json_encode($criteriaMatrix),
                'eigenvector' => json_encode($consistency['normalizedVector']),
                'group_id' => $group_id,
            ]);
        }));

        return view('comparison', $consistency, compact('nextIndex'));
    }

    protected function buildCriteriaMatrix($comparisonData, $criteriaNames)
    {
        $criteriaMatrix = [];
        for ($i = 0; $i <= count($comparisonData); $i++) {
            $row = [];
            for ($j = 0; $j <= count($comparisonData); $j++) {
                if ($i == $j) {
                    $row[] = 1;
                } else {
                    $row[] = null;
                }
            }
            $criteriaMatrix[] = $row;
        }

        foreach ($comparisonData as $outerIndex => $row) {
            foreach ($row as $innerIndex => $value) {
                $criteriaMatrix[$outerIndex][$innerIndex] = $value;
                $criteriaMatrix[$innerIndex][$outerIndex] = 1 / $value;
            }
        }

        return $criteriaMatrix;
    }

    protected function calculateConsistency($criteriaMatrix, $criteriaNames)
    {
        $consistency = [];
        $consistency['criteriaMatrix'] = $criteriaMatrix;
        $consistency['criteriaNames'] = $criteriaNames;
        $consistency['columnSums'] = array_map('array_sum', array_map(null, ...$criteriaMatrix));

        $squaredMatrix = $this->calculateSquaredMatrix($criteriaMatrix);
        $consistency['squaredMatrix'] = $squaredMatrix;


        $normalizedVector = $this->calculateNormalizedVector($squaredMatrix);
        $consistency['normalizedVector'] = $normalizedVector;

        $totalEigenvector = array_sum($normalizedVector);
        $CI = $this->calculateCI($totalEigenvector, $criteriaMatrix);
        $CR = $this->calculateCR($CI, $criteriaMatrix);

        $consistency['totalEigenvector'] = $totalEigenvector;
        $consistency['CI'] = $CI;
        $consistency['CR'] = $CR;

        return $consistency;
    }

    protected function calculateSquaredMatrix($criteriaMatrix)
    {
        $squaredMatrix = [];
        foreach ($criteriaMatrix as $i => $row) {
            foreach ($row as $j => $value) {
                $sum = 0;
                for ($k = 0; $k < count($row); $k++) {
                    $sum += $criteriaMatrix[$i][$k] * $criteriaMatrix[$k][$j];
                }
                $squaredMatrix[$i][$j] = $sum;
            }
        }
        return $squaredMatrix;
    }
    protected function calculateNormalizedVector($squaredMatrix)
    {
        $rowSums = array_map('array_sum', $squaredMatrix);
        $totalRowSum = array_sum($rowSums);
        return array_map(function ($rowSum) use ($totalRowSum) {
            return $rowSum / $totalRowSum;
        }, $rowSums);
    }

    protected function calculateCI($totalEigenvector, $criteriaMatrix)
    {
        $n = count($criteriaMatrix);
        return ($totalEigenvector - $n) / ($n - 1);
    }

    protected function calculateCR($CI, $criteriaMatrix)
    {
        $IR = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
        $n = count($criteriaMatrix);
        // Periksa apakah indeks $n berada dalam rentang yang valid
        if ($n >= 0 && $n < count($IR)) {
            return $CI / $IR[$n];
        } else {
            // Handle jika indeks di luar rentang
            return 0; // Atau lakukan tindakan lain sesuai kebutuhan aplikasi Anda
        }
    }
}
