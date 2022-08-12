<?php

namespace App\Exports;

use App\MemberChangesLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MemberChangesLogExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MemberChangesLog::all();
    }

    public function headings(): array
    {
        return [
            'log_id', 'log_member_id', 'log_field', 'log_old', 'log_new', 'log_timestamp'
        ];
    }

    public function title() : string
    {
        return 'MemberChangesLog';
    }
}
