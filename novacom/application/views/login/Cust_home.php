<?php $this->load->view('header/header'); ?>	
<section class="content-header">
	<h1>Dashboard</h1>
</section>
	<section class="content">	 				
	<?php
		if($Trans_details_summary !=NULL)
		{
			foreach($Trans_details_summary as $values)
			{
				$Total_gained_points=$values["Total_gained_points"];
				$Total_reddems=$values["Total_reddems"];
				$Total_purchase_amt=$values["Total_purchase_amt"];
				$Total_bonus_ponus=$values["Total_bonus_ponus"];
			}
		}
		else
		{
			$Total_gained_points=0;
			$Total_reddems=0;
			$Total_purchase_amt=0;
			$Total_bonus_ponus=0;
		}
		
		$total_gain_points=$total_gain_points->Total_gained_points;
									
		if($total_gain_points!='')
		{
			$TotalGainPoints=$total_gain_points; 
		}
		else
		{
			$TotalGainPoints="0";
		}
		
		$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
		if($Current_point_balance<0)
		{
			$Current_point_balance=0;
		}
		else
		{
			$Current_point_balance=$Current_point_balance;
		}
	?>
		<div class="row">
			<?php  if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?> 
				<div class="col-lg-12 col-xs-12">
					<div class="small-box" style="background-color:#dd4b39 !important;">
						<div class="inner" style="padding: 5px;">
							<h4 class="text-center" style="margin: 3px;color: #fff;">   You have not been assigned Membership ID yet ...Please visit nearest outlet.     </h4>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="row"> 
			<div class="col-md-3">
				<div class="profile-img">
					<div class="box box-info">				
						<div class="box-header with-border">				
							<div class="card">
							<?php 
								/*if($Enroll_details->Photograph == "") { 
									$Photograph= $this->config->item('base_url2')."images/no_image.jpeg";
								} else {
									$Photograph= $this->config->item('base_url2').$Enroll_details->Photograph;
								}*/
								
								$Photograph= base_url()."images/logo-circle.png";
							?> 
								<div class="card-header"><img src="<?php echo $Photograph; ?>" class="img-circle" width="100" height="100" align="center"/></div>
							</div>								
						</div> 
						<div class="box-header with-border">					
							<div class="card text-center">
								<div class="card-header"><b><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name;?></b></div><br>
								<b><?php echo $Tier_details->Tier_name." Member";?> </b><br> 
								<br><b>Membership ID : &nbsp; <?php echo $Enroll_details->Card_id; ?></b>
							</div>
						</div>
					</div>
				</div>
			</div> 
			
			<div class="col-md-3">
				<div class="row">
				<?php if($Company_Details->Loyalty_enabled == 1) {  ?>
					<div class="col-md-12 col-xs-12">						
						<div class="box box-info">				
							<div class="box-header with-border" id="box-header1">				
								<div class="card text-left">
									<div class="card-body" id="card1">
										<table>
										  <tr>
											<td><img src="<?php echo base_url()?>images/cust_dashboard_icons/current_balance.png" style="width: 50%;"></td>
											<td>Balance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
											<td> &nbsp;&nbsp; <b><?php echo round($Current_point_balance); ?></b> </td>   
										  </tr>  
										</table>
									</div> 
								</div>
							</div>
						</div>
					</div>	
					<div class="col-md-12 col-xs-12">
						<div class="box box-info">				
							<div class="box-header with-border" id="box-header1">				
								<div class="card text-left">
									<div class="card-body" id="card1">
										<table>
										  <tr>
										  <td><img src="<?php echo base_url()?>images/cust_dashboard_icons/Earned.png" style="width: 50%;"></td>
											<td><?php //echo $Company_Details->Currency_name; ?> Earned &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
											<td> &nbsp; <b><?php echo $TotalGainPoints; ?></b> </td>   
										  </tr>  
										</table>
									</div> 
								</div>
							</div>
						</div>
					</div>	
					<div class="col-md-12 col-xs-12">
						<div class="box box-info">				
							<div class="box-header with-border" id="box-header1">				
								<div class="card text-left">
									<div class="card-body" id="card1">
									<table>
										  <tr>
										  <td><img src="<?php echo base_url()?>images/cust_dashboard_icons/bonus.png" style="width: 50%;"></td>
											<td>Bonus <?php //echo $Company_Details->Currency_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
											<td> &nbsp; <b><?php echo round($Enroll_details->Total_topup_amt); ?></b> </td>   
										  </tr>  
										</table>
									</div> 
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-xs-12">
						<div class="box box-info">				
							<div class="box-header with-border" id="box-header1">				
								<div class="card text-left">
									<div class="card-body" id="card1">
										 <table>
											<tr>
											<td><img src="<?php echo base_url()?>images/cust_dashboard_icons/redeem.png" style="width: 50%;"></td>
												<td><?php //echo $Company_Details->Currency_name; ?> Redeemed &nbsp;:</td>
												<td> &nbsp; <b><?php echo round($Enroll_details->Total_reddems); ?></b> </td>   
											</tr>  
										</table>
										
									</div> 
									
								</div>
							</div>
						</div>
					</div>	
					<div class="col-md-12 col-xs-12" >	
						<div class="box box-info">				
							<div class="box-header with-border" id="box-header1">				
								<div class="card text-left">
									<div class="card-body" id="card1">
										 <table>
											<tr>
											<td><img src="<?php echo base_url()?>images/cust_dashboard_icons/transfer.png" style="width: 70%;"></td>
												<td><?php //echo $Company_Details->Currency_name; ?> &nbsp;&nbsp;&nbsp;Transferred &nbsp;:</td>
												<td> &nbsp; <b><?php echo round($total_transfer_points->Total_transfer_points); ?></b> </td>   
											</tr>  
										</table>
										
									</div> 
									
								</div>
							</div>
						</div>
					</div>
				<?php } ?>					
				</div>
			</div>
			
			<?php /*
			<div class="col-md-6">
				<h4 style="text-align:center;">Latest Offers</h4>
				<div class="row">
						<?php 
						$offer=0;
						$offer_flag='0';
					/* 	width: 135px;
						height: 100px;
						padding: 3px; */
					/*	$numOfCols = 3;
						$rowCount = 0;
						$bootstrapColWidth = 12 / $numOfCols;
						//print_r($SellerOffers);
						foreach($SellerOffers as $row)
						{
							$offer_description = substr($row[0]['description'], 0, 255);
							if($offer_description !=NULL){
							?>
								<a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers" >
								<div  class="col-md-<?php echo $bootstrapColWidth; ?> mb-5">
									<div class="card">
									  <div class="card-body">								
										
										<div class="card-text" ><?php echo $offer_description; ?></div>					
										
									  </div>
									</div>
								</div>
								</a>
							<?php
								
							$offer++;
							$rowCount++;
							if($rowCount % $numOfCols == 0) echo '</div><div class="row">'; 
								}
						}				
						?> </div>
			</div> */ ?>
		
			<div class="col-xs-12 col-md-6">
				<div class="row">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
					  <!-- Indicators -->
					  <ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
					  </ol>

					  <!-- Wrapper for slides -->
					  <div class="carousel-inner" style="height: 262px;">
						<div class="item active">
						  <img src="<?php echo base_url();?>Website_Images/image1.png" alt="">
						</div>

						<div class="item">
						  <img src="<?php echo base_url();?>Website_Images/image2.png" alt="">
						</div>

						<div class="item">
						  <img src="<?php echo base_url();?>Website_Images/image3.png" alt="">
						</div>
						
						<div class="item">
						  <img src="<?php echo base_url();?>Website_Images/image4.png" alt="">
						</div>
					  </div>

					  <!-- Left and right controls -->
					  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
						<!--<span class="glyphicon glyphicon-chevron-left"></span>-->
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="right carousel-control" href="#myCarousel" data-slide="next">
						<!--<span class="glyphicon glyphicon-chevron-right"></span>-->
						<span class="sr-only">Next</span>
					  </a>
					</div>
				</div>
			</div>
		</div><br>
		<div class="row">
		<?php if($Company_Details->Loyalty_enabled == 1 ) {  ?>
			<div class="col-xs-12 col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">My Statement</h3>
								<div class="box-tools pull-right">						
							  </div>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table no-margin table-bordered table-hover">
										<thead>
											<tr>
												<th>Date</th>
												<th>Outlet</th>
												<th>Type</th>
												<th>Earned </th>
												<th>Redeemed </th>
											</tr>
										</thead>										
										<tbody>
											<?php
											foreach($My_statement_details as $Trans)
											{
												$Merchant_name= $Trans['Seller_name'];
												$Bill_no= $Trans['Bill_no'];
												$Purchase_amount= $Trans['Purchase_amount'];
												$Loyalty_pts= $Trans['Loyalty_pts'];
												$Redeem_points= $Trans['Redeem_points'];
												$Bonus_points= $Trans['Topup_amount'];
												$Transfer_points= $Trans['Transfer_points'];
												$Quantity= $Trans['Quantity'];
											
												if($Merchant_name=="")
												{
													$Merchant_name='-';
												}
												if($Trans['Trans_type_id']=="10")
												{
													$Redeem_points=($Redeem_points*$Quantity); 
												}												
											?>
												<tr>
													<td><?php echo date('Y-m-d H:i:s',strtotime($Trans['Trans_date'])); ?></td>
													<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Merchant_name; ?></div></td>
													<td><?php echo $Trans['Trans_type']; ?></td>
													<td>
														<?php if($Loyalty_pts+$Bonus_points != 0) { ?>
														<div class="sparkbar" data-color="#00a65a" data-height="20">
															<?php echo round($Loyalty_pts+$Bonus_points); ?> 
														 </div>
														<?php } else { ?> - <?php } ?>
													</td>
													<td>
														<div class="sparkbar" data-color="#00a65a" data-height="20">
															<?php echo round($Redeem_points+$Transfer_points); ?>
														</div>
													</td>		 
												</tr>
											<?php } ?>
										</tbody>
									</table>
									<div class="box-footer clearfix">                 
										<a href="<?php echo base_url()?>index.php/Cust_home/mystatement" class="btn btn-sm btn-default btn-flat pull-right">Get All Statement</a>
									</div>
								</div>
							</div>											
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">My Transaction</h3>
								<div class="box-tools pull-right"></div>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table no-margin table-bordered table-hover">
										<thead>
											<tr>
												<th>Date</th>
												<th>Outlet</th>
												<th>Type</th>
												<th>Order No.</th>
												<th>Bill Amt. (<?php echo $Country_details->Symbol_of_currency; ?>)</th>
											</tr>
										</thead>										
										<tbody>
										<?php
											foreach($My_statement_details as $Trans)
											{
												$Merchant_name= $Trans['Seller_name'];
												$Bill_no= $Trans['Bill_no'];
												$Purchase_amount= $Trans['Purchase_amount'];
											
												if($Merchant_name=="")
												{
													$Merchant_name='-';
												}												
												if($Bill_no=="" || $Bill_no=="0")
												{
													$Bill_no='-';
												}
												if($Purchase_amount=="0")
												{
													$Purchase_amount='-';
												}
											?>
												<tr>
													<td><?php echo date('Y-m-d H:i:s',strtotime($Trans['Trans_date'])); ?></td>
													<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Merchant_name; ?></div></td>
													<td><?php echo $Trans['Trans_type']; ?></td>
													<td>
														<div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Bill_no; ?></div>
													</td>
													<td>
														<div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Purchase_amount; ?></div>
													</td>                    
												</tr> 
											<?php } ?>
										</tbody>
									</table>
									<div class="box-footer clearfix">                 
										<a href="<?php echo base_url()?>index.php/Cust_home/mystatement" class="btn btn-sm btn-default btn-flat pull-right">Get All Transactions</a>
									</div>
								</div>
							</div>											
						</div>
					</div>
				</div>
            </div> 
		<?php } else { ?>
		<div class="col-xs-12 col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">My Transaction</h3>
								<div class="box-tools pull-right"></div>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table no-margin table-bordered table-hover">
										<thead>
											<tr>
												<th>Date</th>
												<th>Outlet</th>
												<th>Type</th>
												<th>Order No.</th>
												<th>Bill Amt. (<?php echo $Country_details->Symbol_of_currency; ?>)</th>
											</tr>
										</thead>										
										<tbody>
										<?php
											foreach($My_statement_details as $Trans)
											{
												$Merchant_name= $Trans['Seller_name'];
												$Bill_no= $Trans['Bill_no'];
												$Purchase_amount= $Trans['Purchase_amount'];
												
												if($Merchant_name=="")
												{
													$Merchant_name='-';
												}												
												if($Bill_no=="" || $Bill_no=="0")
												{
													$Bill_no='-';
												}
												if($Purchase_amount=="0")
												{
													$Purchase_amount='-';
												}
											?>
												<tr>
													<td><?php echo date('Y-m-d H:i:s',strtotime($Trans['Trans_date'])); ?></td>
													<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Merchant_name; ?></div></td>
													<td><?php echo $Trans['Trans_type']; ?></td>
													<td>
														<div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Bill_no; ?></div>
													</td>
													<td>
														<div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Purchase_amount; ?></div>
													</td>                    
												</tr> 
											<?php } ?>
										</tbody>
									</table>
									<div class="box-footer clearfix">                 
										<a href="<?php echo base_url()?>index.php/Cust_home/mystatement" class="btn btn-sm btn-default btn-flat pull-right">Get All Transactions</a>
									</div>
								</div>
							</div>											
						</div>
					</div>
				</div>
            </div> 
		<?php } ?>
		</div><br>
		<div class="row">
			<div class="col-xs-12 col-md-4"></div>
			<div class="col-xs-12 col-md-4">
				<div style="max-width:100%;">
					<a href="<?php echo base_url()?>index.php/Shopping">
					<button type="button" name="submit" value="Register" id="Register" class="btn btn-primary btn-block btn-flat" style="padding: 15px 32px;">ORDER NOW</button>
				</a>
				</div>
			</div>
			<div class="col-xs-12 col-md-4"></div> 
		</div><br>
		<?php if($Company_Details->Cust_apk_link != NULL || $Company_Details->Cust_ios_link != NULL) { ?>
		<div class="row" id="footer_div" style="background-color:#332005;">
			<div class="col-md-6 col-xs-12" style="text-align: right;">
				<img src="<?php echo base_url();?>Website_Images/Phone.png" width="10%" height="10%" align="center">
				&nbsp;<span style="color: white; font-size: 20px;">Download our app : </span>
			</div>
			<div class="col-md-6 col-xs-12"><br>
				<?php if($Company_Details->Cust_apk_link != NULL) { ?>
				<div class="col-md-6 col-xs-6">
					<a href="<?php echo $Company_Details->Cust_apk_link; ?>">
						<img src="<?php echo base_url();?>Website_Images/google-play.png" style="width:180px;">
					</a>
				</div>
				<?php } if($Company_Details->Cust_ios_link != NULL) { ?>
				<div class="col-md-6 col-xs-6">
					<a href="<?php echo $Company_Details->Cust_ios_link; ?>">
						<img src="<?php echo base_url();?>Website_Images/iosstore.png" style="width:170px;">
					</a> 
				</div>
			<?php } ?>
			</div>
		</div>
		<?php } ?> 
	</section>
<?php $this->load->view('header/footer');?> 
<style>
	.box-body{
		padding:0px;
	}
	div #offer_block img {
		width: 100%;
		/* height: auto; */
		height: 150px;
	}
	#google-map {
		height: 50% !important;
		left: 0 !important;
		top: 0 !important;
		width: 100% !important;
	}
	#card1
	{
		height: 20px !important;
	}
	#box-header1
	{
		padding: 6px !important;
	}
	.profile-img{
		text-align: center;
	}

	.card-text>p>img{
		width: 135px;
		height: 100px;
		padding: 3px;
	}
	.table>thead>tr>th {
		vertical-align: top !IMPORTANT;
	}
	.table>thead>tr>td {
		vertical-align: top !IMPORTANT;
	}
/* 	#footer_div {
    position: absolute;
    bottom: 30px;
    width: 100%; */
}
</style>