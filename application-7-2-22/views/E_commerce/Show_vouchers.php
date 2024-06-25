<?php echo form_open('E_commerce/Validate_EVoucher'); ?>

<?php
	if($results != NULL)
	{
	?>

		<div class="element-box">
			  <h5 class="form-header">
			 Voucher Details:
			  </h5>
		<div class="table-responsive">		
			<table class="table table-bordered table-hover" style="overflow-y:auto;">
				<thead>
				<tr>					
					<th class="text-center">Item Name</th>					
					<th class="text-center">Quantity</th>
					<th class="text-center">Voucher No.</th>					
					<th class="text-center">Current Status</th>					
					<th class="text-center" style="width:15% !important;">Update Status</th>					
					<th class="text-center" style="width:15% !important;">Shipping Partner</th>					
					<th class="text-center">Order Date</th>
				</tr>
				</thead>				
				<tbody>
				<?php				
				foreach($results as $row)
				{
					$Total_Redeem_Points=($row->Redeem_points);
					if($row->Trans_type==10)
					{
						$Total_Redeem_Points=($row->Quantity*$row->Redeem_points);
					}
					
					$Customer_pin=$row->pinno;
				?>
					<tr>
						<td>
						<label>							
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
							<input  name="Redeem_points<?php echo $row->Trans_id; ?>" value="<?php echo $Total_Redeem_Points; ?>" type="hidden">
							<input  name="Bill_no<?php echo $row->Trans_id; ?>" value="<?php echo $row->Bill_no; ?>" type="hidden">
							<input  name="Paid_amount<?php echo $row->Trans_id; ?>" value="<?php echo $row->Paid_amount; ?>" type="hidden">
							<input  name="Online_payment_method<?php echo $row->Trans_id; ?>" value="<?php echo $row->Online_payment_method; ?>" type="hidden">
							
							
							
							<input  name="Old_Voucher_status<?php echo $row->Trans_id; ?>" value="<?php echo $row->Voucher_status; ?>" type="hidden">
							
							<input  name="Shipping_points<?php echo $row->Trans_id; ?>" value="<?php echo $row->Shipping_points; ?>" type="hidden">
							<input  name="Trans_type<?php echo $row->Trans_id; ?>" value="<?php echo $row->Trans_type; ?>" type="hidden">
							
							<!--<input  name="Item_id" value="<?php //echo $row->Trans_id; ?>" type="hidden">-->
							<input data-type="check" name="Item_id[]" readonly value="<?php echo $row->Trans_id; ?>"  checked class="checkbox1" type="checkbox">
							<a>
								<img src="<?php echo $row->Thumbnail_image1; ?>"  style="width:50px;height:50px;" >
							</a>
							<a><?php echo $row->Merchandize_item_name; ?></a>
						</label>
						</td>							
							<td class="text-center"><?php echo $row->Quantity; ?></td>
							<td class="text-center"><?php echo $row->Voucher_no; ?></td>							
							<?php
								foreach($Code_decode_Records as $Rec)
								{
									if($row->Voucher_status == $Rec->Code_decode_id)
									{
										$Old_Voucher_status=$Rec->Code_decode;
									}									
								}
								?>
								
							<td class="text-center"><?php echo $Old_Voucher_status; ?></td>
							<td class="text-center">
							<select name="Voucher_status<?php echo $row->Trans_id; ?>" class="form-control" >
							<?php
								foreach($Code_decode_Records as $Rec)
								{
									if($Rec->Code_decode_type_id==5) //Order Status
									{							
										
										if($row->Voucher_status == 19) //Shipped
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 22  && $Rec->Code_decode_id != 23 ) 
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo '<option value="'.$Rec->Code_decode_id.'" selected>'.$Rec->Code_decode.'</option>';
												}
												else
												{
													echo '<option value="'.$Rec->Code_decode_id.'">'.$Rec->Code_decode.'</option>';
												}
											}
										}
										else if($row->Voucher_status == 20) //Delivered
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21 )
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo '<option value="'.$Rec->Code_decode_id.'" selected>'.$Rec->Code_decode.'</option>';
												}
												else
												{
													echo '<option value="'.$Rec->Code_decode_id.'">'.$Rec->Code_decode.'</option>';
												}
											}
										}
										else if($row->Voucher_status == 22) //Return Initiated
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21  && $Rec->Code_decode_id != 20 )
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo '<option value="'.$Rec->Code_decode_id.'" selected>'.$Rec->Code_decode.'</option>';
												}
												else
												{
													echo '<option value="'.$Rec->Code_decode_id.'">'.$Rec->Code_decode.'</option>';
												}
											}
										}
										else if($row->Voucher_status == 23) //Return
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21  && $Rec->Code_decode_id != 20 && $Rec->Code_decode_id != 22 )
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo '<option value="'.$Rec->Code_decode_id.'" selected>'.$Rec->Code_decode.'</option>';
												}
												else
												{
													echo '<option value="'.$Rec->Code_decode_id.'">'.$Rec->Code_decode.'</option>';
												}
											}
										}
										else
										{
											if($Rec->Code_decode_id != 22 && $Rec->Code_decode_id != 23 )
											{
												if($row->Voucher_status == $Rec->Code_decode_id)
												{
													echo '<option value="'.$Rec->Code_decode_id.'" selected>'.$Rec->Code_decode.'</option>';
												}
												else
												{
													echo '<option value="'.$Rec->Code_decode_id.'">'.$Rec->Code_decode.'</option>';
												}
											}
										}
									}
								}
								?>
							</select>
							</td>
							<td class="text-center">
							<select name="Shipping_partner<?php echo $row->Trans_id; ?>" id="Shipping_partner_id"  class="form-control" >
							<?php
								foreach($Shipping_partner as $spart)
								{									
									echo '<option value="'.$spart['Partner_id'].'" selected>'.$spart['Partner_name'].'</option>';
								}
								?>
							</select>
							</td>							
							<td class="text-center"><?php echo date('j, F Y',strtotime($row->Trans_date)); ?></td>
							
					</tr>
				<?php
				}				
				?>				
				</tbody> 
				</table>			
			</div>
		</div>
	
		<?php if($free_results != "" ) { ?>
		
		
		<div class="element-box">
			  <h5 class="form-header">
			 Free item Vouchers of
			  </h5>
		<div class="table-responsive">		
			<table class="table table-bordered table-hover">
				<thead>
				<tr>					
					<th class="text-center">Item Name</th>					
					<th class="text-center">Quantity</th>
					<th class="text-center">Voucher No.</th>					
					<th class="text-center">Voucher Status</th>					
					<th class="text-center">Order Date</th>
				</tr>
				</thead>				
				<tbody>
				<?php				
				foreach($free_results as $row_free)
				{
					
				?>
					<tr>
						<td>
						<label>						
							<a>
								<img src="<?php echo $row_free->Thumbnail_image1; ?>"  style="width:50px;height:50px;" >
							</a>
							<a><?php echo $row_free->Merchandize_item_name; ?></a>
						</label>
						</td>							
							<td class="text-center"><?php echo $row_free->Quantity; ?></td>	
							<td class="text-center"><?php echo $row_free->Voucher_no; ?></td>							
							<td class="text-center">							
							<?php  
								// echo $row_free->Voucher_status;
								foreach($Code_decode_Records as $Rec)
								{
									if($Rec->Code_decode_type_id==5) //Order Status
									{							
										
										if($row_free->Voucher_status == 19) //Shipped
										{
											if($Rec->Code_decode_id != 18) 
											{
												if($row_free->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
												
											}
										}
										else if($row_free->Voucher_status == 20) //Delivered
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21 )
											{
												if($row_free->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
											}
										}
										else if($row_free->Voucher_status == 22) //Return Initiated
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21  && $Rec->Code_decode_id != 20 )
											{
												if($row_free->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
											}
										}
										else if($row_free->Voucher_status == 23) //Return Initiated
										{
											if($Rec->Code_decode_id != 18 && $Rec->Code_decode_id != 19 && $Rec->Code_decode_id != 21  && $Rec->Code_decode_id != 20 && $Rec->Code_decode_id != 22 )
											{
												if($row_free->Voucher_status == $Rec->Code_decode_id)
												{
													echo  $Rec->Code_decode;
												}
											}
										}
										else
										{
											if($row_free->Voucher_status == $Rec->Code_decode_id)
											{
												echo  $Rec->Code_decode;
											}
										}										
									}
								}
							?>
							</td>							
							<td class="text-center"><?php echo date('j, F Y, g:i A',strtotime($row_free->Trans_date)); ?></td>
							
					</tr>
				<?php
				}				
				?>				
				</tbody> 
				</table>			
			</div>
		</div>
	
	<?php } ?>	
	<?php if($shipping_result) { ?>
		
		<div class="element-box">
			  <h5 class="form-header">
			 Shipping Details:
			  </h5>
		<div class="table-responsive">		
			<table class="table table-bordered table-hover">
				<thead>
				<tr>					
					<th class="text-center">Member name</th>					
					<th class="text-center">Address</th>
					<th class="text-center">City</th>					
					<th class="text-center">Zipcode</th>					
					<th class="text-center">State</th>					
					<th class="text-center">Country</th>					
					<th class="text-center">Phone No.</th>					
					<th class="text-center">Email ID</th>
				</tr>
				</thead>				
				<tbody>
				<?php				
				foreach($shipping_result as $shipping)
				{
					
				?>
					<tr>
						<td class="text-center"><?php echo $shipping->Cust_name; ?></td>							
						<td class="text-center"><?php echo $shipping->Cust_address; ?></td>							
						<td class="text-center"><?php echo $shipping->City_name; ?></td>	
						<td class="text-center"><?php echo $shipping->Cust_zip; ?></td>							
						<td class="text-center"><?php echo $shipping->State_name; ?></td>							
						<td class="text-center"><?php echo $shipping->Country_name; ?></td>							
						<td class="text-center"><?php echo $shipping->Cust_phnno; ?></td>							
						<td class="text-center"><?php echo $shipping->Cust_email; ?></td>							
							
					</tr>
				<?php
				}				
				?>				
				</tbody> 
			</table>			
		</div>
		
</div>

<?php } ?>	

		<?php if($Pin_no_applicable == 1){ ?>
			<div class="form-group has-feedback" id="pin_feedback"  style="width:30%;" >
				<label for="exampleInputEmail1">Member Pin</label>
				<input type="password" name="cust_pin" id="cust_pin" class="form-control" placeholder="Enter Member Pin No."  onchange="check_pin(this.value,<?php echo $Customer_pin; ?>);"/>
				<span  id="pin_glyphicon"   aria-hidden="true" class="glyphicon" style="margin-top:-4%;" ></span>						
				<div class="help-block" id="pin_help"  style="width:30%;" ></div>
			</div>
			<?php } ?>
			<?php if($Allow_merchant_pin == 1){ ?>
			<div class="form-group has-feedback" id="pin_feedback2"  style="width:30%;" >
				<label for="exampleInputEmail1">Merchant Pin</label>
				<input type="password" name="seller_pin" id="seller_pin" class="form-control" placeholder="Enter Merchant Pin No." onchange="check_pin2(this.value);"/>
				<span  id="pin_glyphicon2" aria-hidden="true" class="glyphicon"  style="margin-top:-4%;" ></span>						
				<div class="help-block" id="pin_help2"  style="width:30%;" ></div>
			</div>
			<?php } ?>
		
		<?php 
		if($row->Voucher_status == 21 || $row->Voucher_status == 23 ) 
		{ 
			if($row->Voucher_status == 21)
			{?>
				<span class="required_info">This order has been Cancelled</span>
			<?php }
			if($row->Voucher_status == 23)
			{?>
				<span class="required_info">This order has been Returned</span>
			<?php }
		?>
		
		<!--<button type="submit" name="submit" value="Register" id="Register" disabled class="btn btn-primary" onclick="return Proceed_to_fullfill();">Proceed</button>	-->
			
		<?php 
		}
		else
		{
		?>
			<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary" onclick="return Proceed_to_fullfill();">Proceed</button>	
		<?php 
		}
		?>
	<?php 
	} 
	else 
	{
	?>		

			
			<div class="panel-heading">
		
			<div class="row">
				<div class="col-md-6"><h4>No e-voucher found !!!</h4></div>
			</div>
			
			</div>
			
	<?php 
	} 
	?>
			<style>
			.has-feedback label~.form-control-feedback {
					top: 36px !important;
				}
				.has-error .form-control {
				border-color: #ccc   !important;
			}
			.has-success .form-control {
				border-color: #ccc   !important;
			}
			
			.has-error .form-control-feedback {
					color: #333   !important;
				}
				
				.has-success .form-control-feedback {
					color: #333   !important;
				}
			
			</style>
<script>


</script>