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
// var_dump($_POST); die;
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

$sess_array2 = array('Razorpay_payment_id' => $razorpay_payment_id, );
			
$this->session->set_userdata('Payment_session', $sess_array2);

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

	$post_dataz = array(
						'Payment_email' => $payment_email,
						'Payment_contact' => $payment_contact,
						'Razorpay_order_id' => $razorpay_order_id,
						'Razorpay_payment_id' => $razorpay_payment_id,
						'Razorpay_signature' => $razorpay_signature,
						'Payment_status' => $payment_status,
						'Description' => $error_description
					);
					
	$Update_payment = $ci_object->Saas_model->Update_payment_details($payment_merchant_order_id,$post_dataz);
	
	if($payment_status == "captured")
	{
			$Survey_analysis = 0;
			$Call_center_flag = 0;
			$Callcenter_query_ticketno_series = 0;
			
			
			if($New_license_type==120)//Enhance
			{
				$Survey_analysis = 1;
				$Call_center_flag = 1;
						  //----------------------------------------------------
					/** *************Callcenter_query_ticketno_series GENERATE*************** */
					  $characters = '0123456789';
					  $string = '';
					  $Callcenter_query_ticketno_series = "";
					  for ($i = 0; $i < 8; $i++) {
						$Callcenter_query_ticketno_series .= $characters[mt_rand(0, strlen($characters) - 1)];
					  }
					  //----------------------------------------------------
				
			}
		$post_datax = array(
					'Survey_analysis' => $Survey_analysis,
					'Call_center_flag' => $Call_center_flag,
					'Callcenter_query_ticketno_series' => $Callcenter_query_ticketno_series,
					'Company_License_type' => $New_license_type,
					'Company_Licence_period' => $Period,
					'Update_user_id' => $Enrollement_id,
					'Update_date_time' => date('Y-m-d H:i:s')
				);
		$Update = $ci_object->Saas_model->Update_saas_company($Company_id,$post_datax);
		
		if($Company_License_type != $New_license_type)
		{
			$DeleteMenu = $ci_object->Saas_model->Delete_company_menu_assign($Company_id);
			
			$All_Saas_menus = $ci_object->Saas_model->Get_saas_company_menus($New_license_type);
			if($All_Saas_menus != NULL)
			{
				foreach($All_Saas_menus as $menu)
				{
					// Assign to Saas Company
					$Menu_array = array(
						'Company_id' => $Company_id,
						'Menu_id' => $menu->Menu_id,
						'Menu_level' => $menu->Menu_level,
						'Menu_name' => $menu->Menu_name,
						'Parent_menu_id' => $menu->Parent_menu_id,
						'Menu_href' => $menu->Menu_href,
						'Active_flag' => 1
					);
					$insert_saas_company_menus = $ci_object->Saas_model->insert_company_menus($Company_id,$Menu_array);
					
					//******************************** Assign to Super Seller********************************
					$post_data = array(					
						'Company_id' => $Company_id,
						'User_type_id' => 2,
						'Enrollment_id' => $Enrollement_id,
						'Menu_id' => $menu->Menu_id,
						'Menu_level' => $menu->Menu_level,
						'Parent_id' => $menu->Parent_menu_id
					);
					$result2 = $ci_object->Saas_model->assign_menu($post_data);
					
						//******************************** Assign privileges to Super Seller**********************
					$post_data3 = array(					
						'Company_id' => $Company_id,
						'User_type_id' => 2,
						'Enrollment_id' => $Enrollement_id,
						'Menu_id' => $menu->Menu_id,
						'Add_flag' => 1,
						'Edit_flag' => 1,
						'View_flag' => 1,
						'Delete_flag' => 1
					);
					$result23 = $ci_object->Saas_model->assign_menu_privileges($post_data3);
					
				}
			}
		}
	}
} 
?>
<script>
	window.location='<?php echo $base_url.'index.php/Register_saas_company/UpgradePlan'; ?>';
</script>
<?php
if ($success === true)
{ ?>
<html>
	<body>
		<section class="pay-thnx " style="min-height: 600px !IMPORTANT;; padding-top:40px; " >
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php if($mesgcolor =="green") { ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $error_description; ?>
						</div>
						<?php } else { ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $error_description; ?>
						</div>
						<?php } ?>
						<a href="<?php echo $base_url; ?>"><button class="btn btn-primary">Click Here</button></a>
					</div>
				</div>
			</div>
		</section>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
	</body>
</html>
<?php 
} 
else
{  ?>
	<html>
	<body>
		<section class="pay-thnx " style="min-height: 600px !IMPORTANT;; padding-top:40px; " >
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $error; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
	</body>
</html>
<?php
} 	
?>
<?php $this->load->view('header/footer'); ?>
<style>
.button {
  background-color: #1b55e2; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
</style>