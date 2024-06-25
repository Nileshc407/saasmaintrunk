<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   QUICK ENROLLMENT
			  </h6>
			  <div class="element-box">
				<div class="col-sm-8">
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			<?php 	} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
					<?php 	} ?>
					
					<?php $attributes = array('id' => 'formValidate');
						echo form_open('Enrollmentc/fastenroll',$attributes); ?>	
					
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>First Name</label><input class="form-control" data-error="Please enter first name" placeholder="Enter first name"  type="text" name="fname" id="fname" required="required">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>  
					  
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Last Name</label><input class="form-control" data-error="Please enter last name" placeholder="Enter last name" type="text" name="lname" id="lname" required="required">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>  
					  
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Phone No. <span class="required_info">(Please enter without '+' and country code) </span></label>
						<input class="form-control" type="text" name="phno" id="phno" onkeyup="this.value=this.value.replace(/\D/g,'');" placeholder="Enter phone no."data-error="Please enter phone no." maxlength="9" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div>  
					  
					  <div class="form-group">
						<label class="col-sm-4 col-form-label">Email ID?</label>
						<div class="col-sm-8" style="margin-left:-0px; margin-top:7px;">
						
						  <div class="form-check" style="float:left;">
							<label class="form-check-label">
							<input class="form-check-input" name="email_validity" id=
							"email_validity" type="radio" onclick="mailgenrator(this.value);" value="1" data-error="Please select email id yes/no" required="required" checked>Yes</label>
						  </div>
						  
						  <div class="form-check" style="margin-left:50px;">
							<label class="form-check-label">
							<input class="form-check-input" name="email_validity" id="email_validity2" type="radio" onclick="mailgenrator(this.value);" value="0" data-error="Please select email id yes/no" required="required">No</label>
						  </div>
						  <div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					  </div>
					  
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>User Email Id</label>								
						<input class="form-control" type="email" name="userEmailId" id="userEmailId" placeholder="Enter email address" data-error="Please enter email address" required="required" onchange="validateEmail(this.value);">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block12"></div>
						
						
					  </div> 
					  
					  <div class="form-group">
						<label for=""> Membership ID</label>
					<?php if($Company_details->card_decsion == '1') 
					{ ?>
						<input class="form-control"  type="text" name="cardid" id="cardid" value="<?php echo $Company_details->next_card_no; ?>" readonly>
						<input type="hidden" name="card_decsion" id="card_decsion" value="<?php echo $Company_details->card_decsion; ?>">
					<?php } else { ?>
						<input class="form-control" type="text" maxlength="16" name="cardid" id="cardId" data-error="Please enter membership id"  placeholder="Membership ID" />
					<?php } ?>
						<div class="help-block form-text with-errors form-control-feedback" id="help-block3"></div>
					  </div> 
					  
					<?php
					if($Refrence == 1  && $referral_rule_count > 0)
					{ ?>		  
					  <div class="form-group">
						<label class="col-sm-4 col-form-label">Reference</label>
						<div class="col-sm-8" style="margin-left:-0px; margin-top:7px;">
						  <div class="form-check" style="float:left;">
							<label class="form-check-label"><input class="form-check-input" name="Refrence"  type="radio" value="1" onclick="hide_show_refrence(this.value);" data-error="Please select reference yes/no" required="required">Yes</label>
						  </div>
						  <div class="form-check" style="margin-left:50px;">
							<label class="form-check-label">
							<input class="form-check-input" name="Refrence" type="radio" value="0" onclick="hide_show_refrence(this.value);" data-error="Please select reference yes/no" required="required" checked>No</label>
						  </div>
						</div>
						 <div class="help-block form-text with-errors form-control-feedback"></div> 
					  </div>
					  
					  <div class="form-group" id="Refree" style="display:none;">
						<label for=""> Refree Membership ID </label><input class="form-control"  type="text" name="Refree_name" id="Refree_name" placeholder="Refree Membership ID" autocomplete="off">
						<div class="help-block11 form-text with-errors form-control-feedback" id="help-block11"></div>
						<input type="hidden" name="Enrollment_id" id="Enrollment_id" value="">
					  </div> 
					  <?php
					}
					?>
					  <div class="form-group">
						<label for=""> Hobbies/Interest</label>
						<select class="form-control select2" multiple="true" name="hobbies[]">
						<option value="">Select Hobbies/Interest</option>
						  <?php
								foreach($Hobbies_list as $hob)
								{
									echo "<option value=".$hob->Id.">".$hob->Hobbies."</option>";
								}
							?>
						</select>
					  </div>
					  
					  <div class="form-buttons-w" >
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					  
					<?php echo form_close(); ?>		  
				  </div>
			  </div>
			</div>
		  </div>
		</div>
	</div>
</div>			
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	if( $('#fname').val() != "" && $('#lname').val() != "" && $('#phno').val() != "" && $('#userEmailId').val() != "")
	{
		show_loader();
		return true;	
	} 
});

/*
$('#email_validity').click(function()
{
	$("#userEmailId").attr("required","required");
});

$('#email_validity2').click(function()
{
	$("#userEmailId").removeAttr("required");
});

function hide_show_email(email_validity)
{
	if(email_validity == 0)
	{
		$("#userEmailId").hide();
		$("#userEmailId2").show();
	}
	else
	{
		$("#userEmailId").show();
		$("#userEmailId2").hide();
	}
}
*/

function mailgenrator(rval)
{
	if(rval==0)
	{
		var phno = $("#phno").val();
		// var domain =  '<?php echo $Company_details->Domain_name; ?>';
		// var emailis = phno+"@"+domain;
		// $("#userEmailId2").val(emailis);
		
		if(phno!="")
		{ 
			var domain =  '<?php echo $Company_details->Domain_name; ?>';
			var emailis = phno+"@"+domain;
			$("#userEmailId").val(emailis);
			$("#userEmailId").removeClass("has-error");
			$('#userEmailId').css("border-color","#e8ebf2");
			$("#help-block12").html("");
		}
		else
		{
			var msg1 = 'Phone number is compulsary for non exist email id';
			$('#help-block12').show();
			$('#help-block12').html(msg1);
			$("#userEmailId").addClass("form-control has-error");
			// setTimeout(function(){ $('#help-block2').hide(); }, 3000);
			return false;
		} 
	}
	else if(rval==1)
	{
		var msg1 = 'Please enter email id';
		$("#userEmailId").val("");
		$('#help-block12').show();
		$('#help-block12').html(msg1);
		$("#userEmailId").addClass("form-control has-error");
	}
}
function validateEmail(emailID)
{
	if(emailID != "")
	{
		var n = emailID.indexOf("@");
		var n1 = emailID.lastIndexOf(".");
		//alert(n+"sdffd--"+n1);

		if(n < 0 || n1 < 0 || n1 < n)
		{
			document.getElementById("userEmailId").value = "";
			return false;
		}
	}
}
function hide_show_refrence(refree)
{
	if(refree == 1)
	{
		$("#Refree").show();
		$("#Refree_name").attr("required","required");
	}
	else
	{
		$("#Refree").hide();
		$("#Refree_name").removeAttr("required");
	}
}

$('#phno').blur(function()
{
	if( $("#phno").val() == "" )
	{
		var msg1 = 'Please enter phone number';
		$('#help-block1').show();
		$('#help-block1').html(msg1);
		$("#phno").addClass("form-control has-error");
		// setTimeout(function(){ $('#help-block1').hide(); }, 3000);
	}
	else
	{
		var Phone_no = $("#phno").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var Country_id = '<?php echo $Country_id; ?>';
		$.ajax({
			  type: "POST",
			  data: {Phone_no: Phone_no, Company_id: Company_id, Country_id: Country_id},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/check_phone_no",
			  success: function(data)
			  {
				if(data.length == 13)
				{
					$("#phno").val("");
					var msg1 = 'Already exist';
					$('#help-block1').show();
					$('#help-block1').html(msg1);
					$("#phno").addClass("form-control has-error");
					// setTimeout(function(){ $('#help-block1').hide(); }, 3000);
				}
				else
				{
					$("#phno").removeClass("has-error");
					$("#help-block1").html("");
				}
			  }
		});
	}
});

$('#userEmailId').blur(function()
{
	if( $("#userEmailId").val() == "")
	{
		var msg1 = 'Please enter email id';
		$('#help-block12').show();
		$('#help-block12').html(msg1);
		$("#userEmailId").addClass("form-control has-error");
		// setTimeout(function(){ $('#help-block12').hide(); }, 3000);
	}
	else
	{
		var userEmailId = $("#userEmailId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var userId = '1';

		$.ajax({
			  type: "POST",
			  data: {userEmailId: userEmailId, Company_id: Company_id, userId:userId},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/check_userEmailId",
			  success: function(data)
			  {
				if(data.length == 13)
				{
					$("#userEmailId").val("");
					var msg1 = 'Already exist';
					$('#help-block12').show();
					$('#help-block12').html(msg1);
					$("#userEmailId").addClass("form-control has-error");
					// setTimeout(function(){ $('#help-block2').hide(); }, 3000);
				}
				else
				{
					$("#userEmailId").removeClass("has-error");
					$("#help-block12").html("");
				}
			  }
		});
	}
});

$('#cardId').blur(function()
{
	var cardId = $("#cardId").val();
	if( $("#cardId").val() == "" )
	{	
		var msg1 = 'Please enter membership id.';
		$('#help-block3').show();
		$('#help-block3').html(msg1);
		setTimeout(function(){ $('#help-block3').hide(); }, 3000);
	}
	else if( $("#cardId").val() != "" )
	{
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			  type: "POST",
			  data: {cardid: cardId, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/check_card_id",
			  success: function(data)
			  {
					if(data.length == 13)
					{
						$("#cardId").val("");
						var msg1 = 'Already exist';
						$('#help-block3').show();
						$('#help-block3').html(msg1);
						$("#cardId").addClass("form-control has-error");
						// setTimeout(function(){ $('#help-block3').hide(); }, 3000);
					}
					else{
						$("#cardId").removeClass("has-error");
						$("#help-block3").html("");
					}
			  }
		});
	}
});


$("#Refree_name").autocomplete({
	source:"<?php echo base_url()?>index.php/Enrollmentc/autocomplete_customer_names", // path to the get_birds method
	change: function (event, ui)
	{
		if (!ui.item) { this.value = ''; }
	}
}); 

/*
$('#Refree_name').blur(function()
{	
	if( $("#Refree_name").val() != "" )
	{
		var CardId = $("#Refree_name").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Membership_id:CardId,Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Enrollmentc/Fetch_member_details",
			dataType: "json",
			success: function(json)
			{	
				if(json == 0)
				{
					$("#Refree_name").val("");
					var msg1 = 'Please enter valid membership id';
					$('#help-block11').show();
					$('#Ehelp-block11').html(msg1);
					setTimeout(function(){ $('#help-block11').hide(); }, 3000);
					return false;
				}
				else
				{
					if(json['Error_flag'] == 1001) // Status Is OK
					{	
						$('#Refree_name').val(json['Member_name']+'-'+json['card_id']);
					}
					else if(json['Error_flag'] == 2003) //Unable to Locate membership id
					{	
						$("#Refree_name").val("");
						var msg1 = 'Please enter valid membership id';
						$('#help-block11').show();
						$('#help-block11').html(msg1);
						setTimeout(function(){ $('#help-block11').hide(); }, 3000);
						return false;
					}						
				}
			}
		});
	}
	else
	{
		var msg1 = 'Please enter refree membership id';
		$('#help-block11').show();
		$('#help-block11').html(msg1);
		setTimeout(function(){ $('#help-block11').hide(); }, 3000);
		return false;
	}
}); */

$('#phno').bind("cut copy paste",function(e) {
  e.preventDefault();
});

$('#cardId').bind("cut copy paste",function(e) {
  e.preventDefault();
});

$('#userEmailId').bind("cut copy paste",function(e) {
  e.preventDefault();
}); 

</script>