<?php 
error_reporting(0); 

session_start();

require('config/config.php');
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

	$final = $amount*100;
	$displayCurrency = $currency;

	$api = new Api($keyId, $keySecret);
// 3456
	$orderData = [
		'receipt'         => rand(1000,9999).'ORD',
		'amount'          => $final ,
		'currency'        => $currency,	
		'payment_capture' => 1 ];
		
	$razorpayOrder = $api->order->create($orderData);

	$razorpayOrderId = $razorpayOrder['id'];

	$displayAmount = $final;
	
/*********************************************/	
	$ci_object = &get_instance();
	$ci_object->load->model('Saas_model');
	$post_dataz = array('Razorpay_order_id' => $razorpayOrderId); 			
	$UpdatePayment = $ci_object->Saas_model->Update_payment_details($order_no,$post_dataz);
/*********************************************/

	if ($displayCurrency !== 'INR') {
		/* $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
		$exchange = json_decode(file_get_contents($url), true);

		$displayAmount = $exchange['rates'][$displayCurrency] * $_SESSION['finalamount'] / 100; */
		
		$displayAmount = $final / 100;
	}

	$data = [
		"key"               => $keyId,
		"amount"            => $displayAmount,
		"name"              => $name,
		"email"              => $email,
		"contact"              => $contact,
		"description"       => "online payment",
		"image"             => "",
		"prefill"           => ["name" => $name,"email" => $email,"contact" => $contact,],
		"notes"             => ["address" => $address,"merchant_order_id" => $order_no,],
		"theme"             => ["color" => "#158694"],
		"order_id"          => $razorpayOrderId,
		"callback_url" 		=>$callback_url, 
		"redirect"=> true,
	];

	if ($displayCurrency !== 'INR')
	{
		$data['display_currency']  = $displayCurrency;
		$data['display_amount']    = $displayAmount;
	}

	$json = json_encode($data);
	//echo $json;
	require("checkout/manual.php");
?>