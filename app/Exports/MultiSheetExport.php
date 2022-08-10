<?php

namespace App\Exports;

use App\Exports\AppTrackingExport;
use App\Exports\ClubExport;
use App\Exports\CodeExport;
use App\Exports\HcpImpExport;
use App\Exports\HcpRegitarExport;
use App\Exports\InformationExport;
use App\Exports\MemberBalanceExport;
use App\Exports\MemberChangesLogExport;
use App\Exports\MemberExport;
use App\Exports\MemberLogExport;
use App\Exports\NewsInfoExport;
use App\Exports\RegExport;
use App\Exports\TicketExport;
use App\Exports\TicketHistoryExport;
use App\Exports\UserLogExport;
use Illuminate\Http\Request;
use App\Exports\UserExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AppTrackingExport;
        $sheets[] = new ClubExport;
        $sheets[] = new CodeExport;
//        $sheets[] = new HcpImpExport;
        $sheets[] = new HcpRegitarExport;
        $sheets[] = new InformationExport;
        $sheets[] = new MemberBalanceExport;
        $sheets[] = new MemberChangesLogExport;
        $sheets[] = new MemberExport;
        $sheets[] = new MemberLogExport;
        $sheets[] = new NewsInfoExport;
        $sheets[] = new RegExport;
        $sheets[] = new TicketExport;
        $sheets[] = new TicketHistoryExport;
        $sheets[] = new UserExport;
        $sheets[] = new UserLogExport;

        return $sheets;
    }
}
