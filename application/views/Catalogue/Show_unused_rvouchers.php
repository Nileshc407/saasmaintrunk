<?php echo form_open('CatalogueC/Validate_RVoucher'); ?>

<?php
				if($results != NULL)
				{?>
		
			<div class="row" id="records">
				<h5 class="form-header">Issued Vouchers of <?php echo $MembershipID;?></h5> 
			</div>
			
		
		<div class="table-responsive">
		
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					
					<th class="text-center">Voucher Name</th>
					<th class="text-center">Description</th>
					<th class="text-center">Voucher No.</th>
					<!--<th class="text-center">Quantity</th>-->
					<th class="text-center">Total <?php echo $Company_details->Currency_name; ?> </th>
					
					<!--<th class="text-center">Transaction Date</th>-->
				</tr>
				</thead>
				
				<tbody>
				<?php
				
					foreach($results as $row)
					{
						$Total_Redeem_Points=($row->Cost_in_points);
						$Customer_pin="0000";
						
				
					?>
						<tr>
					<td>
					<label>
						
						<input  name="Voucher_no<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Voucher_code; ?>" type="hidden">
						<input  name="MembershipID<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Card_id; ?>" type="hidden">
						
						
						<input  name="Cust_Enrollement_id<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Enrollement_id; ?>" type="hidden">
						<!--<input  name="Branch_name<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Branch_name; ?>" type="hidden">
						<input  name="Branch_Address<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Branch_Address; ?>" type="hidden">-->
						<input  name="Points<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Cost_in_points; ?>" type="hidden">
						<!--<input  name="Quantity<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Quantity; ?>" type="hidden">-->
						<input  name="Voucher_name<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Voucher_name; ?>" type="hidden">
						<!--<input  name="Full_name<?php echo $row->Voucher_code; ?>" value="<?php echo $row->Full_name; ?>" type="hidden">
						<input  name="Trans_date<?php echo $row->Voucher_code; ?>" value="<?php echo date('Y-m-d',strtotime($row->Trans_date)); ?>" type="hidden">-->
						<input  name="Total_points<?php echo $row->Voucher_code; ?>" value="<?php echo $Total_Redeem_Points; ?>" type="hidden">
						
						
						<input data-type="check" name="Item_id[]" value="<?php echo $row->Voucher_code; ?>"  class="checkbox1" type="checkbox">
						<!--<a>
							<img src="<?php //echo $row->Thumbnail_image1; ?>"  style="width:50px;height:50px;" >
						</a>-->
						<a><?php echo $row->Voucher_name; ?></a>
					</label>
					</td>
							<td class="text-center"><?php echo $row->Voucher_description; ?></td>
							<td class="text-center"><?php echo $row->Voucher_code; ?></td>
							<!--<td class="text-center"><?php echo $row->Quantity; ?></td>-->
							<td class="text-center"><?php echo $Total_Redeem_Points; ?></td>
							
							<!--<td class="text-center"><?php //echo date('Y-m-d',strtotime($row->Trans_date)); ?></td>-->
							
						</tr>
					<?php
					}
				
				?>				
				</tbody> 
			</table>
			
		</div>
		
		
	
		<?php $Pin_no_applicable = 0;
				$Allow_merchant_pin = 0;
			if($Pin_no_applicable == 1){ ?>
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
			
			<div class="form-buttons-w">
				<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary" onclick="return Proceed_to_fullfill();">Proceed</button>	
			</div>
			
<?php }else{?>		

			
			
		
			<div class="row">
				<h5 class="form-header">No Issued Vouchers Found !!!</h5> 
			</div>
			
			
			<?php } ?>
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
	