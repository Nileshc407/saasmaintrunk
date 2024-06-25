<?php 
// $this->load->view('header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
?>

	<?php if($Client_company_Trans != NULL) { ?>
		<div class="element-wrapper">                
			<div class="element-box">
			  <h5 class="form-header">
			   Client Companies Details
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
														
							
							<th>Partner Company Name</th>
							<th>Client Company Name</th>
							<th>Total Enrollments</th>
							<th>Total Outlets</th>
							<th>Total Purchase</th>
							<th>Total Gain Points</th>
							<th>Total Bonus Points</th>
							<th>Total Redeem Points</th>
							
							
							
							
						</tr>
					</thead>						
					<tfoot>
						<tr>
							<th>Partner Company Name</th>
							<th>Client Company Name</th>
							<th>Total Enrollments</th>
							<th>Total Outlets</th>
							<th>Total Purchase</th>
							<th>Total Gain Points</th>
							<th>Total Bonus Points</th>
							<th>Total Redeem Points</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
								foreach($Client_company_Trans as $trans)
								{
									$Company_total_enrollment = $ci_object->Igain_model->Get_total_enrollment($trans['Company_id']);
									foreach($Company_total_enrollment as $tot)
									{
										$Totalenrollment= $tot['Total_enrollment'];
									}
									if($Totalenrollment == "" || $Totalenrollment == '0')
									{
										$Totalenrollment="-";
									}
									else
									{
										$Totalenrollment=$Totalenrollment;
									}
									$Company_total_outlets = $ci_object->Igain_model->Get_total_outlets($trans['Company_id']);
									foreach($Company_total_outlets as $tot)
									{
										$TotalOutlets= $tot['Total_enrollment'];
									}
									if($TotalOutlets == "" || $TotalOutlets == '0')
									{
										$TotalOutlets="-";
									}
									else
									{
										$TotalOutlets=$TotalOutlets;
									}
									if($trans['Purchase_amount'] == "" ||$trans['Purchase_amount']== '0')
									{
										$Purchase_amount="-";
									}
									else
									{
										$Purchase_amount=$trans['Purchase_amount'];
									}
									if($trans['Loyalty_pts'] == "" ||$trans['Loyalty_pts']== '0')
									{
										$Loyalty_pts="-";
									}
									else
									{
										$Loyalty_pts=$trans['Loyalty_pts'];
									}
									if($trans['Topup_amount'] == "" ||$trans['Topup_amount']== '0')
									{
										$Topup_amount="-";
									}
									else
									{
										$Topup_amount=$trans['Topup_amount'];
									}
									if($trans['Total_Redeem_points'] == "" ||$trans['Total_Redeem_points']== '0')
									{
										$Total_Redeem_points="-";
									}
									else
									{
										$Total_Redeem_points=$trans['Total_Redeem_points'];
									}
									
									$Parent_company_details = $ci_object->Igain_model->get_company_details($trans['Parent_company']);
									
									$Sum_redeem = $ci_object->Igain_model->get_total_redeem_point($trans['Company_id']);
									
									if($Sum_redeem->sum_reddemPoints == 0)
									{
									  $sum_reddemPoints ="-";
									}
									else
									{
										$sum_reddemPoints = $Sum_redeem->sum_reddemPoints;
									}
									
									// echo count($Parent_company_details);
									?>
									
									<tr>										
										<td><?php echo $Parent_company_details->Company_name;?></td>
										<td><?php echo $trans['Company_name'];?></td>
										<td><?php echo $Totalenrollment;?></td>
										<td><?php echo $TotalOutlets;?></td>
										<td><?php echo $Purchase_amount;?></td>
										<td><?php echo $Loyalty_pts;?></td>
										<td><?php echo $Topup_amount;?></td>
										<!--<td><?php //echo $Total_Redeem_points;?></td>-->		
										<td><?php echo $sum_reddemPoints;?></td>		
									</tr>
								<?php
								}
								?>
					</tbody>
				</table>
			  </div>
			</div>
		</div>
		<?php } ?>
	<?php /*
		if($Client_company_Trans!=NULL)
		{ ?>
			<div class="panel panel-info">
				<div class="panel-heading"><h4>Client Companies Details</h4></div>
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
							<tr>
								<th class="text-center">Partner Company Name</th>
								<th class="text-center">Client Company Name</th>
								<th class="text-center">Total Enrollments</th>
								<th class="text-center">Total Outlets</th>
								<th class="text-center">Total Purchase</th>
								<th class="text-center">Total Gain Points</th>
								<th class="text-center">Total Bonus Points</th>
								<th class="text-center">Total Redeem Points</th>
								
							</tr>
							</thead>							
							<tbody>
							<?php		
							
								foreach($Client_company_Trans as $trans)
								{
									$Company_total_enrollment = $ci_object->Igain_model->Get_total_enrollment($trans['Company_id']);
									foreach($Company_total_enrollment as $tot)
									{
										$Totalenrollment= $tot['Total_enrollment'];
									}
									if($Totalenrollment == "" || $Totalenrollment == '0')
									{
										$Totalenrollment="-";
									}
									else
									{
										$Totalenrollment=$Totalenrollment;
									}
									$Company_total_outlets = $ci_object->Igain_model->Get_total_outlets($trans['Company_id']);
									foreach($Company_total_outlets as $tot)
									{
										$TotalOutlets= $tot['Total_enrollment'];
									}
									if($TotalOutlets == "" || $TotalOutlets == '0')
									{
										$TotalOutlets="-";
									}
									else
									{
										$TotalOutlets=$TotalOutlets;
									}
									if($trans['Purchase_amount'] == "" ||$trans['Purchase_amount']== '0')
									{
										$Purchase_amount="-";
									}
									else
									{
										$Purchase_amount=$trans['Purchase_amount'];
									}
									if($trans['Loyalty_pts'] == "" ||$trans['Loyalty_pts']== '0')
									{
										$Loyalty_pts="-";
									}
									else
									{
										$Loyalty_pts=$trans['Loyalty_pts'];
									}
									if($trans['Topup_amount'] == "" ||$trans['Topup_amount']== '0')
									{
										$Topup_amount="-";
									}
									else
									{
										$Topup_amount=$trans['Topup_amount'];
									}
									if($trans['Total_Redeem_points'] == "" ||$trans['Total_Redeem_points']== '0')
									{
										$Total_Redeem_points="-";
									}
									else
									{
										$Total_Redeem_points=$trans['Total_Redeem_points'];
									}
									
									$Parent_company_details = $ci_object->Igain_model->get_company_details($trans['Parent_company']);
									
									$Sum_redeem = $ci_object->Igain_model->get_total_redeem_point($trans['Company_id']);
									
									if($Sum_redeem->sum_reddemPoints == 0)
									{
									  $sum_reddemPoints ="-";
									}
									else
									{
										$sum_reddemPoints = $Sum_redeem->sum_reddemPoints;
									}
									
									// echo count($Parent_company_details);
									?>
									
									<tr>										
										<td><?php echo $Parent_company_details->Company_name;?></td>
										<td><?php echo $trans['Company_name'];?></td>
										<td><?php echo $Totalenrollment;?></td>
										<td><?php echo $TotalOutlets;?></td>
										<td><?php echo $Purchase_amount;?></td>
										<td><?php echo $Loyalty_pts;?></td>
										<td><?php echo $Topup_amount;?></td>
										<!--<td><?php //echo $Total_Redeem_points;?></td>-->		
										<td><?php echo $sum_reddemPoints;?></td>		
									</tr>
								<?php
								}
		}
		else
		{ ?>
			<div class="panel panel-info">
				<div class="panel-heading text-center"><h4>No Record Found</h4></div>
			</div>
<?php	}
		?>							
							</tbody> 
						</table>
					</div>
			</div> <?php */ ?>