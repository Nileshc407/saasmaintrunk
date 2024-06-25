		
		<?php 
		$this->load->view('header/header');
		if(($Logged_user_id == 2 && $Super_seller == 0) || $Logged_user_id == 5 || $Logged_user_id == 6 )//|| $Logged_user_id == 4
		{
		?>
        <div class="row">
			<div class="col-md-12">
				<input type="text" name="member_id" tabindex="1" id="member_id" value="" style="border: 0px solid white; color: #fff; outline: none;"/>
				<img src="<?php echo base_url()?>images/landing_page.png" class="img-responsive" style="margin: 0px auto;" />
			</div>
		</div>
<?php
}
else
{
?>
       <div class="content-i">
            <div class="content-box">
              <div class="row">
                <div class="col-sm-12">
                  <div class="element-wrapper">
                   
                    <h6 class="element-header">
                      Dashboard
                    </h6>
                    <div class="element-content">
                      <div class="row">
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#">
                            <div class="label">
                              Total Points Issued
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Total_Gained_Points) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Currency_name ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#">
                            <div class="label">
                              Total Points Used
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_Used) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Currency_name ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#">
                            <div class="label">
                              Total Purchase
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_Purchase_Amount) ;?>
                            </div>
                            <div class="trending trending-up-basic">
								<?php echo $Symbol_currency;?><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			  
				<div class="row">
				
                <div class="col-sm-4">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Enrollment snapshot

                    </h6>
					<?php if($Active_Vs_inactive_member_graph_flag==1){?>
						  <div class="element-box">
						  
                      <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
					  <div class="el-tablo bigger"><div class="label">Active Vs Inactive Members</div></div>
					   <div class="element-inner-desc">
                                  (Last 30 Days)
                        </div>
                        <canvas height="148" id="donutChart11" width="148" class="chartjs-render-monitor" style="display: block; width: 148px; height: 148px;"></canvas>
                        <div class="inside-donut-chart-label">
                          <strong class="counter-count"><?php echo $Total_members; ?></strong><span>Total Members</span>
						 
                        </div>
                      </div>
					  <!--
                      <div class="el-legend">
                        <div class="legend-value-w">
                          <div class="legend-pin" style="background-color: #4ecc48;"></div>
                          <div class="legend-value">
                            Active : &nbsp;<?php echo $Active_percentage ; ?>%
                          </div>
                        </div>
                        <div class="legend-value-w">
                          <div class="legend-pin" style="background-color: #f37070;"></div>
                          <div class="legend-value">
                            Inactive : &nbsp;<?php echo $InActive_percentage; ?>%
                          </div>
                        </div>
                      
                      </div>-->
                    </div>
					<?php  } ?>
                   </div>
                </div>
                
                <div class="col-sm-8">
                  <!--START - Top Selling Chart-->
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      &nbsp;
                    </h6>
					<?php   if($Member_enrollments_graph_flag==1){?>
						  <div class="element-box">
                      <div class="os-tabs-w">
                        <div class="element-actions">
						  <form class="form-inline justify-content-sm-end">
							<select class="form-control form-control-sm rounded" id="enrollment" onchange="get_enrollment_line_graph(this.value)">
							 <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6" selected>
								Last 6 Months 
							  </option>
							  <option value="0">
								Last 1 Year 
							  </option>
							</select>
						  </form>
						</div>
                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_overview">
                            <div class="el-tablo bigger">
                              <div class="label">
                                Member Enrollment
								
                              </div>
                              <div class="value counter-count" id="Total_enrollments"></div>
                            </div>
                            <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
							 
                              <canvas height="152" id="lineChart_sixmonth" width="611" class="chartjs-render-monitor" style="display: block; width: 611px; height: 152px;"></canvas>
                              <canvas height="152" id="lineChart_1year" width="611" class="chartjs-render-monitor" style="display: block; width: 611px; height: 152px;display:none;"></canvas>
                              <canvas height="152" id="lineChart_3month" width="611" class="chartjs-render-monitor" style="display: block; width: 611px; height: 152px;display:none;"></canvas>
                            </div>
                          </div>
                         
                        </div>
                      </div>
					  <br><br>
                    </div>
				  
				  <?php  }?>	
                  </div>
                </div>
				
              </div>

	
				<div class="row">
                <div class="col-sm-6">
				
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Points and Transaction  snapshot


                    </h6>
					<?php   if($Total_point_issued_Vs_total_points_redeemed_graph_flag==1){?>
					<div class="element-box">
						 <div class="element-actions">
						 
						  <form class="form-inline justify-content-sm-end">
							<select class="form-control form-control-sm rounded" id="points_stats" onchange="get_points_stats_line_graph(this.value)">
							  <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6">
								Last 6 Months 
							  </option>
							  <option value="0">
								Last 1 Years 
							  </option>
							  
							</select>
						  </form>
						</div> 
						
						 <div class="tab-content">
                          <div class="tab-pane active" id="tab_overview">
                            <div class="el-tablo bigger">
                              <div class="label">
                                Points Statistics

                              </div>
                            </div>
                            <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                              <canvas id="canvas1"></canvas>
							<canvas id="canvas2" style="display:none;"></canvas>
							<canvas id="canvas3" style="display:none;"></canvas>
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_sales"></div>
                          <div class="tab-pane" id="tab_conversion"></div>
                        </div>
						
							
							
					</div>
				   <?php  }?>	
                    </div>
                   </div>
               
			 <div class="col-sm-6">
                  <!--START - Top Selling Chart-->
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      &nbsp;
                    </h6>
					<?php   if($No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag==1){?>
						  <div class="element-box">
						 <div class="element-actions">
						 
						  <form class="form-inline justify-content-sm-end">
							<select class="form-control form-control-sm rounded" id="trans_stats" onchange="get_trans_line_graph(this.value)">
							  <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6">
								Last 6 Months 
							  </option>
							  <option value="0">
								Last 1 Years 
							  </option>
							  
							</select>
						  </form>
						</div> 
						
						 <div class="tab-content">
                          <div class="tab-pane active" id="tab_overview">
                            <div class="el-tablo bigger">
                              <div class="label">
                                Transaction Statistics

                              </div>
                            </div>
                            <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                              <canvas id="canvas4"></canvas>
							  <canvas id="canvas5" style="display:none;"></canvas>
								<canvas id="canvas6" style="display:none;"></canvas>
							
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_sales"></div>
                          <div class="tab-pane" id="tab_conversion"></div>
                        </div>
						
							
							
					</div>
				  
				   <?php  }?>	
                  </div>
                  <!--END - Top Selling Chart-->
                </div>		
			  </div>
           <!-------------------------------------------------------------------------------->
		   <?php   if($Transaction_Order_Types_graph_flag==1){?>
		   	<div class="row">
                <div class="col-sm-6">
				
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Purchase Order  snapshot


                    </h6>
					
					<div class="element-box">
						 <div class="element-actions">
						 
						  <form class="form-inline justify-content-sm-end">
							<select class="form-control form-control-sm rounded" id="Order_type" onchange="get_trans_order_type(this.value)">
							  <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6">
								Last 6 Months 
							  </option>
							  <option value="0">
								Last 1 Years 
							  </option>
							  
							</select>
						  </form>
						</div> 
						
						 <div class="tab-content">
                          <div class="tab-pane active" id="tab_overview">
                            <div class="el-tablo bigger">
                              <div class="label">
                               Number of Transaction (By Order Type)

                              </div>
                            </div>
                            <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                              <canvas id="canvas111"></canvas>
							<canvas id="canvas211" style="display:none;"></canvas>
							<canvas id="canvas311" style="display:none;"></canvas>
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_sales"></div>
                          <div class="tab-pane" id="tab_conversion"></div>
                        </div>
						
							
							
					</div>
				   
                    </div>
                   </div>
               
			 <div class="col-sm-6">
                  <!--START - Top Selling Chart-->
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      &nbsp;
                    </h6>
					
						  <div class="element-box">
						 <div class="element-actions">
						 
						  <form class="form-inline justify-content-sm-end">
							<select class="form-control form-control-sm rounded" id="Order_type2" onchange="get_trans_order_type2(this.value)">
							  <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6">
								Last 6 Months 
							  </option>
							  <option value="0">
								Last 1 Years 
							  </option>
							  
							</select>
						  </form>
						</div> 
						
						 <div class="tab-content">
                          <div class="tab-pane active" id="tab_overview">
                            <div class="el-tablo bigger">
                              <div class="label">
                                Value of Transaction in KES (By Order Type)

                              </div>
                            </div>
                            <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                               <canvas id="canvas1111"></canvas>
							<canvas id="canvas2111" style="display:none;"></canvas>
							<canvas id="canvas3111" style="display:none;"></canvas>
							
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_sales"></div>
                          <div class="tab-pane" id="tab_conversion"></div>
                        </div>
						
							
							
					</div>
				  
				  
                  </div>
                  <!--END - Top Selling Chart-->
                </div>		
			  </div>
           <?php  }?>	
           <!-------------------------------------------------------------------------------->
		   <?php   if($Total_quantity_issued_Vs_total_quantity_used_graph_flag==1){?>	    
				<div class="row">
                <div class="col-sm-6 d-xxxl-none">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Merchandizing Snapshot
					</h6>
					 
						<div class="element-box">
                      
					  
							<div class="os-tabs-w">
								<div class="element-actions">
								  <form class="form-inline justify-content-sm-end">
									<select class="form-control form-control-sm rounded" onchange="get_items_issued_used_qty(this.value)" id="item_issued_used">
									  <option value="9">
										Last 3 Months
									  </option>
									  <option value="6">
										Last 6 Months 
									  </option>
									  <option value="0">
										Last 1 Years 
									  </option>
									</select>
								  </form>
								</div>
								<div class="tab-content">
								  <div class="tab-pane active" id="tab_overview">
									<div class="el-tablo bigger">
									  <div class="label">
										Items Issued Vs Used

									  </div>
									
									</div>
									<div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
										<canvas id="canvas7"></canvas>
										<canvas id="canvas8" style="display:none;"></canvas>
										<canvas id="canvas9" style="display:none;"></canvas>
									</div>
								  </div>
								  <div class="tab-pane" id="tab_sales"></div>
								  <div class="tab-pane" id="tab_conversion"></div>
								</div>
							  </div>
                      
						</div>
						
                   </div>
                </div>
                
                <div class="col-sm-6">
					 <div class="element-wrapper">
                    <h6 class="element-header">
                      &nbsp;
					</h6>
						<div class="element-box">
                      
					  
							<div class="os-tabs-w">
								<div class="element-actions">
								  <form class="form-inline justify-content-sm-end">
									<select class="form-control form-control-sm rounded" onchange="get_items_ordered_deliv_qty(this.value)" id="item_order">
									  <option value="9">
										Last 3 Months
									  </option>
									  <option value="6">
										Last 6 Months 
									  </option>
									  <option value="0">
										Last 1 Years 
									  </option>
									</select>
								  </form>
								</div>
								<div class="tab-content">
								  <div class="tab-pane active" id="tab_overview">
									<div class="el-tablo bigger">
									  <div class="label">
										Items Ordered Vs Delivered

									  </div>
									
									</div>
									<div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
										<canvas id="canvas10"></canvas>
										<canvas id="canvas11" style="display:none;"></canvas>
										<canvas id="canvas12" style="display:none;"></canvas>
									</div>
								  </div>
								  <div class="tab-pane" id="tab_sales"></div>
								  <div class="tab-pane" id="tab_conversion"></div>
								</div>
							  </div>
                      
						</div>
                   </div>
               
                </div>
				
				
           </div>
	              <?php  }?>	
			     
				<div class="row">
              
                
                <div class="col-sm-12">
					 
                  
                  <div class="element-wrapper">
                    <h6 class="element-header">Popular Merchandizing Category</h6>
					<div class="element-box">
				   <canvas id="category_bar"></canvas>
                  </div>
                 </div>
                 
                </div>
				
				
           </div>
			   
				<div class="row">
                <div class="col-sm-3 d-xxxl-none">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Survey  Analysis
					</h6>
					<div class="element-box">
						  <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
							<canvas height="148" id="donutChart3" width="148" class="chartjs-render-monitor" style="display: block; width: 148px; height: 148px;"></canvas>
							<div class="inside-donut-chart-label">
							  <span><?php echo $Survey_name_1; ?></span>
							</div>
						  </div>
                      
                    </div>
                   </div>
                </div>
                
                <div class="col-sm-3 d-xxxl-none">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      &nbsp;
					</h6>
					<div class="element-box">
						  <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
							<canvas height="148" id="donutChart4" width="148" class="chartjs-render-monitor" style="display: block; width: 148px; height: 148px;"></canvas>
							<div class="inside-donut-chart-label">
							  <span><?php echo $Survey_name_2; ?></span>
							</div>
						  </div>
                      
                    </div>
                   </div>
                </div>
             <style>
					#hover-content {
						display:none;
					}
					#parent:hover #hover-content {
						display:block;
					 width: 30%;
					  background-color: #3E4B5B;
					  
					  text-align: left;
					  border-radius: 6px;
					 font-size :10px;
					  /* Position the tooltip */
					  position: absolute;
					  z-index: 1;
					  left: 35%;
					  
					}
					</style>
                <div class="col-sm-6">
				<div class="element-wrapper">
                    <h6 class="element-header">Survey  Respondents</h6>
					
						<div class="element-box">
						<?php
						if($SURVEY_RESPONDENTS !=NULL)
						{
							foreach($SURVEY_RESPONDENTS as $survey)
							{
								$Survey_percentage=($survey['Total_actual_taken_survey']/$survey['Total_send'])*100;
								
					?>
					
                      <div class="os-progress-bar primary" >
                        <div class="bar-labels" >
                          <div class="bar-label-left">
                            <span class="bigger"><?php echo $survey['Survey_name']; ?></span>
                          </div>
                          <div class="bar-label-right">
                            <span class="info"><?php echo $survey['Total_send'].' /'.$survey['Total_actual_taken_survey'].' Responded'; ?></span>
                          </div>
                        </div>
						<!--
                        <div class="bar-level-1" style="width: 100%">
						
                          <div class="progress-bar progress-bar-striped progress-bar-animated"  id="parent" style="width: 100%;height: 20px;background-color: #ffb84d;">
						  
                            <div class="progress-bar progress-bar-striped progress-bar-animated" <?php echo 'style="height: 20px;font-size:13px;background-color: #4ecc48;width:'.round($Survey_percentage).'%;"'; ?>><?php echo round($Survey_percentage); ?> %</div>
							 <div id="hover-content" >
									<?php echo '<b><span style="color: #fff;margin-left:10px;">'.$survey['Survey_name'].'</b></span>'; ?>
									<?php echo '<br><span style="color: #5bc0de;margin-left:10px;">Sent to: '.$survey['Total_send'].' Members</span>'; ?>
									<?php echo '<br><span style="color: #4ecc48;margin-left:10px;">Responded: '.$survey['Total_actual_taken_survey'].' Members</span>'; ?>
									<?php echo '<br><span style="color: #ffb84d;margin-left:10px;">Pending: '.$survey['Total_actual_Untaken_survey'].' Members</span>'; ?>
								</div>
                          </div>
					
                        </div>-->
						<div class="bar-level-1" style="width: 100%" id="parent" >
                          <div class="bar-level-2" style="width: 100%">
                            <div class="bar-level-3" <?php echo 'style="width:'.round($Survey_percentage).'%;"'; ?>></div>
                          </div>
						  <div id="hover-content" >
									<?php echo '<b><span style="color: #fff;margin-left:10px;">'.$survey['Survey_name'].'</b></span>'; ?>
									<?php echo '<br><span style="color: #5bc0de;margin-left:10px;">Sent to: '.$survey['Total_send'].' Members</span>'; ?>
									<?php echo '<br><span style="color: #4ecc48;margin-left:10px;">Responded: '.$survey['Total_actual_taken_survey'].' Members</span>'; ?>
									<?php echo '<br><span style="color: #ffb84d;margin-left:10px;">Pending: '.$survey['Total_actual_Untaken_survey'].' Members</span>'; ?>
								</div>
                        </div>
                      </div>
                     
					<?php

							}
						}
					?>
                    
                    </div>
                    </div>
				  
				  
                  </div>
                </div>
  
			 
				<div class="row">
					<?php   if($Happy_member_flag==1){?>	
					<div class="col-sm-6">
					  <!--START - Top Selling Chart-->
							  
					  <div class="element-wrapper">
						<h6 class="element-header">TOP 5 Key Members</h6>
					   
							  <div class="element-box-tp">
						  <div class="table-responsive">
							<table class="table table-padded">
							  <thead>
								<tr>
								 
								  <th>
									Member Name
								  </th>
								  <th>
									MembershipID
								  </th>                         
								  <th>
									Last Visit
								  </th>
								 
								</tr>
							  </thead>
							  <tbody>
							  <?php
								if($happy_customers != NULL)
								{
									$Total_Purchase_amount = $happy_customers['Total_Purchase_amount'];
									$Total_Loyalty_pts = $happy_customers['Total_Loyalty_pts'];
									$Total_Redeem_points = $happy_customers['Total_Redeem_points'];
									$Customer_name = $happy_customers['Customer_name'];
									$Customer_email = $happy_customers['Customer_email'];
									$Customer_phno = $happy_customers['Customer_phno'];
									$Card_id = $happy_customers['Card_id'];
									$Last_visit = $happy_customers['Last_visit'];
									$Photograph = $happy_customers['Photograph'];
									
									for($i=0;$i<5;$i++)
									{
										if($Total_Purchase_amount[$i] != NULL)
										{
											$Last_visit_date = date('jS F',strtotime($Last_visit[$i]));
											$Last_visit_TIME = date('H:i:s',strtotime($Last_visit[$i]));
											// echo "<br>".base_url().''.$Photograph[$i];
											if($Photograph[$i]==NULL || $Photograph[$i]=='' )
											{
												$Photograph[$i]='images/no_image.jpeg';
											}
											echo '<tr>
									  
												  <td>
													<div class="user-with-avatar">
													  <img alt="" src="'.base_url().''.$Photograph[$i].'"><span>'.$Customer_name[$i].'</span><br><span  class="smaller lighter">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.App_string_decrypt($Customer_phno[$i]).'</span>
													</div>
												  </td>
												  <td class="text-center">
												   
													  <a class="badge badge-success-inverted" >'.$Card_id[$i].'</a>
												   
												  </td>
												  <td>
													<span>'.$Last_visit_date.'</span><br><span class="smaller lighter">'.$Last_visit_TIME.'</span>
												  </td>
												</tr>';
										}
									}
									
								}
								?>
								
							 
							  
							  </tbody>
							</table>
						  </div>
						</div>
					  
						 
						</div>
							  
						</div>
					  <?php  }?>	
					<?php   if($Worry_member_flag==1){?>	        
					<div class="col-sm-6">
					  <!--START - Top Selling Chart-->
					  <div class="element-wrapper">
						<h6 class="element-header">TOP 5 Worry Members</h6>
							  <div class="element-box-tp">
						  <div class="table-responsive">
							<table class="table table-padded" style="margin-top:-19px;">
							  <thead>
								<tr>
								 
								  <th>
									Member Name
								  </th>
								  <th>
									MembershipID
								  </th>
								 
								  <th>
									Last Visit
								  </th>
								 
								</tr>
							  </thead>
							  <tbody>
					   
								 <?php
								 
								if($worry_customers != NULL)
								{
									
									$Customer_name = $worry_customers['Customer_name'];
									$Card_id = $worry_customers['Card_id'];
									$Last_visit = $worry_customers['Last_visit'];
									$Photograph = $worry_customers['Photograph'];
									$Customer_phno = $worry_customers['Customer_phno'];
									for($i=0;$i<5;$i++)
									{
										if($Card_id[$i] != NULL)
										{
											if($Last_visit[$i]==0)
											{
												$Last_visit2 = '<span class="smaller lighter">No Visit Yet</span>';
											}
											else
											{
												$Last_visit_date = date('jS F',strtotime($Last_visit[$i]));
												$Last_visit_TIME = date('H:i:s',strtotime($Last_visit[$i]));
												
												$Last_visit2 = '<span>'.$Last_visit_date.'</span><br><span class="smaller lighter">'.$Last_visit_TIME.'</span>';
											}
											
											// echo "<br>".base_url().''.$Photograph[$i];
											if($Photograph[$i]==NULL || $Photograph[$i]=='' )
											{
												$Photograph[$i]='images/no_image.jpeg';
											}
											echo '<tr>
									  
												  <td>
													<div class="user-with-avatar">
													  <img alt="" src="'.base_url().''.$Photograph[$i].'"><span>'.$Customer_name[$i].'</span><br><span  class="smaller lighter">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.App_string_decrypt($Customer_phno[$i]).'</span>
													</div>
													
												  </td>
												  <td class="text-center">
												   
													  <a class="badge badge-danger-inverted" >'.$Card_id[$i].'</a>
												   
												  </td>
												  <td>
													'.$Last_visit2.'
												  </td>
												</tr>';
										}
									}
									
								}
								?>
								
							   
							   
							  
							  </tbody>
							</table>
						  </div>
						</div>
					  
						 
						</div>
						</div>
					  <?php  }?>	
					  
					  </div>
				   
				<div class="row">
					<div class="col-sm-12">
					  <div class="element-wrapper">
						<h6 class="element-header">Key Customer Suggestions</h6>
					   
							  <div class="element-box-tp">
						  <div class="table-responsive">
						   <table class="table table-padded">
							  <thead>
							 
								<tr>
								 
								  <th>
									Member Name
								  </th>
								  <th>
									MembershipID
								  </th>
								  <th class="text-center">
									Phone No.
								  </th>
								  
								 
								  <th class="text-center">
									SUGGESTIONS
								  </th>
								 
								 
								  <th>
									When
								  </th>
								 
								</tr>
							  </thead>
							  <tbody>
							 <?php 
									foreach($customers_comment as $opt)
									{
											$when = date('jS F',strtotime($opt['Creation_date']));
											$whenTime = date('H:i:s',strtotime($opt['Creation_date']));
											if($opt['Photograph']==NULL || $opt['Photograph']=='')
											{
												$Photograph='images/no_image.jpeg';
											}
											else
											{
												$Photograph= base_url().''.$opt['Photograph'];
											}
										echo ' <tr>
								  
											  <td>
												<div class="user-with-avatar">
												  <img alt="" src="'.$Photograph.'"><span  class="smaller lighter">'.$opt['First_name'].' '.$opt['Last_name'].'</span>
												</div>
											  </td>
											  <td class="text-center">
											   
												  <a class="badge badge-primary-inverted" >'.$opt['Card_id'].'</a>
											   
											  </td>
											  <td class="text-center smaller lighter">
												'.App_string_decrypt($opt['Phone_no']).'
											  </td>
												<td>
												<div class="smaller lighter">
												 '.$opt['Content_description'].'
												</div>
											  </td>
											  <td>
												<span>'.$when.'</span><br><span class="smaller lighter">'.$whenTime.'</span>
											  </td>
											</tr>';	
									}							
								?>
							   
							 
							  
							  </tbody>
							</table>
						  </div>
						</div>
					  
						 
						</div>
						</div>
					  
					
					  
					  
					  </div>
			   
					 
            </div>
        </div>
              
           			  
			  
	<?php 
}
		$this->load->view('header/footer');
	?>
	
<script>
/****************************Line chart start**********************************************************/

	get_enrollment_line_graph(6);
	function get_enrollment_line_graph(enr_val)
	{
			var myObj = JSON.parse('<?php echo $Enrollment_data; ?>');
			var smry_monthArr = new Array();
			var Total_enrollmentsArr = new Array();
		
			for (x in myObj) {
			  smry_monthArr.push(myObj[x].smry_month);
			  Total_enrollmentsArr.push(myObj[x].Total_enrollments);
			}
			
			if(enr_val==6)
			{ 
				var lineChart11 = $("#lineChart_sixmonth");
				$("#lineChart_sixmonth").show();
				$("#lineChart_1year").hide();
				$("#lineChart_3month").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
				
			}
			if(enr_val==0)
			{ 
				var lineChart11 = $("#lineChart_1year");
				$("#lineChart_1year").show();
				$("#lineChart_sixmonth").hide();
				$("#lineChart_3month").hide();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(enr_val==9)
			{ 
				var lineChart11 = $("#lineChart_3month");
				$("#lineChart_3month").show();
				$("#lineChart_1year").hide();
				$("#lineChart_sixmonth").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
				var lineData11 = {
				labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
				datasets: [{
				  label: "Enrolled Member",
				  fill: false,
				  lineTension: 0.3,
				  backgroundColor: "#fff",
				  borderColor: "#047bf8",
				  borderCapStyle: 'butt',
				  borderDash: [],
				  borderDashOffset: 0.0,
				  borderJoinStyle: 'miter',
				  pointBorderColor: "#fff",
				  pointBackgroundColor: "#141E41",
				  pointBorderWidth: 3,
				  pointHoverRadius: 10,
				  pointHoverBackgroundColor: "#FC2055",
				  pointHoverBorderColor: "#fff",
				  pointHoverBorderWidth: 3,
				  pointRadius: 5,
				  pointHitRadius: 10,
				  data: Total_enrollmentsArr.slice(start_rec, smry_monthArr.length),
				  spanGaps: false
				}]
				};
				
			var numbers =Total_enrollmentsArr.slice(start_rec, smry_monthArr.length);
			document.getElementById("Total_enrollments").innerHTML=numbers.reduce(function getSum(total, num) {
			  return total + Math.round(num);}, 0);
			  
			var count =   document.getElementById("Total_enrollments").innerHTML;
			
			var myLineChart = new Chart(lineChart11, {
			type: 'line',
			data: lineData11,
			options: {
			  legend: {
				display: false
			  },
			  scales: {
				xAxes: [{
				  ticks: {
					fontSize: '11',
					fontColor: '#969da5'
				  },
				  gridLines: {
					color: 'rgba(0,0,0,0.05)',
					zeroLineColor: 'rgba(0,0,0,0.05)'
				  }
				}],
				yAxes: [{
				  display: false,
				  ticks: {
					beginAtZero: true,
					max: parseInt(count)
				  }
				}]
			  }
			}
		  });
		
	}
	
	
	/***************************************************get_popular_category****************/
		
		var myObj2 = JSON.parse('<?php echo $popular_category; ?>');
		var Merchandize_category_nameArr = new Array();
		var Total_qtyArr = new Array();
	
		for (x in myObj2) {
		  Merchandize_category_nameArr.push(myObj2[x].Merchandize_category_name);
		  Total_qtyArr.push(myObj2[x].Total_qty);
		}  
        
		
        var barChartData = {
            labels: Merchandize_category_nameArr,
            datasets: [{
                label: 'Merchandize Category',
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: Total_qtyArr
            }]

        };
		
		 var ctx = document.getElementById("category_bar").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                    }
                }
            });
	/***************************************************get_popular_category*XXX***************/
/****************************Line chart finish**********************************************************/
/****************************donutChart start**********************************************************/
    if ($("#donutChart11").length) {
      var donutChart11 = $("#donutChart11");

      // donut chart data
      var data1 = {
        labels: ["Total Inactive Members", "Total Active Members"],
        datasets: [{
          data: [<?php echo $Total_inactive_members; ?>, <?php echo $Total_active_members; ?>],
          backgroundColor: ["#f37070", "#4ecc48"],
          hoverBackgroundColor: ["#e65252", "#24b314"],
          borderWidth: 0
        }]
      };

      // -----------------
      // init donut chart
      // -----------------
      new Chart(donutChart11, {
        type: 'doughnut',
        data: data1,
        options: {
          legend: {
            display: false
          },
          animation: {
            animateScale: true
          },
          cutoutPercentage: 80
        }
      });
    }

		// -------------------------SURVEY ANALYSIS------------------------------------------------------------
	
	//var myObj = ; //alert(a);

	
    if ($("#donutChart3").length) {
      var donutChart3 = $("#donutChart3");
		 var Total_promoters = '<?php echo $Total_promoters_1; ?>';   
		var Total_passive = '<?php echo $Total_passive_1; ?>';   
		 var Total_dectractor = '<?php echo $Total_dectractor_1; ?>';   
		
	
      // donut chart data
      var data = {
        labels: ["Promoters", "Passive", "Dectractor"],
        datasets: [{
          data: [Total_promoters, Total_passive, Total_dectractor],
          backgroundColor: ["#4ecc48", "#ffb84d", "#f37070"],
          hoverBackgroundColor: ["#24b314", "#ffcc29", "#e65252"],
          borderWidth: 0
        }]
      };

      // -----------------
      // init donut chart
      // -----------------
      new Chart(donutChart3, {
        type: 'doughnut',
        data: data,
        options: {
          legend: {
            display: false
          },
          animation: {
            animateScale: true
          },
          cutoutPercentage: 80
        }
      });
    }
	// -----------------
    if ($("#donutChart4").length) {
      var donutChart4 = $("#donutChart4");

      var Total_promoters2 = '<?php echo $Total_promoters_2; ?>';   
		var Total_passive2 = '<?php echo $Total_passive_2; ?>';   
		var Total_dectractor2 = '<?php echo $Total_dectractor_2; ?>';   
		
	
      // donut chart data
      var data = {
        labels: ["Promoters", "Passive", "Dectractor"],
        datasets: [{
          data: [Total_promoters2, Total_passive2, Total_dectractor2],
          backgroundColor: ["#4ecc48", "#ffb84d", "#f37070"],
          hoverBackgroundColor: ["#24b314", "#ffcc29", "#e65252"],
          borderWidth: 0
        }]
      };

      // -----------------
      // init donut chart
      // -----------------
      new Chart(donutChart4, {
        type: 'doughnut',
        data: data,
        options: {
          legend: {
            display: false
          },
          animation: {
            animateScale: true
          },
          cutoutPercentage: 80
        }
      });
    }
/****************************donutChart finish**********************************************************/

</script>
<script>

		
$('.counter-count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
		//<?php echo number_format($Total_Gained_Points) ;?>
		
    });
	
</script>

 <script>
 
		/****************Select index 6 Months onload***************************/
		$("select#points_stats").val('6');
		$("select#trans_stats").val('6');
		$("select#item_issued_used").val('6');
		$("select#item_order").val('6');
		
		/*********************************************************/
		
		/**********************************POINTS STATISTICS************************************/
		var myObj22 = JSON.parse('<?php echo $Trans_data; ?>');
		var smry_monthArr = new Array();
		var Total_loyalty_pointsArr = new Array();
		var Total_redeem_pointsArr = new Array();
		var Total_loyalty_countArr = new Array();
		var Total_redeem_countArr = new Array();
		var Total_online_purchase_countArr = new Array();
	
		for (x in myObj22) {
		  smry_monthArr.push(myObj22[x].smry_month);
		  if(myObj22[x].Total_loyalty_points== null){myObj22[x].Total_loyalty_points=0;}
		  if(myObj22[x].Total_redeem_points== null){myObj22[x].Total_redeem_points=0;}
		  if(myObj22[x].Total_loyalty_count== null){myObj22[x].Total_loyalty_count=0;}
		  if(myObj22[x].Total_redeem_count== null){myObj22[x].Total_redeem_count=0;}
		  if(myObj22[x].Total_online_purchase_count== null){myObj22[x].Total_online_purchase_count=0;}
		  
		  Total_loyalty_pointsArr.push(myObj22[x].Total_loyalty_points);
		  Total_redeem_pointsArr.push(myObj22[x].Total_redeem_points);
		  Total_loyalty_countArr.push(myObj22[x].Total_loyalty_count);
		  Total_redeem_countArr.push(myObj22[x].Total_redeem_count);
		  Total_online_purchase_countArr.push(myObj22[x].Total_online_purchase_count);
		} 
		get_points_stats_line_graph(6);
		function get_points_stats_line_graph(val)
		{
			
           if(val==9)
			{ 
				var ctx = document.getElementById("canvas1").getContext("2d");
				$("#canvas1").show();
				$("#canvas2").hide();
				$("#canvas3").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx = document.getElementById("canvas2").getContext("2d");
				$("#canvas1").hide();
				$("#canvas2").show();
				$("#canvas3").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx = document.getElementById("canvas3").getContext("2d");
				$("#canvas1").hide();
				$("#canvas2").hide();
				$("#canvas3").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config3 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Total Points Issued",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Total_loyalty_pointsArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Total Points Redeemed",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Total_redeem_pointsArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx, config3);
		}
      
	
		get_trans_line_graph(6);
		function get_trans_line_graph(val)
		{
				
			//var val = $('#trans_stats').val();
		
           if(val==9)
			{ 
				var ctx2 = document.getElementById("canvas4").getContext("2d");
				$("#canvas4").show();
				$("#canvas5").hide();
				$("#canvas6").hide();
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx2 = document.getElementById("canvas5").getContext("2d");
				$("#canvas4").hide();
				$("#canvas5").show();
				$("#canvas6").hide();
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx2 = document.getElementById("canvas6").getContext("2d");
				$("#canvas4").hide();
				$("#canvas5").hide();
				$("#canvas6").show();
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
		
			
				var config1 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Total Loyalty Trans.",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Total_loyalty_countArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Total Redeem Trans.",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Total_redeem_countArr.slice(start_rec, smry_monthArr.length),
						}, {
							label: "Total Online Purchase Trans.",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Total_online_purchase_countArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};	
				window.myLine = new Chart(ctx2, config1);	
			
		}
	
	
	
		/**********************************Order Type************************************/
		$("select#Order_type").val('6');
		$("select#Order_type2").val('6');
		var myObj22 = JSON.parse('<?php echo $purchase_count; ?>');
		var smry_monthArr = new Array();
		var Delivery_countArr = new Array();
		var Delivery_valueArr = new Array();
		var Pickup_countArr = new Array();
		var Pickup_valueArr = new Array();
		var Instore_countArr = new Array();
		var Instore_valueArr = new Array();
	
		for (x in myObj22) {
		  smry_monthArr.push(myObj22[x].smry_month);
		  if(myObj22[x].Delivery_count== null){myObj22[x].Delivery_count=0;}
		  if(myObj22[x].Delivery_value== null){myObj22[x].Delivery_value=0;}
		  if(myObj22[x].Pickup_count== null){myObj22[x].Pickup_count=0;}
		  if(myObj22[x].Pickup_value== null){myObj22[x].Pickup_value=0;}
		  if(myObj22[x].Instore_value== null){myObj22[x].Instore_value=0;}
		  
		  Delivery_countArr.push(myObj22[x].Delivery_count);
		  Delivery_valueArr.push(myObj22[x].Delivery_value);
		  Pickup_countArr.push(myObj22[x].Pickup_count);
		  Pickup_valueArr.push(myObj22[x].Pickup_value);
		  Instore_countArr.push(myObj22[x].Instore_count);
		  Instore_valueArr.push(myObj22[x].Instore_value);
		} 
		get_trans_order_type(6);
		function get_trans_order_type(val)
		{
			
           if(val==9)
			{ 
				var ctx32 = document.getElementById("canvas111").getContext("2d");
				$("#canvas111").show();
				$("#canvas211").hide();
				$("#canvas311").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx32 = document.getElementById("canvas211").getContext("2d");
				$("#canvas111").hide();
				$("#canvas211").show();
				$("#canvas311").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx32 = document.getElementById("canvas311").getContext("2d");
				$("#canvas111").hide();
				$("#canvas211").hide();
				$("#canvas311").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config31 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Pick-up Trans.",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Pickup_countArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "In-Store Trans.",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Instore_countArr.slice(start_rec, smry_monthArr.length),
						}, 
						{
							label: "Delivery Trans.",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Delivery_countArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx32, config31);
		}
      
		get_trans_order_type2(6);
		function get_trans_order_type2(val)
		{
			
           if(val==9)
			{ 
				var ctx321 = document.getElementById("canvas1111").getContext("2d");
				$("#canvas1111").show();
				$("#canvas2111").hide();
				$("#canvas3111").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx321 = document.getElementById("canvas2111").getContext("2d");
				$("#canvas1111").hide();
				$("#canvas2111").show();
				$("#canvas3111").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx321 = document.getElementById("canvas3111").getContext("2d");
				$("#canvas1111").hide();
				$("#canvas2111").hide();
				$("#canvas3111").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config311 = {
					type: 'line',
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "Pick-up Trans.",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Pickup_valueArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "In-Store Trans.",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Instore_valueArr.slice(start_rec, smry_monthArr.length),
						}, 
						{
							label: "Delivery Trans.",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Delivery_valueArr.slice(start_rec, smry_monthArr.length),
						}]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						title:{
							display:true,
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Value'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx321, config311);
		}
      
	
	
	/***************************ITEMS ISSUED VS USED****************************************************/	
	var myObj = JSON.parse('<?php echo $MERCHANDIZING_SNAPSHOT; ?>');
	var smry_monthArr = new Array();
	var Total_issued_quantityArr = new Array();
	var Total_used_quantityArr = new Array();
	var Ordered_quantityArr = new Array();
	var Delivered_quantityArr = new Array();
	var BalanceArr_pick = new Array();
	var BalanceArr_deli = new Array();

	for (x in myObj) {
	  smry_monthArr.push(myObj[x].smry_month);
	  Total_issued_quantityArr.push(myObj[x].Total_issued_quantity);
	  Total_used_quantityArr.push(myObj[x].Total_used_quantity);
	  Ordered_quantityArr.push(myObj[x].Ordered_quantity);
	  Delivered_quantityArr.push(myObj[x].Delivered_quantity);
	  
	  BalanceArr_pick.push(myObj[x].Total_issued_quantity-myObj[x].Total_used_quantity);
	  BalanceArr_deli.push(myObj[x].Ordered_quantity-myObj[x].Delivered_quantity);
	}
	
	get_items_issued_used_qty(6)
	function get_items_issued_used_qty(val)
	{
			//var val = $('#item_issued_used').val();
			
           if(val==9)
			{ 
				$("#canvas7").show();
				$("#canvas8").hide();
				$("#canvas9").hide();
				var ctx77 = document.getElementById("canvas7").getContext("2d");
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				$("#canvas7").hide();
				$("#canvas8").show();
				$("#canvas9").hide();
				var ctx77 = document.getElementById("canvas8").getContext("2d");
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				$("#canvas7").hide();
				$("#canvas8").hide();
				$("#canvas9").show();
				var ctx77 = document.getElementById("canvas9").getContext("2d");
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			} 
		
			var barChartData = {
			labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
			datasets: [{
				type: 'line',
				label: 'Balance',
				borderColor: window.chartColors.blue,
				borderWidth: 2,
				fill: false,
				data: BalanceArr_pick.slice(start_rec, smry_monthArr.length)
			},{
				label: 'Total Issued',
				backgroundColor: ["#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070","#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070"],
				hoverBackgroundColor: ["#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252","#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252"],
				
				stack: 'Stack 0',
				data: Total_issued_quantityArr.slice(start_rec, smry_monthArr.length)
			}, {
				label: 'Total Used',
				backgroundColor: ["#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48","#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48"],
				hoverBackgroundColor: ["#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314","#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314"],
				stack: 'Stack 0',
				data: Total_used_quantityArr.slice(start_rec, smry_monthArr.length)
			}]

		};
				
            window.myBar = new Chart(ctx77, {
                type: 'bar',
                data: barChartData,
                options: {
                    title:{
                        display:true,
						text: 'Pick Up Items'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
					legend: {
							position: 'bottom',
						},
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
		
	}	
		
	get_items_ordered_deliv_qty(6);	
	 function get_items_ordered_deliv_qty(val)
	{
			 if(val==9)
			{ 
				$("#canvas10").show();
				$("#canvas11").hide();
				$("#canvas12").hide();
				
				var ctx78 = document.getElementById("canvas10").getContext("2d");
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				$("#canvas10").hide();
				$("#canvas11").show();
				$("#canvas12").hide();
				
				var ctx78 = document.getElementById("canvas11").getContext("2d");
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				$("#canvas10").hide();
				$("#canvas11").hide();
				$("#canvas12").show();
				
				var ctx78 = document.getElementById("canvas12").getContext("2d");
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var barChartData2 = {
					labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
					datasets: [{
						type: 'line',
						label: 'Balance',
						borderColor: window.chartColors.blue,
						borderWidth: 2,
						fill: false,
						data: BalanceArr_deli.slice(start_rec, smry_monthArr.length)
					}, {
						label: 'Total Ordered',
						backgroundColor: ["#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070","#f37070", "#f37070", "#f37070", "#f37070", "#f37070", "#f37070"],
						hoverBackgroundColor: ["#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252","#e65252", "#e65252", "#e65252", "#e65252", "#e65252", "#e65252"],
						stack: 'Stack 0',
						data: Ordered_quantityArr.slice(start_rec, smry_monthArr.length)
					}, {
						label: 'Total Delivered',
						backgroundColor: ["#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48","#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48", "#4ecc48"],
						hoverBackgroundColor: ["#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314","#24b314", "#24b314", "#24b314", "#24b314", "#24b314", "#24b314"],
						stack: 'Stack 0',
						data: Delivered_quantityArr.slice(start_rec, smry_monthArr.length)
					}]

				};
			
			
            window.myBar = new Chart(ctx78, {
                type: 'bar',
                data: barChartData2,
                options: {
                    title:{
                        display:true,
						text: 'Delivery Items'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
					legend: {
							position: 'bottom'
							
						},
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
		
		}	
 
	/*******************************************************************************/	
    </script>
	
	