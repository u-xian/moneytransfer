<?php

namespace App\ServicesRepo;


use App\ServicesRepo\Contracts\PayMethodsRepositoryInterface;
use Illuminate\Container\Container as App;
use App\Customers;
use Carbon\Carbon;
use App\Transactions;
use Response;


class PayMethodsRepository implements PayMethodsRepositoryInterface
{

	protected $pay;

	public function __construct(App $pay)
	{
	    $this->pay = $pay;
	}

	public function do_cashin($msisdn, $amount)
	{
		if (!empty($msisdn) && !empty($amount)) {
            $mess = ['status' => True,"message" =>"Cashin done successfully"];
        }
        else{
        	$mess = ['status' => False,"message" =>"Cashin transaction failed"];
        }
		 
		 return  $mess;
	}

    public function do_cashout($user_id, $amount)
    {
        $customer = Customers::where('user_id', '=', $user_id)->first();

        if (($customer) && !empty($amount)) {
            $mess = ['status' => True,"message" =>"Cashout done successfully"];
        }
        else{
            $mess = ['status' => False,"message" =>"Cashout transaction failed"];
        }
         
         return  $mess;
    }

	public function do_cardpay($token,$user_id,$user_email,$total_price)
	{
        $customer = Customers::where('user_id', '=', $user_id)->first();
        
        if($customer->charge($total_price,
            [
                'source' => $token,
                'receipt_email' => $user_email
            ]))
        {
            $mess = ['status' => True,"message" =>"Payment ok"];
            
        }
        else{
            $mess = ['status' => False,"message" =>"Error submitting payment"];
        }
        return $mess;
	}

    public function save_tnx($sender_id, $receiver_number, $amount, $status, $transaction_type)
    {
        $customer = Customers::where('user_id', '=', $sender_id)->first();

        $input = [
            'sender_id' => $customer['id'],
            'receiver_number' => $receiver_number,
            'amount' => $amount,
            'status' => $status,
            'transaction_type' => $transaction_type,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        $tnx_result = Transactions::create($input);

        return Response::json(['status' => 'true','TransactionID'=>$tnx_result['id']]);

    }

}

?>