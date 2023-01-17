<?php

namespace App\Imports;

use App\Models\Number;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NumberImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Number([
            'id' => $row['id'],
            'sms_phone' => $row['sms_phone']
        ]);
    }
}
