<?php

namespace DM\SSO\Http\Middleware;

use Closure;
use Carbon\Carbon;
use DM\SSO\Models\SsoTicket;
use Encore\Admin\Facades\Admin;

class SSOLoginWithTicket
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
        $app_id = config('sso.app_id');
        $user = Admin::user();
        if(isset($user)){
            // 存入sso_ticket
            $sso_ticket = SsoTicket::where(['user_id'=>$user->id,'app_id'=>$app_id])->first();
            // 存在，但是过期，更新过期时间
            if(isset($sso_ticket) && $sso_ticket->expire_at < now()){
                $sso_ticket->expire_at = Carbon::now()->addMinutes(5); // 5分钟到期时间
                $sso_ticket->ticket = str_random(64);
            }
            // 如果不存在
            if(!isset($sso_ticket)){
                $sso_ticket = new SsoTicket;
                $sso_ticket->user_id = $user->id;
                $sso_ticket->app_id = $app_id;
                $sso_ticket->ticket = str_random(64);
                $sso_ticket->expire_at = Carbon::now()->addMinutes(5); // 5分钟到期时间
            }
            
            $sso_ticket->save();
        }

        return $next($request);
    }
}
