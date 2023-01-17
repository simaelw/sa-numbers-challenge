<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Http\Request;
use App\Imports\NumberImport;
use App\Helpers\NumberSanitizer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class NumberCsvController extends Controller
{
    /**
     * Upload Csv
     *
     * This endpoint allows you to upload the csv, manipulate the data and save the records on the database.
     * 
     */
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv'
        ]);

        DB::table('numbers')->truncate();

        $data = Excel::toArray(new NumberImport, $request->file('csv'))[0];

        $numbersResponse = [];

        DB::beginTransaction();

        foreach ($data as $entry) {

            if (
                !array_key_exists('sms_phone', $entry) ||
                !array_key_exists('id', $entry)
            ) {
                DB::rollBack();
                return response()->json(['message' => 'Malformed csv file given.'], Response::HTTP_BAD_REQUEST);
            }

            $sanitizedNumber = $this->numberSanitizer->validateOrCorrect($entry['sms_phone']);

            if ($sanitizedNumber['number'] === false) {
                $numbersResponse['incorrect_numbers'][] = [
                    'id' => $entry['id'],
                    'number' => $entry['sms_phone']
                ];
            } elseif ($sanitizedNumber['modified'] === true) {
                $numbersResponse['modified_numbers'][] = [
                    'id' => $entry['id'],
                    'number' => $sanitizedNumber['number'],
                    'action' => $sanitizedNumber['modified_action']
                ];
            } else {
                $numbersResponse['correct_numbers'][] = [
                    'id' => $entry['id'],
                    'number' => $entry['sms_phone']
                ];
            }

            Number::create([
                'phone_id' => $entry['id'],
                'original' => $sanitizedNumber['modified'] === true ? $entry['sms_phone'] : null,
                'sms_phone' => $sanitizedNumber['modified'] === true ? $sanitizedNumber['number'] : $entry['sms_phone'],
                'valid' => $sanitizedNumber['valid'],
                'modified' => $sanitizedNumber['modified'],
                'modified_action' => $sanitizedNumber['modified_action']
            ]);
        }

        DB::commit();

        return response()->json($numbersResponse);
    }
}
