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
use App\Exports\NewsInfoExport;
use App\Exports\RegExport;
use App\Exports\TicketExport;
use App\Exports\TicketHistoryExport;
use App\Exports\UserExport;
use App\Exports\UserLogExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Backup1Controller extends Controller
{
//    private $excel;
    /**
     * @var int
     */
    private $startingColumnModel;

    public function __construct(Excel $excel)
    {
//        $this->excel = $excel;
        $this->startingColumnModel = 1;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request) {
        $date = Carbon::now()->format('YmdHis');
        $fileName = 'backup-'.$date.'.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        /* AppTrackingExport Export */
        $exports = new AppTrackingExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* Club Export */
        $exports = new ClubExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* CodeExport Export */
        $exports = new CodeExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* HcpImpExport Export */
        $exports = new HcpImpExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* HcpRegitarExport Export */
        $exports = new HcpRegitarExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* InformationExport Export */
        $exports = new InformationExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* MemberBalanceExport Export */
        $exports = new MemberBalanceExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* MemberChangesLogExport Export */
        $exports = new MemberChangesLogExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* Member Export */
        $exports = new MemberExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* MemberLogExport Export */
        $exports = new MemberLogExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* NewsInfoExport Export */
        $exports = new NewsInfoExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* RegExport Export */
        $exports = new RegExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* TicketExport Export */
        $exports = new TicketExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* TicketHistoryExport Export */
        $exports = new TicketHistoryExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* UserExport Export */
        $exports = new UserExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        /* UserLogExport Export */
        $exports = new UserLogExport();
        $this->makingExcelForModel($spreadsheet, $sheet, $exports);

        $writer = new Xlsx($spreadsheet);
        ob_start();
        ini_set('memory_limit', '-1');
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::disk('excel-backup')->put($fileName, $content);
        $pathToFile = storage_path('app/public/excel-backup/'.$fileName);
        $backupTime = Carbon::now()->format('Y-m-d H:i');
        Mail::send('email.backup', [], function ($message) use ($pathToFile, $backupTime) {
            $message->attach($pathToFile);
            $message->subject('OCC-GOLF BACKUP '.$backupTime);
            $message->from('noreply@digifront.biz', 'OCC Backup');
            // $message->to('anushanv92@gmail.com');
            // $message->to('arumuganathan.athithan@digifront.biz');
            // $message->to('athithana948@gmail.com');
            $message->to('torkel.ruud@gmail.com');
        });
//        $writer->save($fileName);
    }

    public function makingExcelForModel($spreadsheet, $sheet, $modelExport)
    {
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $startingColumn = $this->startingColumnModel;
        $startingRow = 1;
        $range1 = $sheet->getCellByColumnAndRow($startingColumn, $startingRow)->getCoordinate();
        $range2 = $sheet->getCellByColumnAndRow($startingColumn + count($modelExport->headings()) - 1, $startingRow)->getCoordinate();
//        dd($range1, $range2, $modelExport->headings());
        $sheet->mergeCells("$range1:$range2");
        $sheet->setCellValue($range1, $modelExport->title());
        $sheet->getStyle($range1)->applyFromArray($styleArray);

        $startingRow = 2;
        foreach ($modelExport->headings() as $heading) {
            $cellAddress = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($startingColumn, $startingRow);
            $sheet->setCellValue($cellAddress->getCoordinate(), $heading);
            $sheet->getStyle($cellAddress->getCoordinate())->applyFromArray($styleArray);
            $startingColumn++;
        }
        $startingRow++;
        if(!empty($modelExport->collection()->toArray())) :
            foreach ($modelExport->collection()->toArray() as $clubExport) {
                $startingColumn = $this->startingColumnModel;
                foreach ($modelExport->headings() as $heading) {
                    $cellAddress = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($startingColumn, $startingRow);
                    $sheet->setCellValue($cellAddress->getCoordinate(), $clubExport[$heading]);
                    $startingColumn++;
                }
                $startingRow++;
            }
        endif;
        $this->startingColumnModel = $startingColumn;
    }


}
