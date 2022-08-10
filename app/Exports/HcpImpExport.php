<?php

namespace App\Exports;

use App\HcpImp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class HcpImpExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HcpImp::all();
    }

    public function headings(): array
    {
        return [
            'occid', 'hcp'
        ];
    }

    public function title() : string
    {
        return 'HcpImp';
    }
}
