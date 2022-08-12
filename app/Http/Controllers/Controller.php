<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $smsApi = 'https://fsonline.no/smsgateway.php?key=9kakk-anda4811-oiaei';

    public function sendingSms($title, $phone, $message) {
        $url = $this->smsApi.'&avs='.$title.'&dest='.$phone.'&msg='.$message;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
    }
}
