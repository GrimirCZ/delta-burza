<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PaymentImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    use Importable;

    public function model(array $row)
    {
        $num_fmt = numfmt_create('cs',\NumberFormatter::DECIMAL);
        $castka = numfmt_parse($num_fmt, $row['castka']);

        $cg = [];
        $variable_symbol_parsed = preg_match("/2020(?<id>[\d]{4})/",$row['variabilni_symbolreference'], $cg);

        dd($row);
    }

    public function getCsvSettings():array
    {
        return [
            'delimiter' => ';'
        ];
    }
}
