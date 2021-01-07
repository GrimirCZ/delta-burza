<?php

namespace App\Imports;

use App\Models\PrescribedSpecialization;
use App\Models\School;
use App\Models\Specialization;
use App\Models\SpecializationGroup;
use App\Models\ZipCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LinkPrescribedSpecializationToSpecializationGroupsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     */
    public function model(array $row)
    {
        $presc_spec = PrescribedSpecialization::where("code", "=", $row["prescribed_specialization_code"])->first();
        $spec_grou = SpecializationGroup::where("code", "=", $row["group_code"])->first();

        $presc_spec->specialization_group_id = $spec_grou->id;
        $presc_spec->push();
        //
    }
}
