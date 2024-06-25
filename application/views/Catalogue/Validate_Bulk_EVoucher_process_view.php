<?php 
	$this->load->view('header/header');
	
?>
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-head-line">Validate Bulk e-Voucher</h1>
		</div>
	</div>
	<?php
				if(@$this->session->flashdata('Items_flash'))
				{
				?>
					<script>
						var Title = "Application Information";
						var msg = '<?php echo $this->session->flashdata('Items_flash'); ?>';
						runjs(Title,msg);
					</script>
				<?php
				}
				
			?>
			
	<div class="row">
		
		<?php echo form_open('CatalogueC/Validate_Bulk_EVoucher'); ?>
		<div class="col-md-16 ">
			
			<?php
			if(@$this->session->flashdata('error_code'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('upload_error_code'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}
			?>
		
			<div class="panel panel-default">                        
				
				<div class="panel-body" >
					
					
					<!----------------->
					<?php echo form_open('CatalogueC/Validate_EVoucher'); ?>
<div class="panel panel-info" id="records">
<?php
				if($results != NULL)
				{
					$flag=0;
					foreach($results as $row)
					{
						if($row->Quantity_balance!=0)
						{
							$flag=1;
						}	
					}
				if($flag==1)
				{
				?>
		
		<div class="table-responsive">
		
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					
					
					<th class="text-center">Item Name</th>
					<th class="text-center">Member Name</th>
					<th class="text-center">Voucher No.</th>
					<th class="text-center">Validity</th>
					<th class="text-center">Total Quantity 'Issued' </th>
					<th class="text-center">Quantity 'Used' </th>
					<th class="text-center">Balance 'Issued' Quantity </th>
					
					<th class="text-center">Transaction Date</th>
					<th class="text-center">Update Quantity</th>
				</tr>
				</thead>
				
				<tbody>
				<?php
					$Todays_date=date("Y-m-d");
					foreach($results as $row)
					{
						$Total_Redeem_Points=($row->Quantity*$row->Redeem_points);
						$Customer_pin=$row->pinno;
						if($row->Quantity_balance!=0)
						{
							$color="black";
							if($Todays_date>=$row->Valid_from && $Todays_date<=$row->Valid_till)
							{
								$color="green";
							}		
						
					?>
						<tr>
					<td>
						<label>
						
							<input data-type="check" name="Item_id[]" value="<?php echo $row->Trans_id; ?>"  class="checkbox1" type="checkbox">			
							<a>
								<img src="<?php echo $row->Thumbnail_image1; ?>"  style="width:50px;height:50px;" ><br>
								<a><?php echo $row->Merchandize_item_name; ?></a>
							</a>
						</label>
					</td>
					<td>
						<?php echo $row->First_name." ". $row->Last_name; ?></a>
						
					</td>
							
							<td class="text-center"><?php echo $row->Voucher_no; ?></td>
							<td class="text-center" style="color:<?php echo $color;?>;"><?php echo $row->Valid_from." To ".$row->Valid_till; ?></td>
							<td class="text-center"><?php echo $row->Quantity; ?></td>
							<td class="text-center"><?php echo ($row->Quantity-$row->Quantity_balance); ?></td>
							<td class="text-center"><?php echo $row->Quantity_balance; ?></td>
							
							<td class="text-center"><?php echo date('Y-m-d',strtotime($row->Trans_date)); ?></td>
							<td class="text-center">
								
								<select class="form-control" name="Update_evoucher_<?php echo $row->Trans_id; ?>" id="Update_evoucher_<?php echo $row->Trans_id; ?>">
								<?php 
								for($i=1;$i<=$row->Quantity_balance;$i++)
								{
									echo "<option value='$i'>$i</option>";
								}
								
								?>
								
								</select>		
							</td>
						</tr>
						
						
						
						<input  name="Voucher_no<?php echo $row->Trans_id; ?>" value="<?php echo $row->Voucher_no; ?>" type="hidden">
						<input  name="MembershipID<?php echo $row->Trans_id; ?>" value="<?php echo $row->Card_id; ?>" type="hidden">
						
						
						<input  name="Cust_Enrollement_id<?php echo $row->Trans_id; ?>" value="<?php echo $row->Enrollement_id; ?>" type="hidden">
						<input  name="Branch_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Branch_name; ?>" type="hidden">
						<input  name="Branch_Address<?php echo $row->Trans_id; ?>" value="<?php echo $row->Branch_Address; ?>" type="hidden">
						<input  name="Points<?php echo $row->Trans_id; ?>" value="<?php echo $row->Redeem_points; ?>" type="hidden">
						<input  name="Quantity<?php echo $row->Trans_id; ?>" value="<?php echo $row->Quantity; ?>" type="hidden">
						<input  name="Merchandize_item_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Merchandize_item_name; ?>" type="hidden">
						<input  name="Full_name<?php echo $row->Trans_id; ?>" value="<?php echo $row->Full_name; ?>" type="hidden">
						<input  name="Trans_date<?php echo $row->Trans_id; ?>" value="<?php echo date('Y-m-d',strtotime($row->Trans_date)); ?>" type="hidden">
						<input  name="Total_points<?php echo $row->Trans_id; ?>" value="<?php echo $Total_Redeem_Points; ?>" type="hidden">
						<input  name="Quantity_balance<?php echo $row->Trans_id; ?>" value="<?php echo $row->Quantity_balance; ?>" type="hidden">
						
						
						
					<?php
					}
					}
				
				?>				
				</tbody> 
			</table>
			
		</div>
			
		
	</div>
<div align="center">
		<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary" onclick="return Proceed_to_fullfill();">Update</button>	</div>	
		<?php	}else{echo "<h4 style='color:red;text-align:center;'>Currently, there are No Issued eVouchers !!!</h4>";} ?>
<?php }else{?>		

			
			<div class="panel-heading">
		
			<div class="row">
				<div class="col-md-6"><h4>No e-vouchers found !!!</h4></div>
			</div>
			
			</div>
			
			<?php } ?>
		<?php 
				
				
		?>
		
		<br><br>
		<div class="panel-heading">
		
			<div class="row">
				<div class="col-md-6"><h4>All Used Vouchers</h4></div>
			</div>
			
			</div>
	<div class="table-responsive">
		
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					
					
					<th class="text-center">Item Name</th>
					<th class="text-center">Member Name</th>
					<th class="text-center">Voucher No.</th>
					<th class="text-center">Quantity 'Used'</th>
					<th class="text-center">Update Date</th>
				</tr>
				</thead>
				
				<tbody>
				<?php
				
					foreach($results2 as $row)
					{
						
					?>
						<tr>
					<td>
						<label>
						
							
							<img src="<?php echo $row->Thumbnail_image1; ?>"  style="width:50px;height:50px;" >
							<a><?php echo $row->Merchandize_item_name; ?></a>
							
						</label>
					</td>
					<td>
						<?php echo $row->First_name." ". $row->Last_name; ?></a>
						
					</td>
							
							<td class="text-center"><?php echo $row->Voucher_no; ?></td>
							<td class="text-center"><?php echo $row->Updated_quantity; ?></td>
							<td class="text-center"><?php echo date('Y-m-d',strtotime($row->Update_date)); ?></td>
						
						</tr>
						
						
					<?php
					
					}
				
				?>				
				</tbody> 
			</table>
			
		</div>
					<!----------------->
					
					
				</div>						
			</div>
			</div>
		
		<?php echo form_close(); ?>
	</div>		
		<div class="panel-footer"><?php echo $pagination; ?></div>

<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>

<script type="text/javascript">


</script>
