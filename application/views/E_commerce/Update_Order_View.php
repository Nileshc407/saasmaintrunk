<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   UPDATE ORDERS
			  </h6>
			  <div class="element-box">
			
					<!-----------------------------------Flash Messege-------------------------------->

					<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
					<?php 	} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
					<?php 	} ?>
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				//echo form_open('CatalogueC/Validate_EVoucher',$attributes); ?>	
				<div class="row">
		  <div class="col-sm-6">
				  
				  
				  <div class="form-group" id="offernm_feedback">
						<label for=""><span class="required_info">*</span> Enter Voucher No.
							</label>
					
						<input type="text" name="Voucher_no" id="Voucher_no" class="form-control" placeholder="Enter Voucher No." required    onblur="VoucherNo_validation(this.value);" data-error="Please Enter Valid Voucher No."  />
							<div class="help-block form-text with-errors form-control-feedback" id="Voucher_no2" ></div>		
							
					</div>
				  
				  <div class="form-buttons-w">
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Show Vouchers</button>
				 </div>
				 
					
			</div>
				  
				    <div class="col-sm-6">
						
						
							<div class="element-wrapper">
								<h6 class="element-header">Member Details</h6>
								<div class="element-box">



									<div class="profile-tile" style="margin-top:-13%;">
										<a class="profile-tile-box" href="javascript:void(0);"  >
											<div class="pt-avatar-w">	
											<img src="<?php echo base_url(); ?>images/no_image.jpeg" alt="" style="width:60px;height:60px;"  id="Photograph">
	 
											
												
											</div>
											<div class="pt-user-name"  id="member_name">
											</div>

										</a>
										<div class="profile-tile-meta">
											<ul>
												<li>
													Member Tier:<strong  id="Tier"></strong>
												</li>

												<li>
													Membership Id:<strong id="Card_id"></strong>
												</li>
												<li>
													Current Balance:<strong id="Current_balance"></strong>
												</li>
												<br>
												<li>
													Phone No.:<strong  id="member_phn"></strong>
												</li>
												<li>
													Email:<strong id="member_email"></strong>
												</li>

												
												

											</ul>

										</div>

									</div>

								</div>
							</div>
									
								
								
									
					</div>
					
				</div>	
					
					
				  
				  
				  
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>


	<!--------------Table------------->
	<div class="content-panel" >             
		<div class="element-wrapper">											
			<div class="element-box"  id="records">
			  <h5 class="form-header">
			Issued e-Vouchers
			  </h5> 
			</div>
		</div>
	</div> 
	<!--------------Table--------------->
	
</div>			
<?php $this->load->view('header/footer'); ?>

<script type="text/javascript">
	var Pin_no_applicable = <?php echo $Pin_no_applicable; ?>;
	var Allow_merchant_pin = <?php echo $Allow_merchant_pin; ?>;
	var Merchant_pin = <?php echo $Merchant_pin; ?>;

function check_pin(Entered_pin,Customer_pin)
{
	// alert(Entered_pin);
	if(Pin_no_applicable==1)
	{

			var Entered_pin = $('#cust_pin').val();

			if( (Entered_pin != Customer_pin) || (Entered_pin == "") )
			{
				$('#cust_pin').val("");
				has_error("#pin_feedback","#pin_glyphicon","#pin_help","Please Enter Valid Pin Number...!!!");
				//document.getElementById("pin_glyphicon").innerHTML="Please Enter Valid Member Pin Number !!!";

			}
			else
			{
				 has_success("#pin_feedback","#pin_glyphicon","#pin_help","Valid Pin");
				document.getElementById("pin_glyphicon").innerHTML="";
			}

	}
}

function check_pin2(Entered_pin2)
{
	// alert(Entered_pin);
	if(Allow_merchant_pin==1)
	{

			var Entered_pin2 = $('#seller_pin').val();

			if( (Entered_pin2 != Merchant_pin) || (Entered_pin2 == "") )
			{
				$('#seller_pin').val("");
				 has_error("#pin_feedback2","#pin_glyphicon2","#pin_help2","Please Enter Valid Pin Number...!!!");
				//document.getElementById("pin_glyphicon2").innerHTML="Please Enter Valid Merchant Pin Number !!!";

			}
			else
			{
				 has_success("#pin_feedback2","#pin_glyphicon2","#pin_help2","Valid Pin");
				document.getElementById("pin_glyphicon2").innerHTML="";
			}

	}
}

	function Proceed_to_fullfill()
	{
		var flag_access=0;
		var flag_access2=0;

		var shipping_partner_id=$('#Shipping_partner_id').val();

		if(shipping_partner_id == null)
		{

			runjs("Data Validation","Please select shipping partner !!!");
			return false;
		}
		else
		{
			flag_access=1;
		}

		if(Pin_no_applicable==1)
		{
			var Entered_pin = $('#cust_pin').val();

				if( Entered_pin != "")
				{
						 flag_access=1;

				}
				else
				{
					runjs("Data Validation","Please Enter Valid Member Pin Number !!!");
					return false;
				}
		}
		else
		{
			 flag_access=1;
		}
		if(Allow_merchant_pin==1)
		{
			var Entered_pin2 = $('#seller_pin').val();

			if( Entered_pin2 != "")
			{
				flag_access2=1;
			}
			else
			{
				runjs("Data Validation","Please Enter Valid Merchant Pin Number !!!");
				return false;
			}
		}
		else
		{
			 flag_access2=1;
		}

		if(flag_access==1 && flag_access2==1)
		{
			show_loader();
		}

		//$("#amt_deposit").removeAttr("required");
	}
	function VoucherNo_validation(voucher)
	{
		var Company_id = '<?php echo $Company_id; ?>';
		//var Voucher_Number=$("#Voucher_Number").val();
		if( voucher == "" )
		{
			//has_error("#has-feedback","#glyphicon","#help-block1","Please Enter Valid Voucher No...!!");
			$("#Voucher_no2").html("Please Enter Valid Voucher No.");
		}
		else
		{

			$.ajax({
				type:"POST",
				data:{voucher:voucher, Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/E_commerce/Voucher_validation",
				success : function(data)
				{
					 //alert(data);
					if(data == 0)//14
					{
						$("#Voucher_no").val("");
						$("#Voucher_no2").html("Invalid Voucher No.");
						//has_error("#has-feedback","#glyphicon","#help-block1","Voucher no not Exist.!!");
						document.getElementById("records").style.display="none";
						document.getElementById("info").style.display="none";
					}
					else
					{
						// has_success("#has-feedback","#glyphicon","#help-block1",data);
						get_cust_info(voucher);
						Get_unused_evouchers(voucher);
						$("#Voucher_no2").html("");
						document.getElementById("records").style.display="";

					}
				}
			});

		}
	}
	function get_cust_info(voucher)
	{
		// alert(voucher);
			var Company_id = '<?php echo $Company_id; ?>';
		/*************************/
		// alert(MembershipID)
			 $.ajax({
				  type: "POST",
				  data: {voucher: voucher, Company_id: Company_id},
				  dataType: "json",
				url: "<?php echo base_url()?>index.php/E_commerce/validate_card_id",
				success: function(json)
				{
					//alert(json['Card_id']);
					 if(json['Card_id']!=0)
					 {
						var Member_name = json['First_name']+" "+json['Last_name'];
						var Member_email = json['User_email_id'];
						var Member_phn = json['Phone_no'];
						var Card_id = json['Card_id'];
						var Tier_name = json['Tier_name'];
						var Current_balance = json['Current_balance'];
						var Photograph = json['Photograph'];
						
						$("#member_name").html(Member_name);
						$("#member_email").html(Member_email);
						$("#member_phn").html(Member_phn);
						$("#Card_id").html(Card_id);
						
						$("#Tier").html(Tier_name);
						$("#Current_balance").html(Current_balance);
						//alert(Photograph);
						if(Photograph== "")
						{
							document.getElementById("Photograph").src="<?php echo base_url(); ?>images/no_image.jpeg";
							
						}
						else
						{
							document.getElementById("Photograph").src= "<?php echo base_url(); ?>"+Photograph;
							
						}
					 }
					 else
					 {
						$("#member_name").html('');
						$("#member_email").html('');
						$("#member_phn").html('');
						$("#Card_id").html('');
						$("#Tier").html('');
						$("#Current_balance").html('');
					 }

				}
			});
			/*********************************/
	}
	function Get_unused_evouchers(voucher)
	{

		var Company_id = '<?php echo $Company_id; ?>';
		var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
		var Allow_merchant_pin = '<?php echo $Allow_merchant_pin; ?>';

		$.ajax({
				type:"POST",
				data:{voucher:voucher, Company_id:Company_id, Pin_no_applicable:Pin_no_applicable, Allow_merchant_pin:Allow_merchant_pin},
				url: "<?php echo base_url()?>index.php/E_commerce/Get_evouchers_details",
				success : function(data)
				{
					document.getElementById("records").innerHTML=data;
				}
			});
	}




	</script>
