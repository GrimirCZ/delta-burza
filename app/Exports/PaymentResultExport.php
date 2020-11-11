<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentResultExport implements FromCollection, WithHeadings
{
    public Collection $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->rows;
    }

    public function headings() : array
    {
        // use keys from longest row
        $longest = [];
        $longest_length = 0;

        foreach($this->rows as $row){
            if($row->keys()->count() > $longest_length){
                $longest_length = $row->keys()->count();
                $longest = $this->rows[0]->keys()->toArray();
            }
        }

        return $longest;
    }
}
