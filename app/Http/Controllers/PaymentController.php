<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServicesRepo\Contracts\PayMethodsRepositoryInterface;

class PaymentController extends Controller
{
    //
    protected $pay;

    public function __construct(PayMethodsRepositoryInterface $pay)
	{
	    $this->pay = $pay;
	}

    public function paying(Request $request){
 
        $token  = $request['token'];
        $user_id  =$request['user_id'];
        $user_email  =$request['user_email'];
        $total_price  =$request['total'] * 100;
        $countrycode  =$request['countrycode'];
        $phonenumber  =$request['phonenumber'];
        $phone_complete = $countrycode.$phonenumber;

        $result = $this->pay->do_cardpay($token,$user_id,$user_email,$total_price);
        if($result['status']){
        	$result1 =  $this->pay->do_cashin($phone_complete,$total_price);
        	if($result1['status']){
        		$result2 =  $this->pay->save_tnx($user_id, $phone_complete, $total_price, 1, "c2m");
                $resp = ['status' => True,"message" =>"Card to Mobile done successfully"];
        	}
        }
        return $resp;
    }

    public function mobileTransfer(Request $request){
 
        $user_id  =$request['user_id'];
        $total_price  =$request['total'];
        $countrycode  =$request['countrycode'];
        $phonenumber  =$request['phonenumber'];
        $phone_complete = $countrycode.$phonenumber;

        $result =  $this->pay->do_cashout($user_id,$total_price);
        if($result['status']){
        	$result1 =  $this->pay->do_cashin($phone_complete,$total_price);
        	if($result1['status']){
        		$result2 =  $this->pay->save_tnx($user_id, $phone_complete, $total_price, 1, "m2m");
                $resp = ['status' => True,"message" =>"Mobile to Mobile Transfer done successfully"];
        	}
        }
        return $resp;
    }
}
