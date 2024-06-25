<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Avora Login Service</title>
</head>

<body>

<form action="string_encrypt.php" method="post" id="wsdl_login">
<fieldset>
  <table width="496" height="105" border="0" align="center" cellpadding="2" cellspacing="2" id="login">
  	<th colspan="2"><?php //echo "$result"; ?></th>
    <tr>
      <td width="176" height="30"><strong>Enter decrypt string</strong></td>
      <td width="304"></textarea><input type="text" name="username" id="password" /></td>
    </tr>
    <tr>
      <td height="29"><strong>Enter decrypt string</strong></td>
      <td><input type="password" name="password" id="password" /></td>
    </tr>
    <tr> 
      <td height="38">&nbsp;</td>
      <td><input type="submit" name="login" id="login" value="Submit" /></td>
    </tr>
  </table>
</fieldset>
</form>

</body>
</html>
<?php
error_reporting(0);
$result = "Enter text and public key";
$key = "!QAZXSW@#EDCVFR$";
$iv = '56666852251557009888889955123458';

if(isset($_POST['login']))
{
	
	/* Script to Encrypt */
	$UserEmail = string_encrypt($_POST['username'], $key, $iv);
	echo "Encrypt string is: $UserEmail <br>";
	$SearchPW = string_encrypt($_POST['password'], $key, $iv);
	echo "Encrypt string is: $SearchPW <br>";
	
}

function string_encrypt($string, $key, $iv)
{
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

function string_decrypt($encrypted_string, $key, $iv)
{
    return mcrypt_decrypt
            (
                MCRYPT_RIJNDAEL_256, 
                $key, 
                base64_decode($encrypted_string), 
                MCRYPT_MODE_CBC, $iv
            );
}


?>