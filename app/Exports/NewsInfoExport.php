<?php

namespace App\Exports;

use App\NewsInfo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class NewsInfoExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return NewsInfo::all();
    }

    public function headings(): array
    {
        return [
            'id', 'header', 'body', 'status', 'created_at', 'updated_at'
        ];
    }

    public function title() : string
    {
        return 'NewsInfo';
    }
}
