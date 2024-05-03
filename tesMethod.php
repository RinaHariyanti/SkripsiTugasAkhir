<?php

class AHP
{
    public function calculateWeights($criteriaMatrix)
    {
        $n = count($criteriaMatrix);
        $weights = [];

        // Step 1: Normalization
        for ($i = 0; $i < $n; $i++) {
            $sum = array_sum($criteriaMatrix[$i]);
            for ($j = 0; $j < $n; $j++) {
                $criteriaMatrix[$i][$j] /= $sum;
            }
        }

        // Step 2: Calculate the average of each column
        for ($j = 0; $j < $n; $j++) {
            $sum = 0;
            for ($i = 0; $i < $n; $i++) {
                $sum += $criteriaMatrix[$i][$j];
            }
            $weights[] = $sum / $n;
        }

        return $weights;
    }

    public function printMatrixAndTotal($criteriaMatrix, $weights)
    {
        $n = count($criteriaMatrix);

        // Print matrix
        printf("Pairwise Comparison Matrix:\n");
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                printf("%-10s ", number_format($criteriaMatrix[$i][$j], 2));
            }
            printf("\n");
        }

        // Print weights
        printf("\nWeights of criteria:\n");
        foreach ($weights as $index => $weight) {
            printf("Criterion %d: %.2f\n", ($index + 1), $weight);
        }

        // Calculate total
        $total = array_sum($weights);
        printf("\nTotal: %.2f\n", $total);
    }
}

// Example usage
$ahp = new AHP();

// Example criteria matrix (pairwise comparison)
$criteriaMatrix = [
    [1, 3, 3, 3, 5, 3],
    [1 / 3, 1, 3, 3, 3, 3],
    [1 / 3, 1 / 3, 1, 3, 3, 3],
    [1 / 3, 1 / 3, 1 / 3, 1, 3, 3],
    [1 / 5, 1 / 3, 1 / 3, 1 / 3, 1, 3],
    [1 / 3, 1 / 3, 1 / 3, 1 / 3, 1 / 3, 1]
];

// Calculate weights of criteria
$weights = $ahp->calculateWeights($criteriaMatrix);

// Print matrix and total
$ahp->printMatrixAndTotal($criteriaMatrix, $weights);
