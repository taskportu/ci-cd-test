<?php

namespace App\Exports;

use App\Members;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MemberExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Members::select('members.*', 'hi.hcp')
                        ->leftJoin('hcpimp as hi', 'hi.occid', '=', 'members.OccID')
                        ->get();
    }

    public function headings(): array
    {
        return [
            'MemberID', 'OccID', 'Member_Fistname', 'Member_Lastname', 'HCP', 'new_hcp',
            'handicap', 'new_club', 'Active', 'member_type', 'address1', 'address2', 'zipcode',
            'city', 'email', 'image', 'email_billing', 'tel_privately', 'tel_jobs', 'phone_mobile',
            'sms_news_letter', 'sex', 'stock_number', 'playing_eligibility', 'date_of_birth',
            'member_since', 'resignation_date', 'additional_info', 'family_head', 'family_head_name',
            'family_head_no', 'shareholder_name', 'shareholder_member_no', 'wardrobe', 'drinks_cabinet',
            'stick_cabinet', 'car', 'charging_site', 'trolley_space', 'counted', 'expire_date',
            'share_type', 'share_number', 'app_hcp_status', 'HCP_imp'
        ];
    }

    public function title() : string
    {
        return 'Members';
    }

//    public function startCell(): string
//    {
//        return 'A3';
//    }
}
