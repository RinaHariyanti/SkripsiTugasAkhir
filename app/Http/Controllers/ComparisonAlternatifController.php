<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComparisonAlternatif;
use App\Models\ComparisonMatrix;
use App\Models\Pesticide;
use Illuminate\Support\Facades\DB;
use App\Models\Criteria;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Return_;

class ComparisonAlternatifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($group_id)
    {
        $comparisonMatrix = ComparisonAlternatif::where('group_id', $group_id)->first();
        $criteriaNames = json_decode($comparisonMatrix->criteria_name);
        $comparisonData = json_decode($comparisonMatrix->comparison_data);

        // Ubah format data agar sesuai dengan yang diharapkan oleh calculateConsistency
        $criteriaMatrix = $this->buildShowCriteriaMatrix($comparisonData, $criteriaNames);
        $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);
        return view('ShowComparison', $consistency);
    }

    public function index($index)
    {
        $criteriaNames = Criteria::all(['id', 'name']);
        if ($index <= count($criteriaNames) - 1) {
            $firstCriteriaName = $criteriaNames[$index]->name;
        }

        $index = intval($index);
        if ($index === count($criteriaNames)) {
            return redirect()->route('pesticides.home')->with('success', 'All criteria have been compared');
        }
        $alternatives = Pesticide::all()->pluck('name');
        return view('comparisonAlternatif.formCompare', compact('alternatives', 'firstCriteriaName', 'index', 'criteriaNames'));
    }

    public function storeComparisonAlternatif(Request $request, $index)
    {
        $comparisonData = $request->comparison;
        $criteriaNames = Pesticide::all()->pluck('name');
        $criteriaMatrix = $this->buildCriteriaMatrix($comparisonData, $criteriaNames);
        $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);
        $nextIndex = $index + 1;
        // $index = intval($index);
        DB::transaction((function () use ($criteriaNames, $criteriaMatrix, $consistency, $index) {
            $group_id = ComparisonMatrix::max('group_id') + 1;
            ComparisonAlternatif::create([
                'criteria_name' => json_encode($criteriaNames),
                'comparison_data' => json_encode($criteriaMatrix),
                'eigenvector' => json_encode($consistency['normalizedVector']),
                'criteria_id' => $index,
                'group_id' => $group_id,
            ]);
        }));

        return view('comparisonAlternatif.comparisonAlternatifShow', $consistency, compact('nextIndex'));
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

    protected function rankResult()
    {
        // Mendapatkan group_id terakhir
        $group_id = 3;

        // Mendapatkan data perbandingan kriteria dan alternatif
        $comparisonCriteria = ComparisonMatrix::where('group_id', $group_id)->first();
        $comparisonAlternatif = ComparisonAlternatif::where('group_id', $group_id)->get();

        // Decode data kriteria dari JSON menjadi array
        $criteriaArray = json_decode($comparisonCriteria->criteria_name);
        $eigenCriteriaArray = json_decode($comparisonCriteria->eigenvector);

        // Mendapatkan kriteria berdasarkan jenisnya (cost atau benefit)
        $criteriaCost = Criteria::where('kind', 'cost')->pluck('name');
        $criteriaBenefit = Criteria::where('kind', 'benefit')->pluck('name');

        $indexBenefit = [];
        $eigenCriteriaBenefit = [];
        $indexCost = [];
        $eigenCriteriaCost = [];
        $resultBenefit = [];
        $resultCost = [];


        foreach ($criteriaArray as $index => $criteriaName) {
            if ($criteriaCost->contains($criteriaName)) {
                $indexCost[] = $index;
                $eigenCriteriaCost[] = $eigenCriteriaArray[$index];
            } elseif ($criteriaBenefit->contains($criteriaName)) {
                $indexBenefit[] = $index;
                $eigenCriteriaBenefit[] = $eigenCriteriaArray[$index];
            }
        }

        foreach ($comparisonAlternatif as $index => $comparison) {
            if (in_array($index, $indexBenefit)) {
                $resultBenefit[] = [
                    'name' => $comparison->criteria_name,
                    'eigenvector' => $comparison->eigenvector
                ];
            } else if (in_array($index, $indexCost)) {
                $resultCost[] = [
                    'name' => $comparison->criteria_name,
                    'eigenvector' => $comparison->eigenvector
                ];
            }
        }

        $valueWhileBenefit = [];
        $valueWhileCost = [];
        for ($i = 0; $i < count($resultBenefit); $i++) {
            $resultBenefit[$i]['eigenvector'] = json_decode($resultBenefit[$i]['eigenvector']);
            for ($j = 0; $j < count($resultBenefit[$i]['eigenvector']); $j++) {
                $valueWhileBenefit[$i][$j] = $resultBenefit[$i]['eigenvector'][$j] *= $eigenCriteriaBenefit[$i];
            }
        }

        for ($i = 0; $i < count($resultCost); $i++) {
            $resultCost[$i]['eigenvector'] = json_decode($resultCost[$i]['eigenvector']);
            for ($j = 0; $j < count($resultCost[$i]['eigenvector']); $j++) {
                $valueWhileCost[$i][$j] = $resultCost[$i]['eigenvector'][$j] *= $eigenCriteriaCost[$i];
            }
        }

        $sumResultBenefit = [];
        $sumResultCost = [];
        for ($i = 0; $i < count($valueWhileBenefit[0]); $i++) {
            $sum = 0;
            for ($j = 0; $j < count($valueWhileBenefit); $j++) {
                $sum += $valueWhileBenefit[$j][$i];
            }
            $sumResultBenefit[] = $sum;
        }

        for ($i = 0; $i < count($valueWhileCost[0]); $i++) {
            $sum = 0;
            for ($j = 0; $j < count($valueWhileCost); $j++) {
                $sum += $valueWhileCost[$j][$i];
            }
            $sumResultCost[] = $sum;
        }

        $namesArrayBenefit = json_decode($resultBenefit[0]['name'], true);
        $namesArrayCost = json_decode($resultCost[0]['name'], true);

        $combinedDataBenefit = [];
        $combinedDataCost = [];


        foreach ($sumResultBenefit as $index => $value) {
            $combinedDataBenefit[] = [
                'Name' => $namesArrayBenefit[$index],
                'Data' => $value
            ];
        }

        foreach ($sumResultCost as $index => $value) {
            $combinedDataCost[] = [
                'Name' => $namesArrayCost[$index],
                'Data' => $value
            ];
        }

        $finalResult = [];
        for ($i = 0; $i < count($namesArrayBenefit); $i++) {
            if ($combinedDataCost[$i]['Name'] == $combinedDataBenefit[$i]['Name']) {
                $finalResult[] = [
                    'Name' => $combinedDataCost[$i]['Name'],
                    'Data' => $combinedDataBenefit[$i]['Data'] / $combinedDataCost[$i]['Data']
                ];
            }
        }

        // Sort combined data based on sumResult
        usort($finalResult, function ($a, $b) {
            return $b['Data'] <=> $a['Data'];
        });

        return view('comparisonAlternatif.rankResult', compact('finalResult', 'combinedDataBenefit', 'combinedDataCost'));
    }
}