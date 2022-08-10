<?php

namespace App\Exports;

use App\Reg;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class RegExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Reg::all();
    }

    public function headings(): array
    {
        return [
            'reg_auto', 'reg_time', 'reg_member_id', 'reg_phone', 'reg_fistname', 'reg_lastname',
            'reg_guest_member', 'reg_club', 'reg_hcp', 'created_at', 'updated_at'
        ];
    }

    public function title() : string
    {
        return 'Reg';
    }
}
