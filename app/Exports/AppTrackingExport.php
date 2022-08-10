<?php

namespace App\Exports;

use App\Models\AppTracking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AppTrackingExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AppTracking::all();
    }

    public function headings(): array
    {
        return [
            'id', 'date', 'member_id', 'email', 'phone', 'count', 'code'
        ];
    }

    public function title() : string
    {
        return 'AppTracking';
    }
}
