<?php $this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Shopping_model'); ?>

<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

<section class="content-header">
	<h1>My Orders</h1>	 
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
<!-- Main content -->
<section class="content">

	<div class="row">
	
		<div class="col-md-12" id="customer-orders">

			

			<div class="box">

				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th><?php echo ('Order No'); ?></th>
								<th><?php echo ('Voucher No'); ?></th>
								<th><?php echo ('Item Name'); ?></th>
								<th><?php echo ('Item size'); ?></th>
								<th><?php echo ('Quantity'); ?></th>
								<th><?php echo ('Order Date'); ?></th>
								<th><?php echo ('Total Purchase Amount'); ?></th>
								<th><?php echo ('Status'); ?></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						
							<?php 
							if($Orders !="")
							{
								foreach($Orders as $ords)
								{
									if($ords['Voucher_status']==20)//Delivered 
									{
										$Voucher_status= ('Delivered'); 
										$color='green';
									}
									elseif($ords['Voucher_status']==19)//Shipped
									{
										$Voucher_status=  ('Shipped'); 
										$color='#337ab7';
									}
									elseif($ords['Voucher_status']==21)//Cancel
									{
										$Voucher_status= ('Cancel'); 
										$color='red';
									}
									elseif($ords['Voucher_status']==22)//'Return Initiated'
									{
										$Voucher_status = ('Return Initiated'); 
										$color='#800000';
									}
									elseif($ords['Voucher_status']==18) //Ordered
									{
										$Voucher_status =  ('Ordered'); 
										$color='#00c0ef';
									} 
									elseif($ords['Voucher_status']==23) //Returned
									{
										$Voucher_status = ('Returned'); 
										$color='#808080';									
									} 
									else
									{
										$Voucher_status = "";
										$color='#C0C0C0';	
									}
								?>
								<?php $Get_item_name = $ci_object->Shopping_model->Get_item_details($Company_id,$ords['Item_code']);	
									foreach($Get_item_name as $item_name)
									{
										$item_name = $item_name->Merchandize_item_name;
									?>
							
									<tr>
										<td><?php echo $ords['Bill_no']; ?></td>
										<td><?php echo $ords['Voucher_no'];?></td>
										<td><?php echo $item_name; ?></td>
										<td><?php
													if($ords['Item_size'] == 1)
													{
													  $size = "Small";
													}
													elseif($ords['Item_size'] == 2)
													{	
														$size = "Medium";
													}
													elseif($ords['Item_size'] == 3)
													{
														$size = "Large";
													}
													elseif($ords['Item_size'] == 4)
													{
														$size = "Extra Large";
													}
													else
													{
														$size = "-";
													}
													echo $size;


																							
													$Trans_id = string_encrypt($ords['Trans_id'], $key, $iv);	
													$Trans_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Trans_id);


												?></td>
										<td><?php echo $ords['Quantity']; ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($ords['Trans_date'])); ?></td>
										<td><?php echo "<b>".$Symbol_of_currency."</b>  ".$ords['Purchase_amount']; ?></td>
										<td><span class="label label-info" style="background-color: <?php echo $color;?> !important;"><?php echo $Voucher_status; ?></span></td>
										<td>
										<td>
											<a href="<?php echo base_url()?>index.php/Shopping/order_details/?serial_id=<?php echo urlencode($Trans_id); ?>" title="View"><?php echo ('View'); ?></a>									
																				
										</td>
										<?php if($ords['Voucher_status']==18) //Ordered
										{ ?>
										<td>
										  <a href="javascript:void(0);" onclick="cancel_order('<?php echo $ords['Trans_id'];?>','<?php echo $ords['Bill_no'];?>','<?php echo $ords['Voucher_no'];?>','<?php echo $item_name;?>');" title="Delete"> <?php echo ('Cancel'); ?> </a>
										</td>
										<?php } ?>
											<?php if($ords['Voucher_status']==19) //Ordered
										{ ?>
										<td>
										  <a href="javascript:void(0);" onclick="cancel_order('<?php echo $ords['Trans_id'];?>','<?php echo $ords['Bill_no'];?>','<?php echo $ords['Voucher_no'];?>','<?php echo $item_name;?>');" title="Delete"> <?php echo ('Cancel'); ?> </a>
										</td>
										<?php } ?>
										<?php if($ords['Voucher_status']==20) //Shipped
										{									
											/***********Calculate Days*************/
												$Transaction_date=date("m-d-Y",strtotime($ords['Update_date']));
												$tUnixTime = time();
												list($month, $day, $year) = EXPLODE('-', $Transaction_date);
												$timeStamp = mktime(0, 0, 0, $month, $day, $year);
												$num_days= ceil(abs($timeStamp - $tUnixTime) / 86400);
											/******************Calculate Days******************/
											if($num_days<=$Return_policy_in_days)
											{
											 ?>										
										<td>
										  <a href="javascript:void(0);" onclick="return_order('<?php echo $ords['Trans_id'];?>','<?php echo $ords['Bill_no'];?>','<?php echo $ords['Voucher_no'];?>','<?php echo $item_name;?>');" title="Delete"> <?php echo ('Return'); ?> </a>
										</td>
										<?php } 
										}?>
									</tr>
								
								<?php 
								}
								}
							
							}
							else
							{?>
							<tr><td colspan="4" class="text-center"><?php echo ('No Records Found'); ?></td></tr>	
							<?php
							}
							?>
							
						</tbody>
					</table>
				</div>
				<!-- /.table-responsive -->
				<div class="panel-footer"><?php echo $pagination; ?></div>
			</div>
			<!-- /.box -->

		</div>
		
	</div>
	
</section>
<script>
function cancel_order(Trans_id,Bill_no,Voucher_no,Item_name)
{	
// alert(Voucher_no);
	BootstrapDialog.confirm("Are you sure to cancel the Order  "+Item_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Shopping/Update_order_status/?serial_id='+Trans_id+'&Bill_no='+Bill_no+'&Voucher_no='+Voucher_no;
		if (result == true)
		{
			show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		}
	});
}
function return_order(Trans_id,Bill_no,Voucher_no,Item_name)
{	

	BootstrapDialog.confirm("Are you sure to Return Initiated the Order  "+Item_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Shopping/Update_order_status_return/?serial_id='+Trans_id+'&Bill_no='+Bill_no+'&Voucher_no='+Voucher_no;
		if (result == true)
		{
			show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		}
	});
}
</script>	
<?php $this->load->view('header/footer'); ?>