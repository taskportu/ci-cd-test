<?php

namespace App\Exports;

use App\Code;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CodeExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Code::all();
    }

    public function headings(): array
    {
        return [
            'id', 'code', 'member_id'
        ];
    }

    public function title() : string
    {
        return 'Code';
    }


}
