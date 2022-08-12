<?php

namespace App\Exports;

use App\MemberBalance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MemberBalanceExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MemberBalance::all();
    }

    public function headings(): array
    {
        return [
            'id' , 'member_id', 'balance', 'created_date',
        ];
    }

    public function title() : string
    {
        return 'MemberBalance';
    }
}
