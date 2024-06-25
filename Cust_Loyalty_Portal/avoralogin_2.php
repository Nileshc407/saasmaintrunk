<?php
error_reporting(0);

$result = "Enter text and public key";
$key = "!QAZXSW@#EDCVFR$";
$iv = '56666852251557009888889955123458';

if(isset($_POST['login']))
{
	
	/* Script to Encrypt */
	$UserEmail = string_encrypt($_POST['username'], $key, $iv);
	echo "Username is: $UserEmail <br>";
	$SearchPW = string_encrypt($_POST['password'], $key, $iv);
	echo "Password is: $SearchPW <br>";
	echo"<br><p> Decrypted Value is below: <p><br>";
	
	
	
	$UserEmailD = string_decrypt($_POST['username'], $key, $iv);
	echo "Decrypt Username is: $UserEmailD <br>";
	$SearchPWD = string_decrypt($_POST['password'], $key, $iv);
	echo "Decrypt Password is: $SearchPWD <br>";
	
	
	
	// $SearchPW = string_encrypt($_POST['username'], $key, $iv);
	// echo "Decrypt is: $SearchPW <br>";
	
}

function string_encrypt($string, $key, $iv)
{
   /*  $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    $padding = $block - (strlen($string) % $block);
    $string .= str_repeat(chr($padding), $padding);

    $crypted_text = mcrypt_encrypt
                    (
                        MCRYPT_RIJNDAEL_256, 
                        $key, 
                        $string, 
                        MCRYPT_MODE_CBC, $iv
                    );
    return base64_encode($crypted_text); */
	
	
$version = phpversion();
		//echo "-------version----".$version."---------------<br>";
		$new_version=  substr($version, 0, 1);
	
		//echo "-------new_version----".$new_version."---------------<br>";
		if($new_version >= 7) {
				
				$first_key = base64_decode($key);
				$second_key = base64_decode($key);    

				$method = "aes-256-cbc";    
				$iv_length = openssl_cipher_iv_length($method);
				$iv = openssl_random_pseudo_bytes($iv_length);

				$first_encrypted = openssl_encrypt($string,$method,$first_key, OPENSSL_RAW_DATA ,$iv);    
				$second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

				$output = base64_encode($iv.$second_encrypted.$first_encrypted);    
				// echo "--input---output--".$output."------<br><br>";
		
				return $output;
				
		} else {
				
				$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
				$padding = $block - (strlen($string) % $block);
				$string .= str_repeat(chr($padding), $padding);

				$crypted_text = mcrypt_encrypt
					(
						MCRYPT_RIJNDAEL_256, 
						$key, 
						$string, 
						MCRYPT_MODE_CBC, $iv
					);
	return base64_encode($crypted_text);
		}
								
								
								
}

function string_decrypt($encrypted_string, $key, $iv)
{
    /* return mcrypt_decrypt
            (
                MCRYPT_RIJNDAEL_256, 
                $key, 
                base64_decode($encrypted_string), 
                MCRYPT_MODE_CBC, $iv
            ); */
			
			
					
			/* 	echo "-------string_decrypt--------------<br>";
				echo "-------encrypted_string----".$encrypted_string."---------------<br>";
				echo "-------key----".$key."---------------<br>";
				echo "-------iv----".$iv."---------------<br>"; */

			$version = phpversion();
		// echo "-------version----".$version."---------------<br>";
			$new_version=  substr($version, 0, 1);
		
		// echo "-------new_version----".$new_version."---------------<br>";
			if($new_version >= 7) {
					
								
					$first_key = base64_decode($key);
					$second_key = base64_decode($key);            
					$mix = base64_decode($encrypted_string);

					$method = "aes-256-cbc";    
					$iv_length = openssl_cipher_iv_length($method);

					$iv = substr($mix,0,$iv_length);
					$second_encrypted = substr($mix,$iv_length,64);
					$first_encrypted = substr($mix,$iv_length+64);

					$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);


					// echo "--Output-data--".$data."------<br><br>";

					return $data;
					
			} else {
					
							return mcrypt_decrypt
								(
									MCRYPT_RIJNDAEL_256, 
									$key, 
									base64_decode($encrypted_string), 
									MCRYPT_MODE_CBC, $iv
								);
					
			}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Avora Login Service</title>
</head>

<body>

<form action="avoralogin_2.php" method="post" id="wsdl_login">
<fieldset>
  <table width="496" height="105" border="0" align="center" cellpadding="2" cellspacing="2" id="login">
  	<th colspan="2"><?php echo "$result"; ?></th>
    <tr>
      <td width="176" height="30"><strong>Username</strong></td>
      <td width="304"></textarea><input type="text" name="username" id="password" /></td>
    </tr>
    <tr>
      <td height="29"><strong>Password</strong></td>
      <td><input type="password" name="password" id="password" /></td>
    </tr>
    <tr>
		<td><strong>Response</strong></td>    
        <td><textarea name="response" id="response" style="margin: 0px; height: 220px; width: 573px;"><?php if(isset($response)) echo $response; ?></textarea></td>
    </tr>
    <tr> 
      <td height="38">&nbsp;</td>
      <td><input type="submit" name="login" id="login" value="Login" /></td>
    </tr>
  </table>
</fieldset>
</form>

</body>
</html>