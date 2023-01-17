<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NumberTesterController extends Controller
{
    /**
     * Test number
     *
     * This endpoint allows to test or attempt to correct a single provided number.
     * 
     */
    public function test(Request $request)
    {
        $request->validate([
            'number' => 'required|string'
        ]);

        $number = $request->input('number');

        $data = $this->numberSanitizer->validateOrCorrect($number);

        if (
            $data['modified'] ||
            $data['valid'] === false
        ) {
            $data['original_number'] = $number;
        }

        return response()->json($data);
    }
}
