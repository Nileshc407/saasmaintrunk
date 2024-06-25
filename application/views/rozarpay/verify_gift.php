<?php 
$this->load->view('header/header');

error_reporting(0); 

session_start();
require('config/config.php');
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$success = true;
$error = "Payment Failed";

$api = new Api($keyId, $keySecret);

if(empty($_POST['razorpay_payment_id']) === false)
{
	$razorpay_payment_id = $_POST['razorpay_payment_id'];
	$razorpay_order_id = $_POST['razorpay_order_id'];		
    $razorpay_signature = $_POST['razorpay_signature'];

	$error_description = "Your payment has been successfully processed. The payment invoice has been sent to your registered email.";
	$mesgcolor = 'green';
}
else
{
	foreach($_POST as $key => $values) {
		$error_description = $values['description']; 
		$metadata = json_decode($values['metadata']);
		
		$razorpay_payment_id = $metadata->payment_id;
		$razorpay_order_id = $metadata->order_id;
	}
			
    $razorpay_signature = "";
	$mesgcolor = 'red';
}

$sess_array3 = array('Razorpay_payment_id' => $razorpay_payment_id);
			
$this->session->set_userdata('Gift_payment_session', $sess_array3);

if (empty($_POST['razorpay_payment_id']) === false)
{
    try
    {
        $attributes = array(			
            'razorpay_order_id' => $_POST['razorpay_order_id'],			
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );
		
        $e_id = "E".time();
        $date = date('Y-m-d');

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
		$mesgcolor = 'red';
    }
}

$payment =$api->payment->fetch($razorpay_payment_id);

if($payment !=Null)
{
	$razorpay_payment_id = $payment['id'];
	$razorpay_order_id = $payment['order_id'];
	$payment_amount = $payment['amount'];
	$payment_currency = $payment['currency'];
	$payment_status = $payment['status'];
	$payment_email = $payment['email'];
	$payment_contact = $payment['contact'];
	$payment_notes = $payment['notes'];
	$payment_merchant_order_id = $payment['notes']['merchant_order_id'];


	$ci_object = &get_instance();

	$ci_object->load->model('Saas_model');

	$post_dataX = array(
						'Payment_email' => $payment_email,
						'Payment_contact' => $payment_contact,
						'Razorpay_order_id' => $razorpay_order_id,
						'Razorpay_payment_id' => $razorpay_payment_id,
						'Razorpay_signature' => $razorpay_signature,
						'Payment_status' => $payment_status,
						'Description' => $error_description
					);
					
	$Update_payment = $ci_object->Saas_model->Update_payment_details($payment_merchant_order_id,$post_dataX);
} 
?>
<script>
	window.location='<?php echo $base_url.'index.php/Gift_payment'; ?>';
</script>
<?php $this->load->view('header/footer'); ?>