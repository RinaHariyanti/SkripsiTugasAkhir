<?php

class AHP
{
    protected $criteriaNames;
    protected $criteriaMatrix;

    public function __construct($criteriaNames, $criteriaMatrix)
    {
        $this->criteriaNames = $criteriaNames;
        $this->criteriaMatrix = $criteriaMatrix;
    }

    public function printMatrix()
    {
        $this->printHeader();
        foreach ($this->criteriaMatrix as $i => $row) {
            $this->printRow($this->criteriaNames[$i], $row);
        }
        $this->printTotals();
    }

    protected function printHeader()
    {
        echo str_pad('', 15);
        foreach ($this->criteriaNames as $name) {
            echo str_pad($name, 10);
            echo "\t"; // Add tab for spacing
        }
        echo "\n"; // Add column for total
    }

    protected function printRow($name, $row)
    {
        $total = 0; // Initialize total for current column
        echo str_pad($name, 15);
        foreach ($row as $value) {
            echo str_pad(number_format($value, 2), 15);
        }
        // Calculate row sum
        $total = array_sum($row);
        echo str_pad(number_format($total, 2), 15); // Print row sum
        echo "\n";
    }

    protected function printTotals()
    {
        // Calculate column sums
        $columnSums = array_map('array_sum', array_map(null, ...$this->criteriaMatrix));

        // Print totals as a new row
        echo str_pad('Jumlah', 15);
        foreach ($columnSums as $sum) {
            echo str_pad(number_format($sum, 2), 15);
        }
        echo "\n";
    }

    public function calculateConsistency()
    {
        $squaredMatrix = $this->calculateSquaredMatrix();
        $this->printSquaredMatrix($squaredMatrix);
        $columnSums = array_map('array_sum', array_map(null, ...$this->criteriaMatrix));

        $normalizedVector = $this->calculateNormalizedVector($squaredMatrix);
        $this->printEigenvector($normalizedVector);
        $totalLamba = 0;
        foreach ($columnSums as $i => $sum) {
            $totalLamba += $sum * $normalizedVector[$i];
        }

        echo "\nTotal Lambdaaaaaaaaaa: " . number_format($totalLamba, 4);

        $totalEigenvector = array_sum($normalizedVector); // Hitung total eigenvector
        $CI = $this->calculateCI($totalLamba); // Gunakan total eigenvector untuk menghitung CI
        $CR = $this->calculateCR($CI);

        echo "\nLambda Max: " . number_format($totalEigenvector, 4);
        echo "\nCI: " . number_format($CI, 4);
        echo "\nCR: " . number_format($CR, 4);

        if ($CR > 0.1) {
            echo "\nNilai CR lebih dari 10%, penilaian data judgment harus diperbaiki.";
        } else {
            echo "\nNilai CR kurang dari atau sama dengan 0.1, hasil perhitungan konsisten.";
        }
    }

    protected function calculateSquaredMatrix()
    {
        $squaredMatrix = [];
        foreach ($this->criteriaMatrix as $i => $row) {
            foreach ($row as $j => $value) {
                $sum = 0;
                for ($k = 0; $k < count($row); $k++) {
                    $sum += $this->criteriaMatrix[$i][$k] * $this->criteriaMatrix[$k][$j];
                }
                $squaredMatrix[$i][$j] = $sum;
            }
        }
        return $squaredMatrix;
    }

    protected function printSquaredMatrix($squaredMatrix)
    {
        echo "\nMatriks Hasil Pengkuadratan:\n";
        echo str_pad('', 15);
        foreach ($this->criteriaNames as $name) {
            echo str_pad($name, 10);
            echo "\t"; // Add tab for spacing
        }
        echo str_pad('Jumlah', 15); // Add column for row sum
        echo "\n";

        foreach ($squaredMatrix as $i => $row) {
            $total = 0; // Initialize total for current column
            echo str_pad($this->criteriaNames[$i], 15);
            foreach ($row as $value) {
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
        $totalRowSum = array_sum($rowSums); // Total dari semua elemen dalam matriks

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


    protected function calculateCI($totalEigenvector)
    {
        $n = count($this->criteriaMatrix);
        echo "\nNNNNNNNNNNNN: " . number_format($totalEigenvector, 4);
        return ($totalEigenvector - $n) / ($n - 1);
    }

    protected function calculateCR($CI)
    {
        $IR = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
        $n = count($this->criteriaMatrix);
        return $CI / $IR[$n];
    }
}

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

$ahp = new AHP($criteriaNames, $criteriaMatrix);
$ahp->printMatrix();
$ahp->calculateConsistency();
