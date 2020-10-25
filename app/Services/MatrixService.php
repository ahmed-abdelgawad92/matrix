<?php

declare(strict_types=1);

namespace App\Services;

class MatrixService
{
    private array $alphabet;

    public function __construct()
    {
        $this->alphabet = range('A', 'Z');
    }

    /**
     * Multiply Matrices
     * 
     * @param array $matrix_1
     * @param array $matrix_2
     * @return array $matrix_result
     */
    public function multiplyMatrices(array $matrix_1, array $matrix_2): array
    {
        $matrix_result = [];
        $count_matrix_1 = count($matrix_1);
        $count_matrix_2 = count($matrix_2);
        $number_columns_2 = count($matrix_2[0]);

        for ($i = 0; $i < $count_matrix_1; $i++) {
            for ($j = 0; $j < $number_columns_2; $j++) {
                $sum = 0;
                for ($k = 0; $k < $count_matrix_2; $k++) { 
                    $sum += ($matrix_1[$i][$k] * $matrix_2[$k][$j]);
                }
                $matrix_result[$i][$j] = $sum;
            }
        }

        return $matrix_result;
    }

    /**
     * Encoding Matrix result into Alphabets
     * 
     * @param array $matrix
     * @return array $encoded_matrix
     */
    public function encodeMatrix(array $matrix): array
    {
        $encoded_matrix = [];
        $count = count($matrix);
        $count_col = count($matrix[0]);

        for ($i = 0; $i < $count; $i++) { 
            for ($j = 0; $j < $count_col; $j++) {
                $encoded_matrix[$i][$j] = $this->convertNumberIntoLetter($matrix[$i][$j]);
            }
        }

        return $encoded_matrix;
    }

    /**
     * Convert a number into a letter
     *
     * @param int $number
     * @return string $letters
     */
    private function convertNumberIntoLetter(int $number): string
    {
        $letters = '';
        
        if($number == 0) {
            return 'N/A';
        }
        
        do {
            $index = (intval($number) % 26) - 1;
            if($index < 0) {
                $index = 25;
            }

            $letters = $this->alphabet[$index] . $letters;
            $number /= 26;
        } while ($number > 1);

        return $letters;
    }
}
