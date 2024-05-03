<?php

// Criteria names
$criteriaNames = [
    'Harga',
    'Ukuran Kemasan',
    'Luas Cakupan',
    'Dosis',
    'Banyak Penyakit',
    'Daya Tahan'
];

// Matriks pairwise comparison
$criteriaMatrix = [
    [1, 3, 3, 3, 5, 3],
    [1 / 3, 1, 3, 3, 3, 3],
    [1 / 3, 1 / 3, 1, 3, 3, 3],
    [1 / 3, 1 / 3, 1 / 3, 1, 3, 3],
    [1 / 5, 1 / 3, 1 / 3, 1 / 3, 1, 3],
    [1 / 3, 1 / 3, 1 / 3, 1 / 3, 1 / 3, 1]
];


// Print pairwise comparison matrix with criteria names
echo str_pad('', 15);
foreach ($criteriaNames as $name) {
    echo str_pad($name, 10);
    echo "\t"; // Add tab for spacing
}
echo "\n"; // Add column for total

for ($i = 0; $i < count($criteriaMatrix); $i++) {
    $total = 0; // Initialize total for current column
    echo str_pad($criteriaNames[$i], 15);
    foreach ($criteriaMatrix[$i] as $value) {
        echo str_pad(number_format($value, 2), 15);
    }
    // Calculate row sum
    $total = array_sum($criteriaMatrix[$i]);
    echo str_pad(number_format($total, 2), 15); // Print row sum
    echo "\n";
}

// Calculate column sums
$columnSums = array_map('array_sum', array_map(null, ...$criteriaMatrix));

// Print totals as a new row
echo str_pad('Jumlah', 15);
foreach ($columnSums as $sum) {
    echo str_pad(number_format($sum, 2), 15);
}
echo "\n";

// Calculate pairwise square matrix
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

// Print pairwise squared matrix with criteria names
echo "\nMatriks Hasil Pengkuadratan:\n";
echo str_pad('', 15);
foreach ($criteriaNames as $name) {
    echo str_pad($name, 10);
    echo "\t"; // Add tab for spacing
}
echo str_pad('Jumlah', 15); // Add column for row sum
echo "\n";

for ($i = 0; $i < count($squaredMatrix); $i++) {
    $total = 0; // Initialize total for current column
    echo str_pad($criteriaNames[$i], 15);
    foreach ($squaredMatrix[$i] as $value) {
        echo str_pad(number_format($value, 2), 15);
        $total += $value; // Calculate row sum
    }
    echo str_pad(number_format($total, 2), 15); // Print row sum
    echo "\n";
}

// Calculate row sums
$rowSums = array_map('array_sum', $squaredMatrix);

// Normalization of matrix
$normalizedVector = [];
foreach ($squaredMatrix as $i => $row) {
    $normalizedVector[$i] = $rowSums[$i] / array_sum($rowSums);
}

// Show eigenvector results
echo "\nNilai Eigenvector: ";
$totalEigenvector = array_sum($normalizedVector);
foreach ($normalizedVector as $value) {
    $percentage = ($value / $totalEigenvector) * 100;
    echo number_format($value, 4) . " (" . number_format($percentage, 2) . "%) ";
}

// Calculate Consistency Index (CI)
$n = count($criteriaMatrix);
$CI = ($totalEigenvector - $n) / ($n - 1);

// Create Random Index Consistency (IR)
$IR = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];

// Calculate Consistency Ratio (CR)
$CR = $CI / $IR[$n];

echo "\nLambda Max: " . number_format($totalEigenvector, 4);
echo "\nCI: " . number_format($CI, 4);
echo "\nCR: " . number_format($CR, 4);

// Check hierarchy consistency
if ($CR > 0.1) {
    echo "\nNilai CR lebih dari 10%, penilaian data judgment harus diperbaiki.";
} else {
    echo "\nNilai CR kurang dari atau sama dengan 0.1, hasil perhitungan konsisten.";
}
