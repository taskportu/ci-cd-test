<?php

namespace App\Exports;

use App\Models\TicketHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class TicketHistoryExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TicketHistory::all();
    }

    public function headings(): array
    {
        return [
            'id', 'occid', 'date_purchase', 'product', 'ticket_count', 'ticket_used', 'date_used',
            'active', 'ticket_type', 'created_at', 'updated_at'
        ];
    }

    public function title() : string
    {
        return 'TicketHistory';
    }
}
