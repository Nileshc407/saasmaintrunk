<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   E-COMMERCE RETURN ORDERS
			  </h6>
			  
			
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
				echo form_open('E_commerce/return_order',$attributes); ?>	
						<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box" >
			<?php
				if($returnOrders != NULL)
				{ ?>
			  <h5 class="form-header">
			  E-commerce Return Orders
			  </h5>    
				
			  <div class="table-responsive">
				<table id="dataTable1"  class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th>Select All<br><input data-type="check"  id="checkAll" class="checkbox1" type="checkbox"></th>
							<th>Order No</th>
							<th>Order Date</th>
							<th>Return Initiate Date</th>
							<th>Membership ID</th>
							<th colspan="2">Item Name</th>
							<!--<th>Quantity</th>-->
							<th>Purchase Amount (<?php echo $Symbol_of_currency; ?>) </th>
							
							<th>Voucher No.</th>
							<!--<th class="text-center">Current Status</th>-->
							<th>Voucher Status</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				
					foreach($returnOrders as $row)
					{
						$Total_Redeem_Points=($row->Quantity*$row->Redeem_points);
					?>
						<tr>
							
							<td class="text-center">
							
							<input  name="Voucher_no<?php echo $row->Trans_id; ?>" value="<?php echo $row->Voucher_no; ?>" type="hidden">
							<input  name="MembershipID<?php echo $row->Trans_id; ?>" value="<?php echo $row->Card_id; ?>" type="hidden">	
							<input  name="Cust_Enrollement_id<?php echo $row->Trans_id; ?>" value="<?php echo $row->Enrollement_id; ?>" type="hidden">
							<input  name="Purchase_amount<?php echo $row->Trans_id; ?>" value="<?php echo $row->Purchase_amount; ?>" type="hidden">
							<input  name="Loyalty_pts<?php echo $row->Trans_id; ?>" value="<?php echo $row->Loyalty_pts; ?>" type="hidden">
							<input  name="Quantity<?php echo $row->Trans_id; ?>" value="<?php echo $row->Quantity; ?>" type="hidden">
							<input  name="Merchandize_item_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Merchandize_item_name; ?>" type="hidden">
							<input  name="Item_code<?php echo $row->Trans_id; ?>" value="<?php echo $row->Item_code; ?>" type="hidden">
							<input  name="Full_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Full_name; ?>" type="hidden">
							<input  name="Trans_date<?php echo $row->Trans_id; ?>" value="<?php echo date('Y-m-d',strtotime($row->Trans_date)); ?>" type="hidden">
							<input  name="Redeem_points<?php echo $row->Trans_id; ?>" value="<?php echo $row->Redeem_points; ?>" type="hidden">
							<input  name="Bill_no<?php echo $row->Trans_id; ?>" value="<?php echo $row->Bill_no; ?>" type="hidden">
							<input  name="Paid_amount<?php echo $row->Trans_id; ?>" value="<?php echo $row->Paid_amount; ?>" type="hidden">
							<input  name="Online_payment_method<?php echo $row->Trans_id; ?>" value="<?php echo $row->Online_payment_method; ?>" type="hidden">
							
							<input  name="Shipping_points<?php echo $row->Trans_id; ?>" value="<?php echo $row->Shipping_points; ?>" type="hidden">
							<input  name="Trans_type<?php echo $row->Trans_id; ?>" value="<?php echo $row->Trans_type; ?>" type="hidden">
							
							<input data-type="check" name="Item_id[]" value="<?php echo $row->Trans_id; ?>"  class="checkbox1" type="checkbox">
							</td>
							<td class="text-center">
				
							<?php echo $row->Bill_no; ?></td>
							<td><?php echo date('j, F Y',strtotime($row->Trans_date)); ?></td>
							<td><?php echo date('j, F Y',strtotime($row->Update_date)); ?></td>
							<td><?php echo $row->Card_id; ?></td>
							<td colspan="2"><?php echo $row->Merchandize_item_name; ?></td>
							<!--<td><?php echo $row->Quantity; ?></td>-->
							<td><?php echo $row->Purchase_amount; ?></td>
							<td><?php echo $row->Voucher_no; ?></td>
							<!--<td class="text-center">							
							<?php
							//echo $row->Voucher_status; 
								foreach($Code_decode_Records as $Rec)
								{
									if($Rec->Code_decode_type_id==5) //Order Status
									{							
										
										if($row->Voucher_status == 19) //Shipped
										{
											if($Rec->Code_decode_id != 18) 
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
												
											}
										}
										else if($row->Voucher_status == 20) //Delivered
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21 )
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
											}
										}
										else if($row->Voucher_status == 22) //Return Initiated
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21  && $Rec->Code_decode_id != 20 )
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
											}
										}
										else if($row->Voucher_status == 23) //Return Initiated
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21  && $Rec->Code_decode_id != 20 && $Rec->Code_decode_id != 22 )
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
											}
										}
										else
										{
											if($row->Voucher_status == $Rec->Code_decode_id)
											{
												echo  $Rec->Code_decode;
											}
										}										
									}
								}
								?>
							
							</td>-->
							<td>
							<select name="Voucher_status<?php echo $row->Trans_id; ?>" class="form-control" style="width:110px">
							<?php
							echo $row->Voucher_status; 
								foreach($Code_decode_Records as $Rec)
								{
									if($Rec->Code_decode_type_id==5) //Order Status
									{					
										if($row->Voucher_status == 22) //Return Initiated
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21  && $Rec->Code_decode_id != 22 && $Rec->Code_decode_id != 20  )
											{
												echo '<option value="'.$Rec->Code_decode_id.'" selected>'.$Rec->Code_decode.'</option>';
											}
										}										
									}
								}
								?>
							</select>
							</td>
							
						</tr>
					<?php
					}
				
				
				?>	
					</tbody>
				</table>
				<div class="help-block form-text with-errors form-control-feedback" id="return_error" ></div>
				<br>	
			  </div>
			  <button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Proceed</button>
			  <?php }else { echo '<div class="help-block form-text with-errors form-control-feedback" align="center">No Returned Order Found !!!</div>';} ?>
			</div>
			
		</div>
			
	</div> 
	<!--------------Table--------------->
					
					
				  
				  
				  
				  
				<?php echo form_close(); ?>		  
			  
			  
			</div>
		  </div>
		</div>
		
	</div>


	
	
</div>			
<?php $this->load->view('header/footer'); ?>

<script type="text/javascript">

$('#Register').click(function()
{
	var count_checked = $("[name='Item_id[]']:checked").length; // count the checked rows
	if(count_checked == 0) 
	{
		// alert("Please select any record to delete.");
		var Title = "Application Information";
		var msg = 'Please select atleast one checkbox to procceed';
		$("#return_error").html(msg);
		//alert(msg);
		//runjs(Title,msg);
		return false;
	}
	else
	{
		show_loader();
	}		
	// return false;
});

$("#checkAll").attr("data-type", "check");
$("#checkAll").click(function() 
{
	if ($("#checkAll").attr("data-type") === "check") 
	{
		$(".checkbox1").prop("checked", true);
		$("#checkAll").attr("data-type", "uncheck");
	} 
	else 
	{
		$(".checkbox1").prop("checked", false);
		$("#checkAll").attr("data-type", "check");
	}
});


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
			has_error("#has-feedback","#glyphicon","#help-block1","Please Enter Valid Membership ID / Phone No...!!");
		}
		else
		{
			
			$.ajax({
				type:"POST",
				data:{voucher:voucher, Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/E_commerce/Voucher_validation",
				success : function(data)
				{ 
					// alert(data.length);
					if(data.length == 14)//14
					{
						$("#Voucher_no").val("");
						
						has_error("#has-feedback","#glyphicon","#help-block1","Voucher no not Exist.!!");
						document.getElementById("records").style.display="none";
						document.getElementById("info").style.display="none";						
					}
					else
					{
						has_success("#has-feedback","#glyphicon","#help-block1",data);						
						Get_unused_evouchers(voucher);
						document.getElementById("records").style.display="";				
						 
					}
				}
			});
				
		}
	}
	function get_cust_info(MembershipID)
	{
			var Company_id = '<?php echo $Company_id; ?>';
		/*************************/
		// alert(MembershipID)
			 $.ajax({
				  type: "POST",
				  data: {cardid: MembershipID, Company_id: Company_id},
				  dataType: "json",
				url: "<?php echo base_url()?>index.php/Transactionc/validate_card_id",
				success: function(json)
				{
					  
					 if(json['Card_id']!=0)
					 {
						var Member_name = json['First_name']+" "+json['Last_name'];
						var Member_email = json['User_email_id'];
						var Member_phn = json['Phone_no'];
						var Card_id = json['Card_id'];
						$("#member_name").val(Member_name);
						$("#member_email").val(Member_email);
						$("#member_phn").val(Member_phn);
						$("#Card_id").val(Card_id);
					 }
					 else
					 {
						 $("#member_name").val('');
						$("#member_email").val('');
						$("#member_phn").val('');
						$("#Card_id").val('');
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
