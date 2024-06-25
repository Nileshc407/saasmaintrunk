<?php //defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('App_string_encrypt'))
{

	/***************************************** user info encryption 20-01-2020 *******************************************/
	function App_string_encrypt($string)
	{
		$cipher = "aes-256-gcm";

		$message = 'opensesame';
		// Salt to add entropy to users' supplied passwords
		// Make sure to add complexity/length requirements to users passwords!
		// Note: This does not need to be kept secret
		$salt = "033ebc1f7e02174e4b386ee7981de53fa6adea5f";//sha1(mt_rand());

		// Initialization Vector, randomly generated and saved each time
		// Note: This does not need to be kept secret
		$iv = "906dc483564123d3";//substr(sha1(mt_rand()), 0, 16);

		//echo "\n Password: $password \n Salt: $salt \n IV: $iv\n";

		$encrypted = openssl_encrypt(
		  "$string", 'aes-256-cbc', "$salt:$message", null, $iv
		);

		$msg_bundle = "$salt:$iv:$encrypted";
		
		return $msg_bundle;
	}
	
}
if ( ! function_exists('App_string_decrypt'))
{
	function App_string_decrypt($saved_bundle)
	{
		$cipher = "aes-256-gcm";

		$message = 'opensesame';
		
		//echo "strlen--".strlen($msg_bundle);
		// Parse iv and encrypted string segments
		$components = explode( ':', $saved_bundle );

		//var_dump($components);

		$salt          = $components[0];
		$iv            = $components[1];
		$encrypted_msg = $components[2];

		$decrypted_msg = openssl_decrypt(
		  "$encrypted_msg", 'aes-256-cbc', "$salt:$message", null, $iv
		);

		if ( $decrypted_msg === false ) {
		  die("Unable to decrypt message! (check password) \n");
		}

		$msg = substr( $decrypted_msg, 41 );
		return $decrypted_msg;
	}
	/***************************************** user info encryption 20-01-2020 *******************************************/
}
?>
