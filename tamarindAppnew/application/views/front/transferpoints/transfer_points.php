<?php
$this->load->view('front/header/header'); 

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
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url();?>index.php/Cust_home/front_home"><span>Transfer <?php echo $Company_Details->Currency_name; ?></span></a>
				</div>
			</div>
		</div>
	</header>
	<div class="custom-body">
		<div class="container">
			<div class="profile-box">
				<div class="avtar sm">
					<img src="<?php echo $Photograph; ?>" alt=""/>
				</div>
				<h2><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></h2>
				<div class="point">
					<span><?php echo $Current_point_balance; ?> <?php echo $Company_Details->Currency_name; ?></span>
				</div>
			</div>
		</div>
		<div class="login-box">
		<h2>Transfer <?php echo $Company_Details->Currency_name; ?> to:</h2>
			<form  name="TransferPoint" method="POST" action="<?php echo base_url()?>index.php/Cust_home/Transfer_confirmation" enctype="multipart/form-data" onsubmit="return form_submit();">	
				<div class="form-group">
					<div class="field-icon">
						<input type="text" id="Membership_id" name="Membership_id" onblur="Get_member();" class="form-control" placeholder="Enter Membership id or Phone Number" required />
						<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="16.689" height="10.908" viewBox="0 0 16.689 10.908">
						  <g id="noun_envelope_309620" transform="translate(-0.7 -6)"><g id="Group_455" data-name="Group 455" transform="translate(0.7 6)"><path id="Path_159" data-name="Path 159" d="M16.953,16.908H1.136A.43.43,0,0,1,.7,16.471V6.382A.463.463,0,0,1,1.136,6H16.953a.43.43,0,0,1,.436.436v10.09A.421.421,0,0,1,16.953,16.908ZM1.573,16.09h15V6.818h-15Z" transform="translate(-0.7 -6)" fill="#b7b7b7"/></g><g id="Group_456" data-name="Group 456" transform="translate(10.941 10.949)"><rect id="Rectangle_294" data-name="Rectangle 294" width="7.744" height="0.818" transform="matrix(0.738, 0.675, -0.675, 0.738, 0.552, 0)" fill="#b7b7b7"/></g><g id="Group_457" data-name="Group 457" transform="translate(0.892 10.949)"><rect id="Rectangle_295" data-name="Rectangle 295" width="0.818" height="7.744" transform="matrix(0.675, 0.738, -0.738, 0.675, 5.714, 0)" fill="#b7b7b7"/></g><g id="Group_458" data-name="Group 458" transform="translate(0.734 6)"><path id="Path_160" data-name="Path 160" d="M9.073,13.526c-.109,0-.164-.055-.273-.109L.947,6.709a.365.365,0,0,1-.164-.436A.41.41,0,0,1,1.165,6H16.926a.41.41,0,0,1,.382.273.424.424,0,0,1-.109.436L9.346,13.417A.3.3,0,0,1,9.073,13.526ZM2.31,6.818,9.073,12.6l6.763-5.781Z" transform="translate(-0.762 -6)" fill="#b7b7b7"/></g></g>
						</svg>
						</div>
						<div class="line"></div>
						<div class="help-block" style="float:center;"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="field-icon">
						<input type="text" id="Transfer_Points" name="Transfer_Points" onblur="Check_current_balance(this.value)" onkeyup="this.value=this.value.replace(/\D/g,'')" class="form-control" placeholder="<?php echo $Company_Details->Currency_name; ?> to Transfer" required />
						<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="17.496" height="13.866" viewBox="0 0 17.496 13.866">
									<g id="noun_transfer_370305" transform="translate(-7.5 -969.106)">
							<path id="Path_533" data-name="Path 533" d="M16.248,980.327h3.9v2.144l4.349-4.289-4.349-4.289v2.144h-7.8v2.144L8,973.894l4.349-4.289v2.144h3.9" transform="translate(0 0)" fill="none" stroke="#c1bdb7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
						  </g>
						</svg>
						</div>
						<div class="line"></div>
						<div class="help-block1" style="float:center;"></div>
					</div>
				</div>
				
				<div class="submit-field">
					<button type="submit" class="submit-btn">Initiate Transfer</button>
				</div>
				<input type="hidden" readonly id="Member_Enrollement_id" name="Member_Enrollement_id" >
				<input type="hidden" readonly  id="Member_Current_balance" name="Member_Current_balance" >
				<input type="hidden" readonly  id="Member_Membership_id" name="Member_Membership_id" >				 
				<input type="hidden" readonly id="Login_Enrollement_id" name="Login_Enrollement_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
				<input type="hidden" readonly  id="Login_Current_balance" name="Login_Current_balance" value="<?php echo $Enroll_details->Current_balance; ?>">
				<input type="hidden" readonly  id="Company_id" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
				<input type="hidden" readonly  id="Login_Membership_id" name="Login_Membership_id" value="<?php echo $Enroll_details->Card_id; ?>">
			</form>
		</div>
	</div>
<?php $this->load->view('front/header/footer');  ?>	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<script>
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