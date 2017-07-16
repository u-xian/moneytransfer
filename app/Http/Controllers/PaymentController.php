<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServicesRepo\PayMethodsRepository;

use App\Customers;

class PaymentController extends Controller
{
    //
    protected $pay;

    public function __construct(PayMethodsRepository $pay)
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
        	}
        }
        return $result1;
    }

    public function show(Request $request)
	{
		$msisdn  = $request['receiver_number'];
        $amount  =$request['amount'];

		$result =  $this->pay->do_cashing($msisdn,$amount);
		return $result['status'];
	}

	public function test(Request $request)
	{
		$sender_id  = $request['sender_id'];
        $receiver_number  =$request['receiver_number'];
        $amount  =$request['amount'];
        
        $result2 =  $this->pay->save_tnx($sender_id, $receiver_number, $amount, 1, "c2m");
        
		return $result2;
	}
}
