<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MatrixRequestForm;
use App\Services\MatrixService;
use Illuminate\Http\Request;

class MatrixController extends Controller
{
    /**
     * Calculate the multiplication of 2 matrices
     * 
     * @param Request $request
     * @return Response
     */
    public function multiplyMatrix(MatrixRequestForm $request, MatrixService $matrix_service)
    {
        $matrix_1 = $request->matrix_1;
        $matrix_2 = $request->matrix_2;

        if (count($matrix_1[0]) != count($matrix_2)) {
            return response()->json([
                'message' => 'The number of columns in matrix 1 must be equal to the number of rows in matrix 2'
            ], 422);
        }
        
        $matrix_result = $matrix_service->multiplyMatrices($matrix_1, $matrix_2);
        $matrix_encoded = $matrix_service->encodeMatrix($matrix_result);
        $result = [
            'matrix_numeric' => $matrix_result,
            'matrix_encoded' => $matrix_encoded
        ];

        return response()->json($result);
    }
}
