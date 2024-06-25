<?php $this->load->view('header/header'); ?>

<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

<section class="content-header">
	<h1>Order <?php echo $Order->Voucher_no; ?></h1>	 
</section>
<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
	<script>
			BootstrapDialog.show({
			closable: false,
			title: 'Application Information',
			message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					window.location='<?php echo base_url()?>index.php/Cust_home/home';
				}
			}]
		});
		runjs(Title,msg);
	</script>
<?php } ?>

<!-- Main content -->
<section class="content">

	<div class="row">
	
		<div class="col-md-12 clearfix" id="basket">

			<!--<p class="lead text-center">Order <strong><?php //echo $Order->Voucher_no; ?></strong> was placed on <strong><?php //echo $Order->Trans_date; ?></strong> and is currently <strong>Being <?php //echo $Order->Delivery_status; ?></strong>.</p>-->

			<div class="box">

				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th><?php echo ('Order No'); ?></th>
								<th><?php echo ('Voucher No'); ?></th>
								<th colspan="2"><?php echo ('Item Name'); ?></th>
								<th><?php echo ('Item size'); ?></th>
								<th><?php echo ('Quantity'); ?></th>								
								<th><?php echo ('Unit price'); ?></th>
								<th><?php echo ('Total'); ?></th>
							</tr>
						</thead>
						<tbody>
						
								<?php
								$sub_total = 0;
								foreach($Order_details as $Order_det)
								{
									// $sub_total = $sub_total + ($Order_det['Quantity'] * $Order_det['Purchase_amount']);
									$sub_total =  $Order_det['Purchase_amount'];		
									$Bill_no=$Order_det["Bill_no"];
									$Company_id=$Order_det["Company_id"];
									$Voucher_no=$Order_det['Voucher_no'];
									$Shipping_cost=$Order_det['Shipping_cost'];

																				
									$Item_id = string_encrypt($Order_det['Company_merchandise_item_id'], $key, $iv);	
									$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);

								?>
								
									<tr>
									<td><?php echo $Order_det['Bill_no']; ?></td>
									<td><?php echo $Order_det['Voucher_no']; ?></td>
										<td>
											<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
												<img src="<?php echo $Order_det['Thumbnail_image1']; ?>" alt="<?php echo $Order_det['Merchandize_item_name']; ?>">
											</a>
										</td>
										<td>
											<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
												<?php echo $Order_det['Merchandize_item_name']; ?>
											</a>
										</td>
										<td><?php 
										if($Order_det['Item_size'] == 1)
													{
													  $size = "Small";
													}
													elseif($Order_det['Item_size'] == 2)
													{	
														$size = "Medium";
													}
													elseif($Order_det['Item_size'] == 3)
													{
														$size = "Large";
													}
													elseif($Order_det['Item_size'] == 4)
													{
														$size = "Extra Large";
													}
													else
													{
														$size = "-";
													}
													echo $size;
										 ?></td>	
										<td><?php echo $Order_det['Quantity']; ?></td>
										
										<?php $Unit_price=$Order_det['Purchase_amount']/$Order_det['Quantity']; ?>
										<td><?php echo $Symbol_of_currency." ".number_format((float)$Unit_price, 2) ?></td>
										<td><?php echo $Symbol_of_currency." ".number_format( (float)($Order_det['Purchase_amount']), 2); ?></td>
									</tr>
									
											
								<?php 
								
									$Redeem_points = $Order_det['Redeem_points'] ;
									// echo"---Company_id---".$Company_id."---<br>";
									// echo"---Redemptionratio---".$Redemptionratio."---<br>";
									$calculate_redeem_amounts=round($Redeem_points/$Redemptionratio);
									$Grand_total=($Shipping_cost+$sub_total-$calculate_redeem_amounts);
									// echo"---calculate_redeem_amounts---".$calculate_redeem_amounts."---<br>";
								} 
								?>
										
								<tr><td colspan="5">&nbsp;</td></tr>
							
						</tbody>
						
						<tfoot>
							<tr>
								<th colspan="7" class="text-right"><?php echo ('Subtotal'); ?></th>
								<td><?php echo $Symbol_of_currency." ".number_format((float)$sub_total, 2); ?></td>
							</tr>
							<tr>
								<th colspan="7" class="text-right"><?php echo ('Shipping Cost'); ?></th>
								<td><?php echo $Symbol_of_currency." ".number_format((float)$Shipping_cost, 2); ?></td>
							</tr>
							<!--		
							<tr>
								<th colspan="7" class="text-right"> <?php echo ('Redeem Amount'); ?> </th>
								<td><?php /*echo $Symbol_of_currency.$Order->Purchase_amount;*//* echo $Symbol_of_currency.number_format((float)$sub_total, 2); */ echo number_format($calculate_redeem_amounts, 2).' '.$this->lang->line('amount').',';?> ( <?php echo number_format($Redeem_points)  .' '.$this->lang->line('Points');?>) </td>
							</tr>
							<tr>
								<th colspan="7" class="text-right"><?php echo ('Grand total'); ?></th>
								<td><?php $Grand_total=$sub_total-$calculate_redeem_amounts; echo $Symbol_of_currency.number_format((float)$Grand_total, 2);?></td>
							</tr>
							-->
							<?php
								if($Order_det['Voucher_status']==20)//Delivered 
								{
									$Voucher_status = ('Delivered');
								}
								elseif($Order_det['Voucher_status']==19)//Shipped
								{
									$Voucher_status = ('Shipped');
									
								}
								elseif($Order_det['Voucher_status']==21)//Cancel
								{
									$Voucher_status= ('Cancel');
									
								}
								elseif($Order_det['Voucher_status']==22)//'Return Initiated'
								{
									$Voucher_status = ('Return Initiated');
									
								}
								elseif($Order_det['Voucher_status']==18) //Ordered
								{
									$Voucher_status = ('Ordered');
									
								} 
								elseif($Order_det['Voucher_status']==23) //Returned
								{
									$Voucher_status = ('Returned');
																	
								} 
								else
								{
									$Voucher_status = "";
									
								}
								?>
							<tr>
								<th colspan="7" class="text-right"><?php echo ('Order status'); ?></th>
								<td><?php echo $Voucher_status; ?></td>
							</tr>
						</tfoot>
						
					</table>
				</div>
				
				
				<?php
					$ci_object = &get_instance();
					$ci_object->load->model('shopping/Shopping_model');
					$Count_item_offer = $ci_object->Shopping_model->get_purchased_item_offers_details($Voucher_no,$Bill_no,$Company_id);
					// echo"---Bill_no---".$Order_det["Bill_no"]."<br>";
					// echo"---Quantity---".$Order_det["Quantity"]."<br>";
					
					$Count_offers=count($Count_item_offer);
					// echo"---Count_offers---".$Count_offers."<br>";
					
					
				if($Count_offers > 0)
				{
				?>	
				
				<div class="table-responsive">				
					<table class="table">
						<thead>
							<tr>
								<th><?php echo ('Order No'); ?></th>
								<th><?php echo ('Voucher No'); ?></th>
								<th><?php echo ('offer items'); ?></th>
								<th><?php echo ('Quantity'); ?></th>							
							</tr>
						</thead>
						<tbody>
						
						<?php
								
						foreach($Count_item_offer as $offers)
						{
							$Bill_no=$Order_det["Bill_no"];
							$Company_id=$Order_det["Company_id"];

							$Item_id = string_encrypt($offers['Company_merchandise_item_id'], $key, $iv);	
							$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
						?>								
							<tr>
							<td><?php echo $offers['Bill_no']; ?></td>	
							<td><?php echo $offers['Voucher_no']; ?></td>	
								<td>
									<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
										<img src="<?php echo $offers['Thumbnail_image1']; ?>" alt="<?php echo $offers['Merchandize_item_name']; ?>">
									
										<?php echo $offers['Merchandize_item_name']; ?>
									</a>
								</td>
								
								<td><?php echo $offers['Quantity']; ?></td>									
																
							</tr>
						<?php 
							
						} 
						?>
										
						<tr><td colspan="5">&nbsp;</td></tr>
							
						</tbody>
						
						
						
					</table>
				</div>
				<?php 
				} 
				?>
				
				<div class="row addresses">
					
					<div class="col-sm-6">
						<h3 class="text-uppercase"><?php echo ('Shipping address'); ?></h3>
						<p><?php echo $Order->Cust_name; ?>
							<br><?php echo $Order->Cust_address; ?>
							<br><?php echo $Order->City_name; ?>, <?php echo $Order->State_name; ?>, <?php echo $Order->Country_name; ?>, <?php echo $Order->Cust_zip; ?>.
							<br><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp;<?php echo $Order->Cust_phnno; ?>
							<br><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;<?php echo $Order->Cust_email; ?>
						</p>
					</div>
				</div>

			</div>
			<!-- /.box -->

		</div>
		
	</div>
	
</section>
		
<?php $this->load->view('header/footer'); ?>