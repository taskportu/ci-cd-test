<?php

namespace App\Http\Controllers;

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
use App\Exports\MultiSheetExport;
use App\Exports\NewsInfoExport;
use App\Exports\RegExport;
use App\Exports\TicketExport;
use App\Exports\TicketHistoryExport;
use App\Exports\UserLogExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Mail;

class BackupController extends Controller
{
    public function export(Request $request) {
        $date = Carbon::now()->format('YmdHis');
        $fileName = 'backup-'.$date.'.xlsx';
        $pathToFile = storage_path('app/public/excel-backup/'.$fileName);
        $backupTime = Carbon::now()->format('Y-m-d H:i');

        $backupObject = new MultiSheetExport();
        Excel::store($backupObject, $fileName, 'excel-backup');
        /*Mail::send('email.backup', [], function ($message) use ($pathToFile, $backupTime) {
            $message->attach($pathToFile);
            $message->subject('OCC-GOLF Dev BACKUP '.$backupTime);
            $message->from('noreply@digifront.biz', 'OCC Backup');
//             $message->to('anushanv92@gmail.com');
            // $message->to('arumuganathan.athithan@digifront.biz');
            // $message->to('athithana948@gmail.com');
            $message->to('torkel.ruud@gmail.com');
        });*/
        return Excel::download($backupObject, $fileName);
    }
}
