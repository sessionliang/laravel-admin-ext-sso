<?php

namespace DM\SSO\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Encore\Admin\Controllers\AuthController;
use DM\SSO\Models\SsoTicket;
use Encore\Admin\Facades\Admin;

class SSOController extends AuthController
{
    public function sso(Request $request, $ticket)
    {
        try{
            $sso_ticket = SsoTicket::where(['ticket'=>$ticket])->whereTime('expire_at','>',now())->first();
            // dump($sso_ticket->user_id);
            if(isset($sso_ticket)){
                $user = $this->guard()->loginUsingId($sso_ticket->user_id);
                // dump($user);
                return $this->sendLoginResponse($request);
            }
            else{
                return redirect('auth/login');
            }
        }
        catch(\Exception $e){
            dump($e);
        }
    }

    /**
     * 获取跳转到app_id的url
     *
     * @param [type] $app_id
     * @return void
     */
    public static function redirectTo($app_id){
        $user = Admin::user();
        $sso_client = SsoClient::where(['app_id' => $app_id])->first();
        if(isset($sso_client) && isset($user)){
            $sso_ticket = SsoTicket::where(['user_id'=>$user->id,'app_id'=>$app_id])->whereTime('expire_at','>',now())->first();
            if(isset($sso_ticket)){
                return $sso_client->domain.'/admin/sso/'.$sso_ticket->ticket;
            }
        }
        return '';
    }
}