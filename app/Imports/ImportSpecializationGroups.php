<?php

namespace App\Imports;

use App\Models\Specialization;
use App\Models\SpecializationGroup;
use App\Models\ZipCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSpecializationGroups implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     */
    public function model(array $row)
    {
        return new SpecializationGroup($row);
        //
    }
}
