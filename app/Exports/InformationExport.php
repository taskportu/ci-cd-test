<?php

namespace App\Exports;

use App\information;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class InformationExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return information::all();
    }

    public function headings(): array
    {
        return [
            'InfoID', 'Date', 'Temp', 'Weather', 'Activity', 'Restaurant', 'Hotel', 'Comment', 'Name'
        ];
    }

    public function title() : string
    {
        return 'HcpRegitar';
    }
}
