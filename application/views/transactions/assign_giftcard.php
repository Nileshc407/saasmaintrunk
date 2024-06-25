<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">ASSIGN GIFT CARD</h6>
                    <div class="element-box">
                        <?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
				
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>


                        <?php
                          $attributes = array('id' => 'formValidate');
                          echo form_open('Transactionc/assign_giftcard', $attributes);
                        ?>
						<div class="col-sm-8">
							<div class="form-group">
								<label for=""> <span class="required_info">*</span> Gift Card Number. </label>
								<input class="form-control" data-error="Enter Gift Card Number" placeholder="Enter Gift Card Number" required="required" type="text" name="gif_number" id="gif_number" onkeypress="return isNumberKey2(event)">
								<div class="help-block form-text with-errors form-control-feedback" id="GifNumber"> </div>
							</div>
							<div class="form-group">
								<label for=""> <span class="required_info">*</span> Gift Card Balance. </label>
								<input class="form-control" data-error="Enter Gift Card Balance" placeholder="Enter Gift Card Balance" required="required" type="text" name="gif_balance" id="gif_balance" onkeypress="return isNumberKey2(event)">
								<div class="help-block form-text with-errors form-control-feedback" id="CardBalance"> </div>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"><span class="required_info">*</span>Is it Enrolled Member ?</label>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<label class="radio-inline">
									<input type="radio" data-error="Please Select"  name="Enroll_flag" id="inlineRadio1" onclick="javascript:showhide(this.value);"  value="1" checked >Yes</label>
									&nbsp;
								<label class="radio-inline">
									<input type="radio" name="Enroll_flag" id="inlineRadio2" data-error="Please Select" onclick="javascript:showhide(this.value);" value="0">No
								</label>
								<div class="help-block form-text with-errors form-control-feedback" id="EnrollFlag"> </div>
							</div>
							<div class="form-group" id="block1" >
								<label for=""> <span class="required_info">*</span> Membership Card ID. </label>
								<input class="form-control" data-error="Enter Membership ID" required="required"  placeholder="Enter Membership ID"  type="text" name="CardID" id="cardId">
								<div class="help-block form-text with-errors form-control-feedback" id="MembershipID"> </div>
							</div>
							
							<div id="Member_details">
							
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>Member Name</label>
										<input type="text" id="member_name" class="form-control" placeholder="Member Name" readonly />	
									</div>									
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>Member Email ID</label>
										<input type="text" id="member_email" class="form-control" placeholder="Member Email ID" readonly />	
									</div>									
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>Member Phone No.</label>
										<input type="text" id="member_phn" class="form-control" placeholder="Member Phone No." readonly />	
									</div>
									
							</div>
							<div id="block2" style="display:none;">							
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>User Name</label>
										<input type="text" data-error="Enter User Name"  name="user_name" id="username" class="form-control" placeholder="Enter User Name"  />
										<div class="help-block form-text with-errors form-control-feedback" id="UserName"> </div>										
									</div>									
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>User Email Address</label>
										<input type="email" name="user_email" id="user_email"  data-error="Enter User Email Address" class="form-control" placeholder="Enter User Email Address"  />	
										<div class="help-block form-text with-errors form-control-feedback" id="UserEmail"> </div>
										
									</div>									
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>User Phone No.<span class="required_info">(Please enter without '+' and country code)</span></label>
										<input type="text" name="user_phno" id="phno" data-error="Enter User Phone No"  onkeyup="this.value=this.value.replace(/\D/g,'')"  class="form-control" placeholder="User Phone No."  />	
										<div class="help-block form-text with-errors form-control-feedback" id="UserPhone"> </div>
									</div>
									
							</div>	
							<div class="form-group"  >
								<label for="exampleInputEmail1"><span class="required_info">*</span>Payment By </label>
								<select class="form-control" name="Payment_type" id="Payment_type"   onchange="show_payment(this.value)" >
									<?php
										foreach($Payment_array as $Payment)
										{
											if($Payment->Payment_type_id != 4 && $Payment->Payment_type_id != 6)
											{
											echo "<option value=".$Payment->Payment_type_id.">".$Payment->Payment_type."</option>";
											}
										}
									?>
								</select>							
							</div>
							
							<div class="form-group" id="mpesa_block" style="display:none;">
										<label ><span class="required_info">*</span>Mpesa Code</label>
										<input type="text" name="Mpesa_code" id="Mpesa_code" data-error="Enter Mpesa Code" class="form-control" placeholder="Enter Mpesa Code"  />	
										<div class="help-block form-text with-errors form-control-feedback" id="MpesaNumber"> </div>
								</div>	
								
							<div id="cheque_block" style="display:none;">	
								<label for="exampleInputEmail1" id="payment_header">Cheque Details</label>
								<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>Bank Name</label>
										<input type="text" name="Bank_name" id="Bank_name"  data-error="Enter Bank Name"  class="form-control" placeholder="Enter Bank Name"  />	
										<div class="help-block form-text with-errors form-control-feedback" id="BankName"> </div>
								</div>
								<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>Branch Name of Bank</label>
										<input type="text" name="Branch_name" id="Branch_name"  data-error="Enter Branch Name of Bank"   class="form-control" placeholder="Enter Branch Name of Bank"  />	
										<div class="help-block form-text with-errors form-control-feedback" id="BranchName"> </div>
								</div>
								<div class="form-group">
										<label for="exampleInputEmail1" id="labelME"><span class="required_info">*</span>Cheque/Credit Card Number</label>
										<input type="text" name="Cheque_no" id="Cheque_no"  data-error="Enter Cheque/Credit Card Number" class="form-control" placeholder="Enter Cheque/Credit Card Number"  />	
										<div class="help-block form-text with-errors form-control-feedback" id="CardNumber"> </div>
								</div>								
							</div>
					
							<div class="form-buttons-w">
								<button class="btn btn-primary" id="submit" type="submit"> Submit</button>
								<button type="reset" class="btn btn-primary">Reset</button>
							</div>
                        </div>
						
                        <?php echo form_close(); ?>
                    </div>
                </div>
				<!-------------------- START - Data Table -------------------->	  
			<?php if($results != NULL) { ?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Gift Card Details
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Gift Card</th>
                                        <th>Gift Card Balance</th>
                                        <th>Email ID</th>
										<th>Phone No.</th>
										<th>Walk-in Member</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Gift Card</th>
                                        <th>Gift Card Balance</th>
                                        <th>Email ID</th>
										<th>Phone No.</th>
										<th>Walk-in Member</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                      <?php
                                      
                                          foreach($results as $row)
                                          {
                                             
											  // echo"--Gift_card_id--".$row->Gift_card_id;
                                             $Todays_date=date("Y-m-d");
                                           ?>
                                        <tr>
                                           
                                          								
                                            <td><?php echo $row->User_name;?></td>									
											<td><?php echo $row->Gift_card_id;?></td>
											<td><?php echo $row->Card_balance;?></td>
											<td><?php echo App_string_decrypt($row->Email);?></td>
											<td><?php echo App_string_decrypt($row->Phone_no);?></td>
											<td><?php if($row->Card_id==0){echo "Yes";}else{echo "No";}?></td>
                                        </tr>
                                      <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                 <?php } ?>
                
                <!--------------------  END - Data Table  -------------------->
            </div>
        </div>
    </div>	
</div>

<?php $this->load->view('header/footer'); ?>

<script>
$('#submit').click(function()
{
	
	/* if($('#inlineRadio1').is(":checked")== false  || $('#inlineRadio2').is(":checked") == false){
		$("#EnrollFlag").html("Please select it is enrolled member");
		return false
	} else {
		$("#EnrollFlag").html("");
	} */

	if( $('#gif_number').val() != "" && $('#gif_balance').val() != "" && $('#inlineRadio1').val() != "" )
	{		
		if( ($('#inlineRadio1').is(":checked") == true) )
		{
			if($('#cardId').val() != "")
			{
				if($('#Payment_type').val() == 2 || $('#Payment_type').val() == 3)
				{
					if($('#Bank_name').val() != "" && $('#Branch_name').val() != "" && $('#Cheque_no').val() != "")
					{
						show_loader();
					}
				}
				else if($('#Payment_type').val() == 5)
				{
					if($('#Mpesa_code').val() != "")
					{
						show_loader();
					}
				}
				else 
				{
					show_loader();
				}
			}
		}		
		if( ($('#inlineRadio2').is(":checked") == true) )
		{
			if($('#username').val() != "" && $('#user_email').val() != "" && $('#phno').val() != "")
			{
				
				
				var email=$("#user_email").val();
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if(regex.test(email) == false){
					
					$('#UserEmail').html("Please enter valid email address");
					$("#user_email").addClass("form-control has-error");
					return false;
				}
				else{
					
					$('#UserEmail').html("");
					$("#user_email").removeClass("has-error");
					return ture;
				}
				
				
				
				
				
				if($('#Payment_type').val() == 2 || $('#Payment_type').val() == 3)
				{
					if($('#Bank_name').val() != "" && $('#Branch_name').val() != "" && $('#Cheque_no').val() != "")
					{
						show_loader();
					}
				}
				else if($('#Payment_type').val() == 5)
				{
					if($('#Mpesa_code').val() != "")
					{
						show_loader();
					}
				}
				else
				{
					show_loader();
				}
			}
		}
	}
});

function showhide(flag)
{
	if(flag==1)
	{	 
		document.getElementById("block1").style.display="";
		document.getElementById("block2").style.display="none";
		
		$("#cardId").attr("required","required");		
		$("#username").removeAttr("required");	
		$("#user_email").removeAttr("required");	
		$("#phno").removeAttr("required");	
		
		$("#Member_details").show();
	}
	else
	{
		document.getElementById("block1").style.display="none";
		document.getElementById("block2").style.display="";
		
		$("#username").attr("required","required");
		$("#user_email").attr("required","required");
		$("#phno").attr("required","required");
		
		$("#cardId").removeAttr("required");	
		$("#Member_details").hide();
	}
}

function show_payment(flag)
{
	if(flag==5)
	{
		document.getElementById("mpesa_block").style.display="";
		document.getElementById("cheque_block").style.display="none";
		$("#Mpesa_code").attr("required","required");
	
		
	}
	
	if(flag==2 || flag==3)
	{
		document.getElementById("cheque_block").style.display="";
		document.getElementById("mpesa_block").style.display="none";
		
		$("#Bank_name").attr("required","required");
		$("#Branch_name").attr("required","required");
		$("#Cheque_no").attr("required","required");
		$("#Mpesa_code").removeAttr("required");
	}
	else if(flag == 1)
	{
		document.getElementById("cheque_block").style.display="none";
		document.getElementById("mpesa_block").style.display="none";
		
		$("#Bank_name").removeAttr("required");
		$("#Branch_name").removeAttr("required");
		$("#Cheque_no").removeAttr("required");
		$("#Mpesa_code").removeAttr("required");
	}
	
	if(flag==2)
	{
		$("#labelME").html("<span class='required_info'>*</span> Cheque Number");
		$("#payment_header").html("Cheque Details");
	}
	
	if(flag==3)
	{
		$("#labelME").html("<span class='required_info'>*</span> Credit Card Number");
		$("#payment_header").html("Credit Card Details");
	}
}

/*******************Phone No. Validation******************/
function isNumberKey2(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode 
	if (charCode == 46 || charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

	return true;
}
	
$(document).ready(function() 
{
	$('#gif_number').blur(function()
	{

		if( $("#gif_number").val() == "" || $("#gif_number").val() == 0)
		{
			$('#gif_number').val(''); 
			$('#GifNumber').html("Please Enter Valid Gift Card Number");
			$("#gif_number").addClass("form-control has-error");
		}
		else
		{
			var gift_card = $("#gif_number").val();
			
			var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				  type: "POST",
				  data: {gift_card: gift_card, Company_id: Company_id},
				  url: "<?php echo base_url()?>index.php/Transactionc/validate_gift_card_id",
				  success: function(data)
				  {
						if(data.length == 7)
						{
							$('#gif_number').val('');
							$('#GifNumber').html("Already Exist");
							$("#gif_number").addClass("form-control has-error");
							
						}
						else
						{
							$('#GifNumber').html("");
							$("#gif_number").removeClass("has-error");
						}

				  }
			});
		}
	});
		
	$('#cardId').blur(function()
	{
		if( $("#cardId").val() == "" || $("#cardId").val() =='0')
		{
			$('#cardId').val('');
			
			
			$('#GifNumber').html("Please Enter Gift Card Number");
			// $("#cardId").removeClass("has-error");
			$("#cardId").addClass("form-control has-error");
			
			$("#member_name").val("");
			$("#member_email").val("");
			$("#member_phn").val("");
		}
		else
		{
			var cardId = $("#cardId").val();
			var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				  type: "POST",
				  data: {cardid: cardId, Company_id: Company_id},
				  dataType: "json",
				  url: "<?php echo base_url()?>index.php/Transactionc/validate_card_id",
				  success: function(json)
				  {
						if(json['Card_id'] =='0')
						{
							$('#cardId').val('');
							$('#MembershipID').html("Invalid Membership Card ID");
							$("#cardId").addClass("form-control has-error");
							
							$("#member_name").val("");
							$("#member_email").val("");
							$("#member_phn").val("");
						}
						else
						{
							$('#MembershipID').html("");
							$("#cardId").removeClass("has-error");;
							
							var Member_name = json['First_name']+" "+json['Last_name'];
							var Member_email = json['User_email_id'];
							var Member_phn = json['Phone_no'];
							var Card_id = json['Card_id'];
							$("#member_name").val(Member_name);
							$("#member_email").val(Member_email);
							$("#member_phn").val(Member_phn);
							$("#cardId").val(Card_id);
						}
				  }
			});
		}
	});	
	
	$('#gif_balance').blur(function()
	{
		if( $("#gif_balance").val() == "" || $("#gif_balance").val() == 0 )
		{
			$("#gif_balance").val("");			
			
			$('#CardBalance').html("Please Enter Valid Gift Card Balance");
			$("#gif_balance").addClass("form-control has-error");
		}
		else
		{
			// has_success("#GiftBalance","#glyphicon2","#GiftBalance_help"," ");
			$('#CardBalance').html("");
			$("#gif_balance").removeClass("has-error");
		}
	});	
	
});	


$('#user_email').blur(function()
{
	var email=$("#user_email").val();
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(regex.test(email) == false){
		
		$('#UserEmail').html("Please enter valid email address");
		$("#user_email").addClass("form-control has-error");
		return false;
	}
	else{
		$('#UserEmail').html("");
		$("#user_email").removeClass("has-error");
		return ture;
	}

});

$(document).ready(function(){
	setTimeout(function(){
		$('.alert-dismissible').hide();
	},3000);
});
</script>
