<?php

namespace App\Exports;

use App\Models\HcpRegitar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class HcpRegitarExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HcpRegitar::all();
    }

    public function headings(): array
    {
        return [
            'id', 'OccID', 'hcp', 'cal_hcp', 'date', 'round_palyed', 'created_at',
            'updated_at', 'club', 'hcp_status', 'coursepar', 'strokesgiven', 'actualstrokes'
        ];
    }

    public function title() : string
    {
        return 'HcpRegitar';
    }
}
