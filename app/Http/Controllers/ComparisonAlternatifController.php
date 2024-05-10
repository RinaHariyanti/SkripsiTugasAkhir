<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComparisonAlternatif;
use App\Models\ComparisonMatrix;
use App\Models\Pesticide;
use App\Models\PesticideCriteria;
use Illuminate\Support\Facades\DB;
use App\Models\Criteria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ComparisonAlternatifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userHistory()
    {
        $comparisonAlternatif = DB::table('comparison_alternatifs')
            ->join('users', 'comparison_alternatifs.user_id', '=', 'users.id')
            ->select('comparison_alternatifs.group_id', 'users.name', 'users.email', DB::raw('MAX(comparison_alternatifs.created_at) AS created_at'))
            ->groupBy('comparison_alternatifs.group_id', 'users.name', 'users.email')
            ->get();


        // dd($comparisonAlternatif);
        $formattedData = [];
        foreach ($comparisonAlternatif as $data) {
            $formattedData[] = [
                'group_id' => $data->group_id,
                'spk_code' => 'SPK-' . $data->group_id,
                'user' => $data->name,
                'email' => $data->email,
                'created_at' => $data->created_at
            ];
        }

        // return response()->json($formattedData);
        return view('user.rank', compact('formattedData'));
    }

    public function userLatestHistory()
    {
        $comparisonAlternatif = DB::table('comparison_alternatifs')
            ->join('users', 'comparison_alternatifs.user_id', '=', 'users.id')
            ->select('comparison_alternatifs.group_id', 'users.name', 'users.email', DB::raw('MAX(comparison_alternatifs.created_at) AS created_at'))
            ->groupBy('comparison_alternatifs.group_id', 'users.name', 'users.email')
            ->where('comparison_alternatifs.user_id', auth()->user()->id)
            ->where('comparison_alternatifs.group_id', ComparisonAlternatif::max('group_id'))
            ->get();


        // dd($comparisonAlternatif);
        $formattedData = [];
        foreach ($comparisonAlternatif as $data) {
            $formattedData[] = [
                'group_id' => $data->group_id,
                'spk_code' => 'SPK-' . $data->group_id,
                'user' => $data->name,
                'email' => $data->email,
                'created_at' => $data->created_at
            ];
        }

        // return response()->json($formattedData);
        // return view('user.rank', compact('formattedData'));
        return redirect('/compare/results/' . ComparisonAlternatif::max('group_id'));
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

        $detailsCriteria = PesticideCriteria::where('criteria_id', $index + 1)->get();
        // dd(json_decode($details));
        $alternatives = Pesticide::all()->pluck('name');
        return view('comparisonAlternatif.formCompare', compact('alternatives', 'firstCriteriaName', 'index', 'criteriaNames', 'detailsCriteria'));
    }

    // public function storeComparisonAlternatif(Request $request, $index)
    // {
    //     $comparisonData = $request->comparison;
    //     $criteriaNames = Pesticide::all()->pluck('name');
    //     $criteriaMatrix = $this->buildCriteriaMatrix($comparisonData, $criteriaNames);
    //     $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);
    //     $nextIndex = $index + 1;
    //     // $index = intval($index);
    //     DB::transaction((function () use ($criteriaNames, $criteriaMatrix, $consistency, $index) {
    //         $group_id = ComparisonMatrix::max('group_id') + 1;
    //         ComparisonAlternatif::create([
    //             'criteria_name' => json_encode($criteriaNames),
    //             'comparison_data' => json_encode($criteriaMatrix),
    //             'eigenvector' => json_encode($consistency['normalizedVector']),
    //             'criteria_id' => $index,
    //             'group_id' => $group_id,
    //         ]);
    //     }));

    //     return view('comparisonAlternatif.comparisonAlternatifShow', $consistency, compact('nextIndex'));
    // }

    // public function storeComparisonAlternatif(Request $request, $index)
    // {
    //     $comparisonData = $request->comparison;
    //     $criteriaNames = Pesticide::all()->pluck('name');
    //     $criteriaMatrix = $this->buildCriteriaMatrix($comparisonData, $criteriaNames);
    //     $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);
    //     $nextIndex = $index + 1;

    //     // Get the current comparison data from cookies
    //     $cookieName = 'comparison_data_' . $index;
    //     $comparisonCookie = Cookie::get($cookieName);

    //     // Merge the new comparison data with the existing data
    //     $mergedData = array_merge($comparisonCookie ?? [], $criteriaMatrix);

    //     // Store the merged comparison data in cookies
    //     Cookie::queue($cookieName, $mergedData);

    //     // Check if it's the final index
    //     if ($nextIndex == count($criteriaNames)) {
    //         // Save all comparison data to the database in a single transaction
    //         DB::transaction(function () use ($criteriaNames, $mergedData, $consistency) {
    //             $group_id = ComparisonMatrix::max('group_id');
    //             ComparisonMatrix::create([
    //                 'criteria_name' => json_encode($criteriaNames),
    //                 'comparison_data' => json_encode($mergedData),
    //                 'eigenvector' => json_encode($consistency['normalizedVector']),
    //                 'group_id' => $group_id,
    //             ]);
    //         });
    //     }

    //     return view('comparison', $consistency, compact('nextIndex'));
    // }

    public function storeComparisonAlternatif(Request $request, $index)
    {
        $comparisonData = $request->comparison;
        $criteriaNames = Pesticide::all()->pluck('name');
        $criteriaCompare = Criteria::all()->pluck('name');
        $criteriaMatrix = $this->buildCriteriaMatrix($comparisonData, $criteriaNames);
        $consistency = $this->calculateConsistency($criteriaMatrix, $criteriaNames);

        // Store comparison data in cache
        $cacheKey = 'comparison_data_' . $index;
        Cache::put($cacheKey, $consistency, now()->addHours(1)); // Adjust the cache expiration time as needed

        Log::info('Comparison data stored in cache', ['cacheKey' => $cacheKey]);

        $nextIndex = $index + 1;

        // Redirect to the next index or final submission page
        if ($nextIndex < count($criteriaCompare)) {
            return view('comparisonAlternatif.comparisonAlternatifShow', $consistency, compact('nextIndex'));
        } else {
            $criteria_data = null;
            $mergedData = [];
            for ($i = 0; $i < count($criteriaCompare); $i++) {
                $cacheKey = 'comparison_data_' . $i;
                $chacheData = Cache::get('comparison_criteria_data_temp');
                $data = Cache::get($cacheKey);
                if ($data && $chacheData) {
                    $criteria_data = $chacheData;
                    $mergedData[] = $data;
                    Cache::forget($cacheKey);
                }
            }
            // dd($criteria_data);
            // Start database transaction
            DB::beginTransaction();
            try {
                // dd($mergedData);
                ComparisonMatrix::create([
                    'criteria_name' => json_encode($criteria_data['criteria_name']),
                    'comparison_data' => json_encode($criteria_data['comparison_data']),
                    'eigenvector' => json_encode($criteria_data['eigenvector']),
                    'group_id' => json_decode($criteria_data['group_id'])
                ]);
                // Log::info($criteria_data[0]['group_id']);
                // Log::info('Comparison data stored in database' . ['group_id' => $criteria_data['group_id']]);

                foreach ($mergedData as $index => $data) {
                    $group_id = ComparisonMatrix::max('group_id');
                    ComparisonAlternatif::create([
                        'criteria_name' => json_encode($data['criteriaNames']),
                        'comparison_data' => json_encode($data['criteriaMatrix']),
                        'eigenvector' => json_encode($data['normalizedVector']),
                        'criteria_id' => $index,
                        'group_id' => $group_id,
                        'user_id' => $request->user()->id
                    ]);
                }

                DB::commit(); // Commit transaction
            } catch (\Exception $e) {
                DB::rollback(); // Rollback transaction on error
                Log::error('Failed to save data', ['error' => $e->getMessage()]);
                // Handle error
                return back()->withError('Failed to save data. Please try again.');
            }
            // dd($criteria_data, $mergedData);
            // Redirect to success page
            return redirect('/compare/results/' . $group_id)->with('success', 'Comparison data has been saved successfully');
        }
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

    protected function rankResult($group_id)
    {

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

        // dd($finalResult);
        // Sort combined data based on sumResult
        usort($finalResult, function ($a, $b) {
            return $b['Data'] <=> $a['Data'];
        });

        return view('comparisonAlternatif.rankResult', compact('finalResult', 'combinedDataBenefit', 'combinedDataCost'));
    }
}
