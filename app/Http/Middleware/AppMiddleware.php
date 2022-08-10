<?php

namespace App\Http\Middleware;

use App\MemberLog;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;

class AppMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = [];

        /* Get Parameters List */
        $currentUrl = $request->fullUrl();
        $params = explode('?', $currentUrl);
        $tempParams = (array_key_exists(1, $params)) ? explode('&', $params[1]) : [];
        $params = [];
        if(!empty($tempParams)){
            foreach ($tempParams as $key => $param) {
                $name = explode('=', $param);
                $params[$key]['name'] = $name[0];
                $params[$key]['value'] = $name[1];
            }
        }
        $data['parameters'] = (!empty($params)) ? json_encode($params) : null;
        $data['ip_address'] = $request->ip();
        $data['url'] = $request->url();

        if(Cache::has('validated_member')) {
            $member = Cache::get('validated_member');
            $data['member_id'] = $member->MemberID;
//            $data['member_first_name'] = $member->Member_Fistname;
//            $data['member_last_name'] = $member->Member_Lastname;
        }
        MemberLog::create($data);
        return $next($request);
    }
}
