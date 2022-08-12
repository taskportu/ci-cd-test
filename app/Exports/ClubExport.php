<?php

namespace App\Exports;

use App\club;
use App\Code;
use App\Members;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClubExport implements FromCollection, WithHeadings, WithTitle
{

    public function collection()
    {
        return club::all();
    }

    public function headings(): array
    {
        return [
            'ClubID', 'ClubName',
        ];
    }

    public function title() : string
    {
        return 'Club';
    }
}
