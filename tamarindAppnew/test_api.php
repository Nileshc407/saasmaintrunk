<?php
 
$fields = array(
			'Company_username' =>'etihadairways',
			'Company_password' =>'D8NXKvUWlHVyv5qsIT3QyhLHStRu1ebo1xfKXC1RExM=',
			'Beneficiary_name' =>'IhNEC4OTQwwQSuD2SdGwOzp212uKZcucz51Odey63Fw=',
			'Beneficiary_membership_id' =>'jnAXnWoQ5rkeiY03dQLrD7pK0ruq7eOi1hEIk3UhiR0=',
			'flag' =>'w/xOS/nYeyg1jrtvDV81Um88AL8TALAEeiPxVZdx+tM=' 
		);
		
		
		 
$url="https://live.igainapp.in/Company_2/Joycoins_API/joyapi.php";	

$field_string = $fields;
// var_dump($field_string);
// $field_string = json_encode($field_string);

$ch = curl_init();
$timeout = 0; // Set 0 for no timeout.
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER , "Content-Type: application/json");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field_string));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$result = curl_exec($ch);

if(curl_errno($ch))
{
	print "Error: " . curl_error($ch);
}
if (!curl_errno($ch)) {
	
  $info = curl_getinfo($ch);
  echo '----Took ', $info['total_time'], ' seconds to send a request to ', $info['url'], "--<br>";
}

curl_close($ch);
echo $result;
$response = json_decode($result, true);
echo json_encode($response); 



// https://joy1.igainapp.in/Joycoins/index.php/Beneficiary/Add_Beneficiary_details?Beneficiary_company_id=1*0&Beneficiary_company_id=1&Igain_company_id=0&Beneficiary_name=Ravikumar Phad&Beneficiary_membership_id=10001


// https://joy1.igainapp.in/Joycoins/index.php/Beneficiary/Add_Beneficiary?Beneficiary_company_id=1*0&Beneficiary_company_id=1&Igain_company_id=0&Beneficiary_name=Ravikumar%20Phad&Beneficiary_membership_id=10001