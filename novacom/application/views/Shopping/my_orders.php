<?php $this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->model('Shopping_model'); ?>

<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

<section class="content-header">
<h1>My Online Orders</h1>	 
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
<?php }

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
								<th>Online Order No.</th>
								<th>POS Bill No.</th>
								<th>Order Date</th>
								<th>Outlet Name</th>
								<th>Amount (<?php echo $Symbol_of_currency; ?>)</th>
								<th>Order Status</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if($Orders !="")
							{
								foreach($Orders as $ords)
								{
									if($ords['Voucher_status']==20) //Delivered 
									{
										if($ords['Delivery_method'] == 28 ) //Take Away
										{
											$Voucher_status= 'Collected'; 
											$color='green';
										}
										else if($ords['Delivery_method'] == 29) // Delivery
										{
											$Voucher_status= 'Delivered'; 
											$color='green';
										}
										else if($ords['Delivery_method'] == 107) // In-Store
										{
											$Voucher_status= 'Collected'; 
											$color='green';
										}
										else
										{
											$Voucher_status= ''; 
											$color='';
										}
									}
									elseif($ords['Voucher_status']==19) //Out For Delivery
									{
										$Voucher_status=  'Out for delivery'; 
										$color='#337ab7';
									}
									elseif($ords['Voucher_status']==21) //Cancel
									{
										$Voucher_status= 'Cancel'; 
										$color='red';
									}
									elseif($ords['Voucher_status']==22) //Return Initiated
									{
										$Voucher_status = 'Return Initiated'; 
										$color='#800000';
									}
									elseif($ords['Voucher_status']==18) //Ordered
									{
										$Voucher_status =  'Ordered'; 
										$color='#00c0ef';
									} 
									elseif($ords['Voucher_status']==23) //Returned
									{
										$Voucher_status = 'Returned'; 
										$color='#808080';									
									} 
									elseif($ords['Voucher_status']==111) //Accepted
									{
										$Voucher_status = 'Accepted'; 
										$color='#808080';									
									} 
									else
									{
										$Voucher_status = "";
										$color='#C0C0C0';	
									}
									
								?>
								<?php 
									$Trans_id = string_encrypt($ords['Trans_id'], $key, $iv);	
									$Trans_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Trans_id);
									$Get_item_name = $ci_object->Shopping_model->Get_item_details($Company_id,$ords['Item_code']);	
									
									foreach($Get_item_name as $item_name1)
									{
										$merchandise_item_id = $item_name1->Company_merchandise_item_id;
										$item_name = $item_name1->Merchandize_item_name;
										$Item_image = $item_name1->Thumbnail_image1;
										$POS_bill_no= $ords['Manual_billno'] ;
										if($POS_bill_no!=NULL)
										{
											$POS_bill_no1 = $POS_bill_no;
										}
										else
										{
											$POS_bill_no1 = "-";
										}
									?>
							
									<tr>
										<td><?php echo $ords['Bill_no']; ?></td>
										<td><?php echo $POS_bill_no1; ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($ords['Trans_date'])); ?></td>	
										<td><?php echo $ords['Outlet_name']; ?></td>	
									
										<td><?php echo $ords['Purchase_amount']; ?></td>
										<td><span><?php echo $Voucher_status; ?></span></td>
										<td>
										<td>
											<a href="<?php echo base_url()?>index.php/Shopping/order_details/?serial_id=<?php echo urlencode($ords['Bill_no']); ?>" title="View">View</a>									
																				
										</td>
										<?php if($ords['Voucher_status']==18) //Ordered
										{ /*?>
										<td>
										  <a href="javascript:void(0);" onclick="cancel_order('<?php echo $ords['Trans_id'];?>','<?php echo $ords['Bill_no'];?>','<?php echo $ords['Voucher_no'];?>','<?php echo $item_name;?>');" title="Delete">Cancel</a>
										</td>
										<?php } ?>
											<?php if($ords['Voucher_status']==19) //Shipped
										{ ?>
										<td>
										  <a href="javascript:void(0);" onclick="cancel_order('<?php echo $ords['Trans_id'];?>','<?php echo $ords['Bill_no'];?>','<?php echo $ords['Voucher_no'];?>','<?php echo $item_name;?>');" title="Delete">Cancel</a>
										</td>
										<?php  */ }  ?>
										<?php if($ords['Voucher_status']==20) //Delivered
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
										/*	 ?>										
										<td>
										  <a href="javascript:void(0);" onclick="return_order('<?php echo $ords['Trans_id'];?>','<?php echo $ords['Bill_no'];?>','<?php echo $ords['Voucher_no'];?>','<?php echo $item_name;?>');" title="Delete">Return</a>
										</td>  */ ?>
										<?php } 
										}?>
							<?php /*	<td>
										  <button type="button" class="btn btn-warning" onclick="Show_item_info('<?php echo $merchandise_item_id; ?>');" style="text-transform: none;">Order again</button>
										</td>  */ ?>
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
<!-- Modal -->
<div id="item_info_modal" class="modal fade" role="dialog" style="overflow:auto;">
	<div class="modal-dialog" style="width: 70%;" id="Show_item_info">
		<div class="modal-content" >
			<div class="modal-header">
				<div class="modal-body">
					<div class="table-responsive" id="Show_item_info"></div>
				</div>
			</div>
	
		</div>
	</div>
</div>
<!-- Modal -->
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
function Show_item_info(Company_merchandise_item_id)
{	
	// document.getElementById("loadingDiv").style.display="";
	$.ajax({
		type: "POST",
		data: {Company_merchandise_item_id: Company_merchandise_item_id},
		url: "<?php echo base_url()?>index.php/Shopping/Show_product_details",
		success: function(data)
		{	
			$("#Show_item_info").html(data.transactionReceiptHtml);	
			$('#item_info_modal').show();
			$("#item_info_modal").addClass( "in" );	
			//$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
</script>	
<?php $this->load->view('header/footer'); ?>