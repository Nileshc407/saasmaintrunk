<?php echo form_open('CatalogueC/Update_order'); ?>
<div class="element-wrapper">                
	<div class="element-box">
	 <?php 
	if($results != NULL)
		{	  ?>
	  <h6 class="form-header">
	  Order Details
	  </h6>
		<div class="table-responsive">
			<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
				<thead>
					<tr>
					<th>
						<label>
							<input type="checkbox" id="checkAll" class="checkbox21" onclick="Check_all();"> 
						</label>Menu Item</th>
					<th class="text-center">Condiments</th>
					<th class="text-center">Qty</th>
					<th class="text-center">Order No.</th>
					<th class="text-center">Current Status</th>
					<th class="text-center">Update Status</th>
					<th class="text-center">Delivery Partner</th>
					<th class="text-center">Order Date</th>
					</tr>
				</thead>
				<tbody>
						<?php
					foreach($results as $row)
					{
						$Total_Redeem_Points=($row->Redeem_points);
						$Customer_pin=$row->pinno;
					?>
						<input  name="Trans_id<?php echo $row->Trans_id; ?>" value="<?php echo $row->Trans_id; ?>" type="hidden">
						<input  name="Order_no<?php echo $row->Trans_id; ?>" value="<?php echo $row->Bill_no; ?>" type="hidden">
						<input  name="Manual_billno<?php echo $row->Trans_id; ?>" value="<?php echo $row->Manual_billno; ?>" type="hidden">
						<input  name="Seller<?php echo $row->Trans_id; ?>" value="<?php echo $row->Seller; ?>" type="hidden">
						<input  name="Order_type<?php echo $row->Trans_id; ?>" value="<?php echo $row->Order_type; ?>" type="hidden">
						<input  name="Voucher_no<?php echo $row->Trans_id; ?>" value="<?php echo $row->Voucher_no; ?>" type="hidden">
						<input  name="MembershipID<?php echo $row->Trans_id; ?>" value="<?php echo $row->Card_id; ?>" type="hidden">
						<input  name="Cust_Enrollement_id<?php echo $row->Trans_id; ?>" value="<?php echo $row->Enrollement_id; ?>" type="hidden">
						<input  name="Branch_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Branch_name; ?>" type="hidden">
						<input  name="Branch_Address<?php echo $row->Trans_id; ?>" value="<?php echo $row->Branch_Address; ?>" type="hidden">
						<input  name="Quantity<?php echo $row->Trans_id; ?>" value="<?php echo $row->Quantity; ?>" type="hidden">
						<input  name="Merchandize_item_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Merchandize_item_name; ?>" type="hidden">
						<input  name="Condiments_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Condiments_name; ?>" type="hidden">
						<input  name="Full_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Full_name; ?>" type="hidden">
						<input  name="Trans_date<?php echo $row->Trans_id; ?>" value="<?php echo $row->Trans_date; ?>" type="hidden">
						<input  name="Purchase_amount<?php echo $row->Trans_id; ?>" value="<?php echo $row->Purchase_amount; ?>" type="hidden">
						<input  name="Shipping_cost<?php echo $row->Trans_id; ?>" value="<?php echo $row->Shipping_cost; ?>" type="hidden">
						<input  name="Loyalty_points<?php echo $row->Trans_id; ?>" value="<?php echo $row->Loyalty_pts; ?>" type="hidden">
						<input  name="Redeem_points<?php echo $row->Trans_id; ?>" value="<?php echo $row->Redeem_points; ?>" type="hidden">
						<tr>
							<td>
							<label>
								<input type="checkbox" name="Item_id[]" value="<?php echo $row->Trans_id; ?>" class="checkbox2" checked>
								<a>
									<!--img src="<?php //echo $row->Thumbnail_image1; ?>"  style="width:50px;height:50px;" >-->
								</a>
								<a><?php echo $row->Merchandize_item_name; ?></a>
							</label></td>
							<td class="text-center"><?php if($row->Condiments_name!=NULL) { echo $row->Condiments_name; } else { echo "-" ; } ?></td>
							<td><?php echo $row->Quantity; ?></td>
							<td><?php echo $row->Bill_no; ?></td>
							<td><?php if($row->Voucher_status==18) { $BtnClass="btn btn-info"; } else if($row->Voucher_status==19){ $BtnClass="btn btn-warning"; } else if($row->Voucher_status==21) { $BtnClass="btn btn-danger"; } ?>
								<button type="button" class="<?php echo $BtnClass;?>"><?php echo $row->Code_decode; ?>
							</td>
							<td>
								<select name="Voucher_status<?php echo $row->Trans_id; ?>" class="form-control">
								<option value="20">Collected/Delivered</option>
								</select>
							</td>
							<td>
								<select name="Shipping_partner<?php echo $row->Trans_id; ?>" class="form-control" >
								<?php
									foreach($Shipping_partner as $spart)
									{									
										echo '<option value="'.$spart['Partner_id'].'" selected>'.$spart['Partner_name'].'</option>';
									}
									?>
								</select>
							</td>
							<td><?php echo $row->Trans_date; ?></td>
						</tr>
					<?php
					} ?>
				</tbody> 
			</table>
		</div>
	  <button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary" onclick="return Proceed_to_fullfill();">Proceed</button>
	<?php } else { ?>	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-6"><h6>Order Not Found.!!</h6></div>
			</div>
		</div>
		<?php } ?>	  
	</div>
</div>