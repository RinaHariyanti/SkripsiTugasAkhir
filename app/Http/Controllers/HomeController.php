<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\ComparisonMatrix;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $criteriaNames = Criteria::all()->pluck('name');
        $comparison = [];

        return view('home', compact('criteriaNames', 'comparison'));
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


    public function storeComparison(Request $request)
    {
        $comparisonData = $request->comparison;
        $criteriaNames = Criteria::all()->pluck('name');
        $criteriaMatrix = $this->buildCriteriaMatrix($comparisonData, $criteriaNames);
        $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);
        $cacheKey = 'comparison_criteria_data_temp';

        $group_id = ComparisonMatrix::max('group_id') + 1;
        Cache::put($cacheKey, [
            'criteria_name' => $criteriaNames,
            'comparison_data' => $criteriaMatrix,
            'eigenvector' => $consistency['normalizedVector'],
            'group_id' => $group_id,
        ], now()->addHours(1));

        // DB::transaction((function () use ($criteriaNames, $criteriaMatrix, $consistency) {
        //     $group_id = ComparisonMatrix::max('group_id') + 1;
        //     ComparisonMatrix::create([
        //         'criteria_name' => json_encode($criteriaNames),
        //         'comparison_data' => json_encode($criteriaMatrix),
        //         'eigenvector' => json_encode($consistency['normalizedVector']),
        //         'group_id' => $group_id,
        //     ]);
        // }));

        return view('comparison', $consistency);
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

    protected function buildShowCriteriaMatrix($comparisonData, $criteriaNames)
    {
        $criteriaMatrix = [];
        for ($i = 0; $i < count($comparisonData); $i++) {
            $row = [];
            for ($j = 0; $j < count($comparisonData); $j++) {
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

        // $totalEigenvector = array_sum($normalizedVector);
        $totalLambda = 0;
        for ($i = 0; $i < count($consistency['columnSums']); $i++) {
            $totalLambda += $normalizedVector[$i] * $consistency['columnSums'][$i];
        }
        $CI = $this->calculateCI($totalLambda, $criteriaMatrix);
        $CR = $this->calculateCR($CI, $criteriaMatrix);

        $consistency['totalEigenvector'] = $totalLambda;
        $consistency['CI'] = $CI;
        $consistency['CR'] = $CR;

        return $consistency;
    }

    protected function printPairwiseComparisonMatrix($criteriaMatrix, $criteriaNames)
    {
        echo str_pad('', 15);
        foreach ($criteriaNames as $name) {
            echo str_pad($name, 10);
            echo "\t"; // Add tab for spacing
        }
        echo "\n"; // Add column for total

        foreach ($criteriaMatrix as $i => $row) {
            $total = 0; // Initialize total for current column
            echo str_pad($criteriaNames[$i], 15);
            foreach ($criteriaMatrix[$i] as $value) {
                echo str_pad(number_format($value, 2), 15);
            }
            $total = array_sum($criteriaMatrix[$i]);
            echo str_pad(number_format($total, 2), 15); // Print row sum
            echo "\n";
        }

        $columnSums = array_map('array_sum', array_map(null, ...$criteriaMatrix));

        echo str_pad('Jumlah', 15);
        foreach ($columnSums as $sum) {
            echo str_pad(number_format($sum, 2), 15);
        }
        echo "\n";
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

    protected function printPairwiseSquaredMatrix($squaredMatrix, $criteriaNames)
    {
        echo str_pad('', 15);
        foreach ($criteriaNames as $name) {
            echo str_pad($name, 10);
            echo "\t"; // Add tab for spacing
        }
        echo str_pad('Jumlah', 15); // Add column for row sum
        echo "\n";

        foreach ($squaredMatrix as $i => $row) {
            $total = 0; // Initialize total for current column
            echo str_pad($criteriaNames[$i], 15);
            foreach ($squaredMatrix[$i] as $value) {
                echo str_pad(number_format($value, 2), 15);
                $total += $value; // Calculate row sum
            }
            echo str_pad(number_format($total, 2), 15); // Print row sum
            echo "\n";
        }
    }

    protected function calculateNormalizedVector($squaredMatrix)
    {
        $rowSums = array_map('array_sum', $squaredMatrix);
        $totalRowSum = array_sum($rowSums);
        return array_map(function ($rowSum) use ($totalRowSum) {
            return $rowSum / $totalRowSum;
        }, $rowSums);
    }

    protected function printEigenvector($normalizedVector)
    {
        echo "\nNilai Eigenvector: ";
        $totalEigenvector = array_sum($normalizedVector);
        foreach ($normalizedVector as $value) {
            $percentage = ($value / $totalEigenvector) * 100;
            echo number_format($value, 4) . " (" . number_format($percentage, 2) . "%) ";
        }
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
        return $CI / $IR[$n];
    }
}
