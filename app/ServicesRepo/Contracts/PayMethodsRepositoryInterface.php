<?php
// app/ServicesRepo/Contracts/PayMethodsRepositoryInterface.php

namespace App\ServicesRepo\Contracts;

interface PayMethodsRepositoryInterface
{
	public function do_cashin($msisdn, $amount);

    public function do_cashout($user_id, $amount);

    public function do_cardpay($token,$user_id,$user_email,$total_price);

    public function save_tnx($sender_id, $receiver_number, $amount, $status, $transaction_type);
}

?>