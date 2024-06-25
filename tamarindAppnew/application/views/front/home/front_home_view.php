<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Home</title>	
	<?php $this->load->view('front/header/header');
	
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }	
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	
	
						$ci_object = &get_instance(); 
						$ci_object->load->model('Igain_model');
							
								$Enrollement_id=$Enroll_details->Enrollement_id;
								$Company_id=$Enroll_details->Company_id;
								$Card_id=$Enroll_details->Card_id;
								// var_dump($Next_Tier_Details);
								$Next_Tier_name=$Next_Tier_Details->Tier_name;
								$Tier_level_id=$Next_Tier_Details->Tier_level_id;
								$Excecution_time=$Next_Tier_Details->Excecution_time;
								$Tier_criteria=$Next_Tier_Details->Tier_criteria;
								$Criteria_value=$Next_Tier_Details->Criteria_value;
								$Operator_id=$Next_Tier_Details->Operator_id;
								
								
								// echo '------Next_Tier_name------'.$Next_Tier_name."---<br>"; 
								
								if($Operator_id==1)
								{
									$OperatorName="=";
								}
								else if($Operator_id==2)
								{
									$OperatorName=">";
								}
								else if($Operator_id==3)
								{
									$OperatorName=">=";
								}
								else if($Operator_id==4)
								{
									$OperatorName="<";
								}
								else if($Operator_id==5)
								{
									$OperatorName="<=";
								}
								else
								{
									$OperatorName=" ";
								}
								
								if($Tier_criteria==1)
								{
									$criteriaName='Cumulative Spend';
								
									if($Excecution_time=="Monthly")
									{ 
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -1 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend; 	
									}
									else if($Excecution_time=="Quaterly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -3 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend; 
									}
									else if($Excecution_time=="Bi-annually")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -6 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend; 
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
									}
									else if($Excecution_time=="Yearly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -12 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Spend=$CriteriaValueDiff->Total_Spend;
										$Remaning_value=$Criteria_value-$Total_Spend;
										$Remaning_value=number_format($Remaning_value,2);
										// echo '<br>Total Cumulative Spend---- '.$Total_Spend;
										
										$Tier_value="If you Purchase an amount <b>".$Currency_Symbol.' '.$Remaning_value."</b> further times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
									}
								}
								else if($Tier_criteria==2)
								{
									$criteriaName='Cumulative Number of Transactions';
										
									if($Excecution_time=="Monthly")
									{ 
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -1 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 
									}
									else if($Excecution_time=="Quaterly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -3 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 		
									}
									else if($Excecution_time=="Bi-annually")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -6 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 
									}
									else if($Excecution_time=="Yearly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -12 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Total_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Transactions=$CriteriaValueDiff->Total_Transactions;
										$Remaning_value=$Criteria_value-$Total_Transactions;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value="If you Purchase <b>".$Remaning_value."</b> more times you will be upgraded to <b>".$Next_Tier_name." Tier</b>";
										$Tier_value=" Earn <b>".$Criteria_value."</b> ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
										// echo '<br>Cumulative Number of Transactions-- '.$Total_Transactions; 
										
										// $Tier_value=" Earn <b>".$Criteria_value."</b> Points and you will be entitiled for an upgrade <b>".$Next_Tier_name." Tier</b>";
									}
								}
								else if($Tier_criteria==3)
								{
									$criteriaName='Cumulative '.$Company_Details->Currency_name.' Accumlated';
									
									if($Excecution_time=="Monthly")
									{ 
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -1 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
										$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
									}
									else if($Excecution_time=="Quaterly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -3 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
										
											$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
									}
									else if($Excecution_time=="Bi-annually")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -6 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
										
											$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
										
										// echo '<br>Cumulative Points Accumlated---- '.$Total_Points; 	
									}
									else if($Excecution_time=="Yearly")
									{
										$Todays_date=date("Y-m-d");
										$From_date = strtotime($Todays_date .' -12 months');
										$From_date=date("Y-m-d",$From_date);
										
										$CriteriaValueDiff = $ci_object->Igain_model->Get_Cumulative_Points_Accumlated($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date); 	
										
										$Total_Points=$CriteriaValueDiff->Total_Points;
										$Remaning_value=$Criteria_value-$Total_Points;
										$Remaning_value=round($Remaning_value);
										
											$Tier_value=" Earn ".$Criteria_value." ".$Company_Details->Currency_name." and you are a <b style=\"font-size:16px\">".$Next_Tier_name." Member </b>";
										
										// echo '<br>Cumulative Points Accumlated----- '.$Total_Points; 
									}
								}
								else if($Tier_criteria==4)
								{
									$criteriaName='Tenor - No. of Days';
									$Todays_date=date("Y-m-d");
									$From_date = strtotime($Todays_date .' -'.$Criteria_value.' days');
									$From_date=date("Y-m-d",$From_date);
									$Trans_Records2 = $this->Igain_model->Get_Cumulative_spend_transactions($Enrollement_id,$Card_id,$Company_id,$From_date,$Todays_date);
									// $Remaning_value=$Trans_Records2->Total_Spend;
									// echo "<br><b>Total_Spend -->".$Remaning_value."</b>";
								}
								else
								{
									$criteriaName='-';
								}
						
						
							/* echo '------Enroll_details------'.$Enroll_details->Total_balance."---<br>"; 
							echo '------Debit_points------'.$Enroll_details->Debit_points."---<br>"; 
							echo '------Block_points------'.$Enroll_details->Block_points."---<br>";  */
						
						
						
						$Current_point_balance = ($Enroll_details->Total_balance-($Enroll_details->Debit_points + $Enroll_details->Block_points));
				
						if($Current_point_balance<0)
						{
						 $Current_point_balance=0;
						}
						else
						{
							$Current_point_balance=$Current_point_balance;
						}
						
	?> 
  </head>
  <body>
  <?php $this->load->view('front/header/menu'); ?>
  <!--<form  name="search_publisher" method="POST" action="<?php echo base_url()?>index.php/Transfer_publisher/Search_publisher" enctype="multipart/form-data">-->
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height: 480px;">
        <div class="container">
           <!-- <div class="section-header">          
                <!--<p><a href="<?php //echo base_url(); ?>index.php/Cust_home/Transfer_points_menu" style="color:#ffffff;"></a></p> -
            </div> --> 
		<?php  /* ?>			
			<div class="row pricing-tables" id="front_head">
                <div class="col-xs-12">
					<!------------Trending Items--------------------->
					                
                         
                        
                           
								<div class="col-md-12" style=" padding: 2px;  margin: 0;">
								 <img src="<?php echo $this->config->item('base_url2')."images/image1.png"; ?>"  width="350" height="200"> 
								</div>
								<div class="col-md-12" style=" padding: 2px;  margin: 0;">
									
									<img src="<?php echo $this->config->item('base_url2')."images/image2.png"; ?>" width="350" height="200">
								</div>
								<div class="col-md-12" style=" padding: 2px;  margin: 0;">
									
									<img src="<?php echo $this->config->item('base_url2')."images/image3.png"; ?>" width="350" height="200">
								</div>
								
								<!--<div class="col-md-12" style=" padding:0;margin:0;">
									<br>
									<button type="button"  style="width: 100%;padding:5px;" onclick="window.location.href='<?php //echo base_url(); ?>index.php/Shopping'" id="button">Order Now</button>
								</div> -->
							
						
                    
                </div>
            </div>
			<?php  */ ?>

		<div class="row pricing-tables">
			<div class="col-xs-12">
						<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head" style="background:#fff; margin-bottom:0px;">  
								<div class="pricing-details">
									<div class="container">
										<div class="row">
											<div class="col-md-12" style="padding:0; margin:0;">
												<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
												  <ol class="carousel-indicators" style="bottom: 16px;">
													<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
													<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
													<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
												  </ol>
												  <div class="carousel-inner">		
														<div class="carousel-item active">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image1.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>
														<div class="carousel-item">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image2.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>
														<div class="carousel-item">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image3.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>											
												  </div>
												 <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
													<span class="carousel-control-prev-icon" aria-hidden="true" style="background-color:#babfba; margin-bottom:50px;"></span>
													<span class="sr-only">Previous</span>
												  </a>
												  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
													<span class="carousel-control-next-icon" aria-hidden="true" style="background-color:#babfba; margin-bottom:50px;"></span>
													<span class="sr-only">Next</span>
												  </a> -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head" style="background:#fff; margin-bottom:0px;">  
								<div class="pricing-details">
									<div class="container">
										<div class="row">
											<div class="col-md-12" style="padding:0; margin:0;">
												<div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
												  <ol class="carousel-indicators" style="bottom: 16px;">
													<li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
													<li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
													<li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
												  </ol>
												  <div class="carousel-inner">		
														<div class="carousel-item active">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image2.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>
														<div class="carousel-item">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image3.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>
														<div class="carousel-item">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image1.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>											
												  </div>
												  <!--<a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev">
													<span class="carousel-control-prev-icon" aria-hidden="true" style="background-color:#babfba; margin-bottom:50px;"></span>
													<span class="sr-only">Previous</span>
												  </a>
												  <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next">
													<span class="carousel-control-next-icon" aria-hidden="true" style="background-color:#babfba; margin-bottom:50px;"></span>
													<span class="sr-only">Next</span>
												  </a> -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> 
							
							<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head" style="background:#fff; margin-bottom:0px;">  
								<div class="pricing-details">
									<div class="container">
										<div class="row">
											<div class="col-md-12" style="padding:0; margin:0;">
												<div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
												  <ol class="carousel-indicators" style="bottom: 16px;">
													<li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>
													<li data-target="#carouselExampleIndicators2" data-slide-to="1"></li>
													<li data-target="#carouselExampleIndicators2" data-slide-to="2"></li>
												  </ol>
												  <div class="carousel-inner">		
														<div class="carousel-item active">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image3.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>
														<div class="carousel-item">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image2.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>
														<div class="carousel-item">
															<div class="col-md-4" style="margin: 0;padding: 0;">
																<div class="card" style="margin: 0;padding: 0;">
																	<img class="card-img-top" src="<?php echo $this->config->item('base_url2')."images/image1.png"; ?>" alt="" width="350" height="200">
																</div>
															</div>
														</div>											
												  </div>
												 <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
													<span class="carousel-control-prev-icon" aria-hidden="true" style="background-color:#babfba; margin-bottom:50px;"></span>
													<span class="sr-only">Previous</span>
												  </a>
												  <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
													<span class="carousel-control-next-icon" aria-hidden="true" style="background-color:#babfba; margin-bottom:50px;"></span>
													<span class="sr-only">Next</span>
												  </a> -->
												</div>
											</div>
										</div>
									</div>
								</div><br>
							</div>
			
			
			
			
			
				</div>
		</div>
        </div>
    </div>
	
	
	<?php $this->load->view('front/header/footermenu'); ?>
  <!--</form>-->
    <!-- End Pricing Table Section-->		
	<!-- Loader -->
	<div class="container" >
		<div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
						<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			</div>
		</div>       
	</div>
	<!-- Loader -->
        
		
  

		
  </body>
<?php $this->load->view('front/header/footer'); ?> 
<?php if($Session_count == 1 ) { ?>
<?php /* ?>
<style>
.modal-dialog {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}
.modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}
</style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script>
	
	
	$(window).on('load',function(){
        $('#helpModal').modal('show');
			
    }); 	
	var slide=0;
	$("#myCarousel img").click(function() {		
		$(".carousel-inner").carousel("next")
		slide = slide+1;
		if(slide ==3 ){
			$('#helpModal').modal('hide');
			
			window.location.href = '<?php echo base_url(); ?>index.php/Cust_home/tutorial_session_insert';
		}
	}); 
		
 
</script>

<?php */ ?>


<script>

var Session_count=<?php echo $Session_count; ?>;
/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */
/* var tour = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'hopscotch-title',
      title: 'Click Here For Menu Options',
      // content: 'Click Here For Menu Options',
      placement: 'right',
      arrowOffset:0,
	  
	   yOffset: -20
    },    
    {
      target: 'menu-icon',
      placement: 'top',
      title: 'View our menu and place your orders',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-80,
	   yOffset: 20
    },    
    {
      target: 'offer-icon',
      placement: 'top',
      title: 'Get updated on our Latest Offers that are',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-90,
	   yOffset:15
    }
  ],
  showPrevButton: true,
  scrollTopMargin: 100
}, */



var tour = {
  id: 'hello-hopscotch',
  steps: [
    {
      target: 'hopscotch-title',
      title: 'Click Here For Menu Options',
      // content: 'Click Here For Menu Options',
      placement: 'right',
      arrowOffset:0,	  
	   yOffset: -20
    },    
    {
      target: 'menu-icon',
      placement: 'top',
      title: 'View our menu and place your orders',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	  xOffset:-65,
	   yOffset: 3,
	    "onNext": function() {
        window.location.href = "<?php echo base_url(); ?>index.php/Shopping?page=front_home";
      },
      "multipage": true
    },
	{
      target: 'Mcategory',
      placement: 'top',
      title: 'Mcategory',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-80,
	   yOffset: 20,
	    "onNext": function() {
        window.location.href = "<?php echo base_url(); ?>index.php/Shopping?page=front_home";
      },
      "multipage": true
    },    
    {
      target: 'offer-icon',
      placement: 'top',
      title: 'Get updated on our Latest Offers',
      // content: 'Once you have Hopscotch on your page, you\'re ready to start making your tour! The biggest part of your tour definition will probably be the tour steps.',
	   arrowOffset: 60,
	   xOffset:-65,
	   yOffset:3,
	    "onPrev": function() {
        window.location.href = "<?php echo base_url(); ?>index.php/Shopping?page=front_home";
      },
      "multipage": true
    }
  ],
  showPrevButton: true,
  scrollTopMargin: 100
},



/* ========== */
/* TOUR SETUP */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
  }
},
init = function() {
  var startBtnId = 'startTourBtn',
      calloutId = 'startTourCallout',
      mgr = hopscotch.getCalloutManager(),
      state = hopscotch.getState();
	  
	if(Session_count == 1) {
	 
		hopscotch.startTour(tour);
	 
	} else {
		
		if (state && state.indexOf('hello-hopscotch:') === 0) {
			// Already started the tour at some point!
			hopscotch.startTour(tour);
		  } else {
			// Looking at the page for the first(?) time.
			/* setTimeout(function() {
			  mgr.createCallout({
				id: calloutId,
				target: startBtnId,
				placement: 'bottom',
				title: 'Take an tour',
				content: 'Start by clicking an tour to see in action!',
				yOffset: -10,
				arrowOffset: 20,
				width: 240
			  });
			}, 100); */
		  }
	}  
  addClickListener(document.getElementById(startBtnId), function() {
    if (!hopscotch.isActive) {
      mgr.removeAllCallouts();
      hopscotch.startTour(tour);
    }
  });
};
init();	



function CallOwnUrl(){	
	// alert('CallOwnUrl');	
	window.location.href = '<?php echo base_url(); ?>index.php/Cust_home/tutorial_session_insert';	
}
</script>

<?php } ?>
<?php /* ?>
<style>	
.card-body>p>img{
	width: 100%;
   /*  height: 248px;	
	margin-left: -21px; ******
}
.card{
	border:none;
}
.card-footer{
	border:none;
}

svg{
  height: 100px;
  width: 100px;
}
circle {
  fill: transparent;
  stroke: white;
  stroke-width: 2;
}
.solid{
  stroke-dasharray: none;
}
.dashed {
  stroke-dasharray: 8, 8.5;
}
.dotted {
  stroke-dasharray: 0.1, 12.5;
  stroke-linecap: round;
}
text {
  width: 100px;
  text-anchor: middle;
  fill: green;
  font-weight: bold;
  text-align: center;
}




#icon{
	float: right;
	margin: 11px 11px auto;
}
	#icon2{
	   width: 25%; 
	}
</style>

<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 5px 5px 10px 40px;
  border: 1px solid #ddd;
  
}

#myTable {
     width: 100%;
	     margin: 0;
    padding: 0;
}





.d-block{
	display:unset !IMPORTANT;
}
</style>
</script>
<?php */ ?>