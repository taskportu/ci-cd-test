<?php

namespace App\Exports;

use App\UserLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserLogExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserLog::all();
    }

    public function headings(): array
    {
        return [
            'log_id', 'log_member_id', 'log_time'
        ];
    }

    public function title() : string
    {
        return 'UserLog';
    }
}
