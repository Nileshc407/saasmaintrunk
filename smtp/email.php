<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

//PHPMailer Object
$mail = new PHPMailer(true); 
$mail->SMTPDebug = 3;                               

 $mail->isSMTP();                                     
 $mail->Host = 'smtp.gmail.com'; 
$mail->SMTPAuth = true;       
$mail->SMTPSecure = 'tls';                         
$mail->Username = 'shivanshchoudhari02@gmail.com';               
$mail->Password = 'Shivansh@2022';                          
$mail->Port = 587; 
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->WordWrap = 50;  

$mail->From = 'shivanshchoudhari02@gmail.com';
$mail->FromName = 'Mailer';
$mail->addAddress('nileshchoudhari91@gmail.com', 'nilesh c');     // Add a recipient
$mail->addAddress('nileshc@miraclecartes.com');               // Name is optional
$mail->addReplyTo('nileshc@miraclecartes.com', 'Information');


$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}