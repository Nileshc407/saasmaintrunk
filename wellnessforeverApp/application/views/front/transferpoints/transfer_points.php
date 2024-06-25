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
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/front_home';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Transfer</h1></div>
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
                <p class="text-center"><?php echo $Current_point_balance; ?> <?php echo $Company_Details->Currency_name; ?></p>
				 <?php 
				 $data = array('onsubmit' => "return form_submit()");  
				echo form_open_multipart('Cust_home/Transfer_confirmation', $data);?>
                    <div class="form-group">
					<label class="font-weight-bold">Enter To Membership ID</label>
                        <input type="text"id="Membership_id" name="Membership_id" onblur="Get_member();" class="form-control" placeholder="Enter Membership id or Phone Number" required>
						<div class="help-block" style="float:center;"></div>
                    </div>
                    <div class="form-group">
					<label class="font-weight-bold">Transfer <?php echo $Company_Details->Currency_name; ?></label>
                        <input type="text" id="Transfer_Points" name="Transfer_Points" onblur="Check_current_balance(this.value)" onkeyup="this.value=this.value.replace(/\D/g,'')" class="form-control" placeholder="<?php echo $Company_Details->Currency_name; ?> to Transfer" required>
						<div class="help-block1" style="float:center;"></div>
                    </div>
                    
					<button type="submit" class="redBtn w-100 text-center mt-5">Initiate Transfer</button>
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
	<script type="text/javascript">
	function Get_member()
	{	
		var Login_Enrollement_id = '<?php echo $enroll; ?>';
		var Membership_id = $('#Membership_id').val();
		var Company_id = '<?php echo $Company_id; ?>';	

		if(Membership_id != "" && Company_id != "")
		{
			$.ajax({
				type: "POST",			 
				data: {Membership_id: Membership_id, Company_id:Company_id, Login_Enrollement_id:Login_Enrollement_id},
				url: "<?php echo base_url()?>index.php/Cust_home/get_member_details",
				success: function(data)
				{
					if(data == 0)
					{
						// $('#ToMemberDetails').hide();
						$('#Membership_id').val("");
						/* $('#Member_name').html("&nbsp;");
						$('#Member_email_id').html("&nbsp;");
						$('#Member_phone').html("&nbsp;"); */
						
						var msg1 = 'Please enter valid membership id/phone no.';
						$('.help-block').show();
						$('.help-block').css("color","red");
						$('.help-block').html(msg1);
						setTimeout(function(){ $('.help-block').hide(); }, 3000);
					}
					else
					{
						var Space = '&nbsp;';
						json = eval("(" + data + ")");
						if( (json[0].Enrollement_id) != 0 )
						{
							/*$('#ToMemberDetails').show();
							$('#Member_name').html(Space+' '+json[0].First_name+' '+json[0].Last_name);
							$('#Member_email_id').html(Space+' '+json[0].User_email_id);
							$('#Member_phone').html(Space+' '+json[0].Phone_no);
							document.getElementById("Member_Enrollement_id").value=(json[0].Enrollement_id);
							document.getElementById("Member_Current_balance").value=(json[0].Current_balance);
							document.getElementById("Member_Membership_id").value=(json[0].Card_id); */
						}
						else 
						{
							// $('#ToMemberDetails').hide();
							$('#Membership_id').val("");
							/*$('#Member_name').html("&nbsp;");
							$('#Member_email_id').html("&nbsp;");
							$('#Member_phone').html("&nbsp;");*/
						}
					}
				}
			});
		}
		else
		{
			// $('#ToMemberDetails').hide();
			$('#Membership_id').val("");
			/*$('#Member_name').html("&nbsp;");
			$('#Member_email_id').html("&nbsp;");
			$('#Member_phone').html("&nbsp;");*/
			
			var msg1 = 'Please enter valid membership id/phone no.';
			$('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg1);
			setTimeout(function(){ $('.help-block').hide(); }, 3000);
		}
	}

	function Check_current_balance(transPoints)
	{
		var login_curr_bal='<?php echo $Current_point_balance; ?>';
		if(parseFloat(transPoints) > parseFloat(login_curr_bal))
		{		
			document.getElementById('Transfer_Points').value='';
			var msg2 = 'Insufficient <?php echo $Company_Details->Alise_name; ?> Wallet Balance.';
			$('.help-block1').show();
			$('.help-block1').css("color","red");
			$('.help-block1').html(msg2);
			setTimeout(function(){ $('.help-block1').hide(); }, 3000);
			return false;
		}
	}
	function form_submit()
	{
		if($('#Membership_id').val() == "" || $('#Transfer_Points').val() == "")
		{
			if($('#Membership_id').val() == "")
			{
				var msg1 = 'Please enter valid membership id';
				$('.help-block').show();
				$('.help-block').css("color","red");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000);
				return false;
			}
			else if($('#Transfer_Points').val() == "")
			{
				var msg1 = 'Please enter transfer <?php echo $Company_Details->Currency_name; ?>';
				$('.help-block1').show();
				$('.help-block1').css("color","red");
				$('.help-block1').html(msg1);
				setTimeout(function(){ $('.help-block1').hide(); }, 3000);
				return false;
			}
		}
		else
		{  	
			/*setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},2000); */
		} 		
	}
</script>	
