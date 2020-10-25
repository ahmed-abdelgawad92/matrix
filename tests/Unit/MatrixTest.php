<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\MatrixService;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    private array $matrix_1 = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
    ];
    private array $matrix_2 = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
    ];
    private array $expected_matrix_result = [
        [30, 36, 42],
        [66, 81, 96],
        [102, 126, 150],
    ];
    private array $expected_matrix_result_encoded = [
        ['AD', 'AJ', 'AP'],
        ['BN', 'CC', 'CR'],
        ['CX', 'DV', 'ET'],
    ];

    /**
     * A basic unit test of the multiplication of 2 matrices.
     *
     * @return void
     */
    public function testMatrixMultiplication()
    {
        $service = new MatrixService();
        $result = $service->multiplyMatrices($this->matrix_1, $this->matrix_2);
        
        $this->assertEquals($result, $this->expected_matrix_result);
    }

    /**
     * A basic unit test of encoding a matrix into letters.
     *
     * @return void
     */
    public function testMatrixEncoding()
    {
        $service = new MatrixService();
        $result = $service->encodeMatrix($this->expected_matrix_result);

        $this->assertEquals($result, $this->expected_matrix_result_encoded);
    }
}
