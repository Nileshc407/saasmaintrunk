<?php  
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');
echo form_open_multipart('Cust_home/mystatement');
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
?>
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
<section class="content-header">
	<h1>My Reports </h1>  
</section>
<section class="content">
	<div class="row">	
		<div class="login-box">
			<div class="login-box-body">			
				<div class="form-group has-feedback">
					<label for="exampleInputEmail1">
						 From Date 
					</label>
					<div class="input-group">
						<!--
						<input type="text" name="startDate" id="datepicker1" class="form-control" placeholder="From Date" required/>	 id="input_01" 		
						 -->
						 <input id="datepicker" class="datepicker form-control "  name="startDate" type="text"  >
						 <span class="input-group-addon" id="basic-addon2"><i class="fa fa-calendar"></i></span>
					</div>					
					<div id="container"></div>
					
				</div>				
				<div class="form-group has-feedback">
					<label for="exampleInputEmail1">
						To Date 
					</label>
					<div class="input-group">
						<input id="datepicker1" class="datepicker form-control"   name="endDate" type="text" >
					<!--<div class="input-group"> id="input_02" 
						<input type="text" name="endDate" id="datepicker2" class="form-control" placeholder="To Date" required/>-->
						 <span class="input-group-addon" id="basic-addon2"><i class="fa fa-calendar"></i></span>
					</div>
				</div>				
				<div class="form-group has-feedback">
					<label for="exampleInputPassword1">Redemption Report</label>
					<label class="radio-inline">
					<input type="radio"  name="Redeemption_report"  id="Redeemption_report_01"    value="1" >Yes
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio"  name="Redeemption_report"  id="Redeemption_report_02"    checked value="0"  >No
					</label>						
					<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
					<div class="help-block"></div>
				</div>
				<div id="other_report">
				<div class="form-group has-feedback">
					<label for="exampleInputPassword1">Name</label>
					<select class="form-control" name="Merchant"  id="Merchant" >
						<option value="0">All</option>
						<?php 											
						 foreach($Seller_details as $seller)
						{
							echo "<option value=".$seller['Enrollement_id'].">".$seller['First_name'].' '.$seller['Last_name']."</option>";
						} 										
						?>
					</select>						
					<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
					<div class="help-block"></div>
				</div>				
				<div class="form-group has-feedback">
					<label for="exampleInputPassword1">Transaction Types</label>
					<select class="form-control" name="Trans_Type" id="Trans_Type" >
						<option value="0">All</option>
						<?php 											
						foreach($TransactionTypes as $Trans)
						{
							echo "<option value=".$Trans['Trans_type_id'].">".$Trans['Trans_type']."</option>";
						}										
						?>
					</select>						
					<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
					<div class="help-block"></div>
				</div>
				</div>				
				<div class="form-group has-feedback">
					<label for="exampleInputPassword1">Report Type</label>
					<select class="form-control" name="Report_type"  id="Report_type" >
						<option value="0" >Details</option>
						<option value="1" >Summary</option>
					</select>						
					<div class="help-block"></div>
				</div>				
				<div class="row">				
					<div class="col-xs-12">				 
						<button type="submit" id="submit2" class="btn btn-primary btn-block btn-flat" name="submit" >Submit</button>
						<button type="reset" class="btn btn-primary btn-block btn-flat">Reset</button>					
						<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
						  <input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
						  <input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
						  <input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
					</div>
				</div> 
			  </div>
		</div>
	</div>	
	<?php
	$Report_type=$_REQUEST['Report_type'];						
	$From_date=date("Y-m-d",strtotime($_REQUEST["startDate"]));
	$To_date=date("Y-m-d",strtotime($_REQUEST["endDate"]));
	$Merchant=$_REQUEST["Merchant"];
	$Trans_Type=$_REQUEST["Trans_Type"];			
	$Redeemption_report=$_REQUEST["Redeemption_report"];
	
	$page=(count($Count_Records)/10); 
	//echo "count-->".count($Count_Records);echo "<br>page ".$page;
	
	?>
	
	<div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title">Latest Transaction</h3>                 
		</div>
				
		<div class="box-body">
			<div class="table-responsive">
				<div align="right">
					<label for="exampleInputEmail1">Page: </label>
					<select  name="page" ID="page" onchange="pagination_item(this.value);"  >
					<?php
						$page=(count($Count_Records)/10); 
						echo "count-->".count($Count_Records);echo "<br>page ".$page;
						$page=($page+0.4);
						for($i=1;$i<=round($page);$i++)
						{
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
					<option value="0">All</option>
					</select>							
					</div>
				<table class="table table-bordered">
				<thead>
				<tr> 
				<?php 
					if($Redeemption_report==1)  
					{ 						
						if($Report_type==0) 
						{
						?>
							<th>Transaction Date</th>
							<th>Transaction Type</th>					  
							<th>Item Name</th>					  
							<th>Item Size</th>					  
							<th>Quantity</th>					  
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?> </th>	
							<th>Shipping <?php echo $Company_Details->Currency_name; ?> </th>	
							<th>Voucher No</th>	
							<th>Voucher Status</th>	
						<?php
						}
						else
						{
						?>
							<th>Transaction Type</th>
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?> </th>
							<th>Shipping <?php echo $Company_Details->Currency_name; ?> </th>
							<th>Quantity</th>														
						<?php
						}
					} 
					else 
					{ 
						if($Report_type==0) 
						{ 
						?>
							<th>Transaction Date</th>
							<th>Bill No.</th>
							<th>Transaction Type</th>
							<th>Item Name</th>					  
							<th>Item Size</th>					  
							<th>Quantity</th>
							<th>Purchase Amount/Miles/Rewards</th>
							<th>Shipping Cost</th>
							<th>Bonus <?php echo $Company_Details->Currency_name; ?> </th>						  
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?> </th>						  
							<th>Gained <?php echo $Company_Details->Currency_name; ?> </th>
							<th>Done By</th>
							<th>Transfer <?php echo $Company_Details->Currency_name; ?> </th>
							<th>Transfer To/From</th>
							<th>Remarks</th>
						<?php
						}
						else
						{ 
						?>					 
							<th>Transaction Type</th>
							<th>Purchase Amount/Miles/Rewards</th>
							<th>Bonus <?php echo $Company_Details->Currency_name; ?> </th>						  
							<th>Redeem <?php echo $Company_Details->Currency_name; ?> </th>						  
							<th>Gained <?php echo $Company_Details->Currency_name; ?> </th>
							<th>Transfer <?php echo $Company_Details->Currency_name; ?> </th>
							<th>Shipping Cost</th>
						<?php
						}
					}
					?>
				</tr>					
				</thead>				
				<tbody>					 
					<?php 
					if($Transaction_Reports != "")
					{
						
						// echo"----Redeemption_report-------".$Redeemption_report."---<br>";
						// echo"----Report_type-------".$Report_type."---<br>";
						foreach($Transaction_Reports as $Trans_RPT)
						{
							if($Redeemption_report ==0 )
							{
								// echo"TransferTo-------".$Trans_RPT['TransferTo'];
								if($Report_type =='1')
								{				
									// echo"TransactionTypeID-----".$Trans_RPT->TransactionTypeID;
									if($Trans_RPT->TransactionTypeID == 25)
									{
										$TotalPurchaseAmount=round($Trans_RPT->TotalPurchaseAmount);
										
									} else {
										
										$TotalPurchaseAmount=$Trans_RPT->TotalPurchaseAmount;
									}
								?>
									<tr>							  
										<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $TotalPurchaseAmount; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalBonusPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalRedeemPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalGainPoints; ?></div></td>							  
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalTransPoints; ?></div></td>							  
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalShippingCost; ?></div></td>							  
									</tr>
								<?php 
								}
								else
								{
									// echo"TransactionTypeID-----".$Trans_RPT->TransactionTypeID."<br>";
									
									if($Trans_RPT->TransactionTypeID == 25)
									{
										$PurchaseAmount=round($Trans_RPT->PurchaseAmount);
										
									} else {
										
										$PurchaseAmount=$Trans_RPT->PurchaseAmount;
										
									}

									
								?>						
									<tr>							 
										<td><?php echo date('d-M-y', strtotime($Trans_RPT->TransactionDate)); ?></td>
										<td><?php echo $Trans_RPT->BillNo; ?></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->Item_name; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->Item_size; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->Quantity; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $PurchaseAmount; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->Shipping_cost; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->BounsPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->RedeemPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->GainPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->DoneBy;  ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TransferPoints; ?></div></td>										
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->TransferToFrom; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Remarks; ?></div></td>
									</tr>									
								<?php
								}
							}
							else
							{
								
								if($Report_type==0)
								{
								?>
									<tr>							 
										<td><?php echo date('d-M-y', strtotime($Trans_RPT->TransactionDate)); ?></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->ItemName; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Item_size; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->TotalQuantity; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->TotalItemRedeemPoints; ?></div></td>									
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Shipping_points; ?></div></td>									
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->VoucherNo; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->VoucherStatus; ?></div></td>
									</tr>
								
								<?php
								}
								else
								{
								?>
									<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
									<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalItemRedeemPoints; ?></div></td>
									<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalShippingpoints; ?></div></td>
									<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalQuantity; ?></div></td>
									
								<?php
								}								
							}
						}
					}	
				?>
				<?php 
				// echo"smartphone_flag-----".$smartphone_flag."<br>";
				if($smartphone_flag == 2)
				{
				?>
					<tr>					 
						<td colspan="12" >
							<a href="<?php echo base_url()?>index.php/Cust_home/export_customer_report/?report_type=<?php echo $Report_type; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&Merchant=<?php echo $Merchant; ?>&Trans_Type=<?php echo $Trans_Type; ?>&Enrollment_id=<?php echo $Enroll_details->Enrollement_id; ?>&membership_id=<?php echo $Enroll_details->Card_id; ?>&pdf_excel_flag=1&Redeemption_report=<?php echo $Redeemption_report; ?>">
							<img class="img-responsive img-thumbnail" src="<?php echo $this->config->item('base_url2')?>images/Excel.png" width="50" alt="Excel Dump" title="Excel Dump"/>
							</a>
					
							<a href="<?php echo base_url()?>index.php/Cust_home/export_customer_report/?report_type=<?php echo $Report_type; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&Merchant=<?php echo $Merchant; ?>&Trans_Type=<?php echo $Trans_Type; ?>&Enrollment_id=<?php echo $Enroll_details->Enrollement_id; ?>&membership_id=<?php echo $Enroll_details->Card_id; ?>&pdf_excel_flag=2&Redeemption_report=<?php echo $Redeemption_report; ?>">
							<img class="img-responsive img-thumbnail" src="<?php echo $this->config->item('base_url2')?>images/pdf.png" width="50" alt="PDF Dump" title="PDF Dump"/>
							</a>
						</td>
					</tr>
				<?php } ?>
					  
				</tbody>	  
				</table>
			</div>
		</div>
		
		<div class="box-footer clearfix"></div>				
	</div>
</section>		
		
<?php echo form_close(); ?>
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');

	if(isset($_REQUEST["page_limit"]))
	{
		$limit=$_REQUEST["page_limit"];
		$Select_index=($limit/10)-1;
		if($limit==0)///All
		{
		
			//$Select_index=$page+1;
			echo "<script>";
			echo "var theSelect=document.getElementById('page');";
			echo "theSelect.selectedIndex =theSelect.options.length-1;";
			echo "</script>";
		}
		else
		{
			echo "<script>";
			echo "document.getElementById('page').selectedIndex =$Select_index;";
			echo "</script>";
		}
	}
?>
	  
	  
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
		
<style type="text/css">
.demo { position: relative; }
.demo i { position: absolute; bottom: 10px; right: 24px; top: auto; cursor: pointer;}
.login-box, .register-box { margin:2% auto;}	  
.dropdown-menu{cursor: pointer !Important;}
.day{background-color: #fff;border-color: #3071a9;color: #000;border-radius:4px;}	 
</style>
	
<script>

$("#submit2").click(function(){
	// alert($("#Redeemption_report_02").val()=='');
	// var Redeemption_report_02
	var Title = "Application Information";	
	if($("#datepicker").val()=="")
	{
		var msg = 'Please Select From Date';
		runjs(Title,msg);
		return false;
	}
	if($("#datepicker1").val()=="")
	{
		var msg = 'Please Select To Date';
		runjs(Title,msg);
		return false;
	}
});
</script>
			
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script type="text/javascript">
  $(function() {
  
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	
	$( "#datepicker1" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	
  });
  </script>
  <script type="text/javascript">
	$("#Redeemption_report_01").click(function(){
			// alert();
			$("#other_report").hide();
			
		});
		$("#Redeemption_report_02").click(function(){
			$("#other_report").show();
		});
    </script>
    <script type="text/javascript">

function pagination_item(limit)
{


	/* $Report_type=$_REQUEST['Report_type'];						
	$From_date=date("Y-m-d",strtotime($_REQUEST["startDate"]));
	$To_date=date("Y-m-d",strtotime($_REQUEST["endDate"]));
	$Merchant=$_REQUEST["Merchant"];
	$Trans_Type=$_REQUEST["Trans_Type"];			
	$Redeemption_report=$_REQUEST["Redeemption_report"]; */

					 
	limit=(limit*10);
	var Enrollment_id='<?php echo $Enroll_details->Enrollement_id; ?>';
	var membership_id='<?php echo $Enroll_details->Card_id; ?>';
	var Company_id='<?php echo $Company_id; ?>';
	var From_date='<?php echo $From_date; ?>';
	var To_date='<?php echo $To_date; ?>';
	var Merchant='<?php echo $Merchant; ?>';
	var Report_type='<?php echo $Report_type; ?>';
	var Trans_Type='<?php echo $Trans_Type; ?>';
	var Tier_id='<?php echo $Tier_id; ?>';
	var Redeemption_report='<?php echo $Redeemption_report; ?>';
	
	window.location='<?php echo base_url()?>index.php/Cust_home/mystatement?page_limit='+limit+'&Company_id='+Company_id+'&startDate='+From_date+'&endDate='+To_date+'&Merchant='+Merchant+'&Report_type='+Report_type+'&Trans_Type='+Trans_Type+'&Redeemption_report='+Redeemption_report+'&Enrollment_id='+Enrollment_id+'&membership_id='+membership_id;

}
			
    </script>

			