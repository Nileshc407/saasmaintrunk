<?php $this->load->view('front/header/header'); 
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}	
$Photograph = $Enroll_details->Photograph;
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}
?>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Application Information</h4>
        </div>
        <div class="modal-body">
          <p>Company work in progress... Will be up soon...Sorry for the inconvenience</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="redBtn w-100 text-center" data-dismiss="modal" onClick="window.location.href='<?php echo base_url()?>index.php/Cust_home/front_home';">OK</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal -->

<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/settings';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Promo Code</h1></div>
				<div class="leftRight"><button></button></div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom passChanWrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
			<?php
					if(@$this->session->flashdata('error_code'))
					{
					?>
						<div class="alert bg-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
						</div>
					<?php
					}
				?>
                <!--<h1 class="text-center pb-4">Change password</h1>-->
                <p class="text-center">Enter your Promo Code below to Get enefited</p>
				 <?php 
				 $data = array('onsubmit' => "return sumbitPromoCode()");  
					echo form_open_multipart('Cust_home/update_promocode_App', $data);?>
                    <div class="form-group">
					<label class="font-weight-bold">Promo Code</label>
                        <input type="text" class="form-control"  name="promo_code" id="promo_code" placeholder="Enter Promo Code" onblur="check_promo_code();" required="">
						<div class="help-block" style="float:center;"></div>
                    </div>                   
					<button type="submit" class="redBtn w-100 text-center mt-5">Submit</button>
			  <?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main> 

<?php $this->load->view('front/header/footer');  ?>
<!----------------------AMIT KAMBLE---LICENSE EXPIRY------------------------------------------------>
	<?php if(date('Y-m-d') > $_SESSION['Expiry_license']  ){ ?>
	<script>
		$('#myModal').modal('show');		
	</script>
<?php } ?>
<!------------------------------------------------------------------------------------------------------->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<!--Click to Show/Hide Input Password JS-->
	
<script>		
function check_promo_code()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var membership_id = '<?php echo $Enroll_details->Card_id; ?>';
	var Currentbalance = '<?php echo $Enroll_details->Current_balance; ?>';
	var promo_code = $('#promo_code').val();
	
	if( $("#promo_code").val() == "" )
	{	
		var msg1 = 'Please Enter Valid Promo Code';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { promo_code: promo_code, Company_id:Company_id,Enrollment_id: Enrollment_id,Current_balance:Currentbalance,membership_id:membership_id },
			url: "<?php echo base_url()?>index.php/Cust_home/check_promo_code",
			success: function(data)
			{
				if(data == 0)
				{	
					$("#promo_code").val("");
					 var msg1 = 'In-valid Promo Code';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
				}
				else
				{
					// $("#promo_code").val("");
					 var msg1 = 'Valid Promo Code';
					$('.help-block').show();
					$('.help-block').css("color","green");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
				}
			}
		});	
	}
}
function sumbitPromoCode()
{ 
	if($("#promo_code").val() =="")
	{
		var msg1 = 'Please Enter Valid Promo Code';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	else
	{	
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
		
		// document.PromoCode.submit();
	}
}
 </script>
