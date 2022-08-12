<?php

namespace App\Exports;

use App\MemberLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MemberLogExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MemberLog::all();
    }

    public function headings(): array
    {
        return [
            'log_id', 'member_id', 'url', 'ip_address', 'parameters', 'date_time'
        ];
    }

    public function title() : string
    {
        return 'MemberLog';
    }
}
