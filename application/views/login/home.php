		
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
else if($Logged_user_id == 2 && $Company_id == 1)
{ ?>
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
                        <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Total Points Liability
                            </div>
                            <div class="value counter-count+" id="count1">
							<?php 
								$Total_Gained_Points = round($Total_Gained_Points);
								$Total_Used = round($Total_Used);
								$Points_liability = ($Total_Gained_Points + $Total_Bonus_Points) - $Total_Used; ?>
								
                              <?php echo number_format($Points_liability) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Currency_name ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Total Loyalty Points Issued
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Total_Gained_Points) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Currency_name ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              <?php if($Enable_company_meal_flag==1 || $Daily_points_consumption_flag==1){echo 'Total Meal Topup Issued';}else{echo 'Total Bonus Points Issued';} ?>
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Total_Bonus_Points) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Currency_name ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
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
                        <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Total Purchase Amount
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_Purchase_Amount) ;?>
                            </div>
                            <div class="trending trending-up-basic">
								<?php echo $Symbol_currency;?><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                               <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Total Paid Amount
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_Paid_amount) ;?>
                            </div>
                            <div class="trending trending-up-basic">
								<?php echo $Symbol_currency;?><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                          
						  <div class="col-sm-3 col-xxxl-3"> &nbsp;  </div>
						  <div class="col-sm-3 col-xxxl-3"> &nbsp;  </div>
						<?php if($Total_Cancellation_Amount > 0){ ?>  
                       <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Total Cancelled Amount
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_Cancellation_Amount) ;?>
                            </div>
                            <div class="trending trending-up-basic">
								<?php echo $Symbol_currency;?><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                               <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Total Points Debited
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_Debited_Points) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Currency_name ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                       <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Total Points Returned
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_Credited_Redeem_points) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Currency_name ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<?php } ?>
                      </div>
					  
					 
					  
                    </div>
                  </div>
                </div>
              </div>  
			  <?php if($Enable_company_meal_flag ==0 && $Daily_points_consumption_flag == 0) { ?>
			  <div class="row">
                <div class="col-sm-12">
                  <div class="element-wrapper">
                   <?php
				   $link1='href="#"';
				   $link2='href="#"';
				   $link3='href="#"';
				   $link4='href="#"';
				   
				   if($Todays_Birthdays_Count > 0){
				   $link1='href="'.base_url().'index.php/Home/Show_more_members/?Flag=1"   target="_self"';
				   }
				   if($Todays_Anniversaries_Count > 0){
				   $link2='href="'.base_url().'index.php/Home/Show_more_members/?Flag=2"   target="_self"';
				   }
				   if($This_Month_Birthdays_Count > 0){
				   $link3='href="'.base_url().'index.php/Home/Show_more_members/?Flag=3"   target="_self"';
				   }
				   if($This_Month_Anniversaries_Count > 0){
				   $link4='href="'.base_url().'index.php/Home/Show_more_members/?Flag=4"   target="_self"';
				   }
				  
				   
				   ?>
                    <h6 class="element-header">
                      Birthday & Anniversary
                    </h6>
                    <div class="element-content">
                       <div class="row">
                        <div class="col-sm-3 col-xxxl-3">

                          <a class="element-box el-tablo highlight"  style="min-height: 130px;"  <?php  echo $link1; ?>>
                            <div class="label">
                              Today's Birthday
                            </div>
                            <div class="value counter-count+" id="count1">
							
								
                              <?php echo number_format($Todays_Birthdays_Count) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight" style="min-height: 130px;"  <?php  echo $link2; ?> >
                            <div class="label">
                              Today's Anniversary
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Todays_Anniversaries_Count) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight"  <?php  echo $link3; ?> style="min-height: 130px;">
                            <div class="label">
                              Birthdays This Month
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($This_Month_Birthdays_Count) ;?>
                            </div>
                           <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-3 col-xxxl-3">
                          <a class="element-box el-tablo highlight"  style="min-height: 130px;"  <?php  echo $link4; ?>>
                            <div class="label">
                              Anniversary's This Month
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($This_Month_Anniversaries_Count) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                       
                      </div>
					  
					  
					 
					  
                    </div>
                  </div>
                </div>
              </div>
			  <?php }?>
			  <?php if($Enable_company_meal_flag ==0 && $Daily_points_consumption_flag == 0) { ?>
			  <div class="row">
                <div class="col-sm-12">
                  <div class="element-wrapper">
                   
                    <h6 class="element-header">
                      Vouchers snapshot
                    </h6>
                    <div class="element-content">
                      <div class="row">
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              % Vouchers Liability
                            </div>
                            <div class="value counter-count+" id="count1">
							<?php 
								$Percentage_Issued_vouchers = round($Percentage_Issued_vouchers);
								$Percentage_Used_vouchers = round($Percentage_Used_vouchers);
								$PercentageVouchers_liability = $Percentage_Issued_vouchers - $Percentage_Used_vouchers; ?>
								
                              <?php echo number_format($PercentageVouchers_liability) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              % Vouchers Issued
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Percentage_Issued_vouchers) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              % Vouchers Used
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Percentage_Used_vouchers) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                      </div> 
					  
					  <div class="row">
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Value Vouchers Liability
                            </div>
                            <div class="value counter-count+" id="count1">
							<?php 
								$Value_Issued_vouchers = round($Value_Issued_vouchers);
								$Value_Used_vouchers = round($Value_Used_vouchers);
								$Value_Vouchers_liability = $Value_Issued_vouchers - $Value_Used_vouchers; ?>
								
                              <?php echo number_format($Value_Vouchers_liability) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Value Vouchers Issued
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Value_Issued_vouchers) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Value Vouchers Used
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Value_Used_vouchers) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                      </div> 
					  
					 <div class="row">
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Value Vouchers Liability
                            </div>
                            <div class="value counter-count+" id="count1">
							<?php 
								$Total_issued_value = round($Total_Value_Issued_vouchers->Total_issued_value);
								$Total_used_value = round($Total_Value_Used_vouchers->Total_used_value);
								$Vouchers_value_liability = $Total_issued_value - $Total_used_value; ?>
								
                              <?php echo number_format($Vouchers_value_liability) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Symbol_currency ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Value Vouchers Issued
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Total_issued_value) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Symbol_currency ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                              Value Vouchers Used
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_used_value) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Symbol_currency ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			  <?php } ?>
			 <?php
			 if($Gift_card_flag==1){
			 ?>
			  <div class="row">
                <div class="col-sm-12">
                  <div class="element-wrapper">
                   
                    <h6 class="element-header">
                      Gift Card snapshot
                    </h6>
                    <div class="element-content">
                      <div class="row">
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                               Liability
                            </div>
                            <div class="value counter-count+" id="count1">
							<?php 
								$Count_issued_giftcard = round($Count_issued_giftcard); 
								$Count_used_giftcard = round($Count_used_giftcard);
								$Giftcard_liability = $Count_issued_giftcard - $Count_used_giftcard; ?>
								
                              <?php echo number_format($Giftcard_liability) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                               Issued
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Count_issued_giftcard) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                               Used
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Count_used_giftcard) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span>Count</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                      </div> 
					  <div class="row">
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                               Liability
                            </div>
                            <div class="value counter-count+" id="count1">
							<?php 
								$Total_issued_giftcard = round($Total_issued_giftcard->Total_issued_giftcard); 
								$Total_used_giftcard = round($Total_used_giftcard->Total_used_giftcard);
								$Total_Giftcard_liability = $Total_issued_giftcard - $Total_used_giftcard;
								?>
								
                              <?php echo number_format($Total_Giftcard_liability) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Symbol_currency ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
						<div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                               Issued
                            </div>
                            <div class="value counter-count+" id="count1">
                              <?php echo number_format($Total_issued_giftcard) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Symbol_currency ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo highlight" href="#" style="min-height: 130px;">
                            <div class="label">
                               Used
                            </div>
                            <div class="value counter-count+">
                              <?php echo number_format($Total_used_giftcard) ;?>
                            </div>
                            <div class="trending trending-up-basic">
                              <span><?php echo $Symbol_currency ;?></span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>
                          </a>
                        </div>
                      </div> 
					  
					</div>
                  </div>
                </div>
              </div>
			 <?php } ?>
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
                <?php   if($Member_enrollments_graph_flag==1){?>
                <div class="col-sm-8">
                  <!--START - Top Selling Chart-->
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      &nbsp;
                    </h6>
					
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
				  
	
                  </div>
                </div>
								  <?php  }?>
              </div>

			<?php   if(($Total_point_issued_Vs_total_points_redeemed_graph_flag==1) && ($No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag==1)){?>
				<div class="row">
                <div class="col-sm-6">
				
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Points and Transaction  snapshot


                    </h6>
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
								Last 1 Year 
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
							<select class="form-control form-control-sm rounded" id="trans_stats" onchange="get_trans_line_graph(this.value)">
							  <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6">
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
				  
                  </div>
                  <!--END - Top Selling Chart-->
                </div>		
			  </div>
			  <?php  }?>
           <!-------------------------------------------------------------------------------->
		   <?php   if($Transaction_Order_Types_graph_flag==1){?>
			<!-- POS ONLINE GRAPH--------------->
			<div class="row">
				<div class="col-sm-6">
				
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Loyalty Transactions snapshot


                    </h6>
					
					<div class="element-box">
						 <div class="element-actions">
						 
						  <form class="form-inline justify-content-sm-end">
							<select class="form-control form-control-sm rounded" id="pos_select" onchange="get_pos_online_trans(this.value)">
							  <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6">
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
                               Number of Transaction

                              </div>
                            </div>
                            <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                              <canvas id="canvas1119"></canvas>
							<canvas id="canvas2119" style="display:none;"></canvas>
							<canvas id="canvas3119" style="display:none;"></canvas>
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_sales"></div>
                          <div class="tab-pane" id="tab_conversion"></div>
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
						 <div class="element-actions">
						 
						  <form class="form-inline justify-content-sm-end">
							<select class="form-control form-control-sm rounded" id="pos_select2" onchange="get_pos_online_trans2(this.value)">
							  <option value="9">
								Last 3 Months 
							  </option>
							  <option value="6">
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
                               Value of Transaction in KES

                              </div>
                            </div>
                            <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                              <canvas id="canvas11199"></canvas>
							<canvas id="canvas21199" style="display:none;"></canvas>
							<canvas id="canvas31199" style="display:none;"></canvas>
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_sales"></div>
                          <div class="tab-pane" id="tab_conversion"></div>
                        </div>
						
							
							
					</div>
				   
                    </div>
                   </div>
             
			</div>	
		   	<div class="row">
                <div class="col-sm-6">
				
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Online Purchase Order  snapshot


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
								Last 1 Year 
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
								Last 1 Year 
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
										Last 1 Year 
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
										Last 1 Year 
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
			     
				<div class="row" id="Categoryhash">
              
                
                <div class="col-sm-12">
					 
                  
                  <div class="element-wrapper">
                    <h6 class="element-header">Popular Menu Groups</h6>
					<div class="element-box">
					<div class="element-actions">
								  <form class="form-inline justify-content-sm-end">
									<select class="form-control form-control-sm rounded" onchange="get_menugroups_bargraph(this.value)" id="Menu_group">
									  <option value="1">
										Last 30 days
									  </option> 
									  <option value="3">
										Last 90 days
									  </option>
									  <option value="6">
										Last 180 days
									  </option>
									  <option value="12">
										Last 1 Year 
									  </option>
									</select>
								  </form>
								</div>
				   <canvas id="category_bar1"></canvas>
				   <canvas id="category_bar12"></canvas>
				   <canvas id="category_bar3"></canvas>
				   <canvas id="category_bar6"></canvas>
				   
				   <?php 
				   for($i=0;$i<=20;$i++){
				   echo '<canvas id="category_item_bar1'.$i.'" style="display:none;"></canvas>';
				   echo '<canvas id="category_item_bar12'.$i.'" style="display:none;"></canvas>';
				   echo '<canvas id="category_item_bar3'.$i.'" style="display:none;"></canvas>';
				   echo '<canvas id="category_item_bar6'.$i.'" style="display:none;"></canvas>';
				   }
				   ?>
				   <!--
				   <div class="row" style="display:none;">
				   <div class="col-sm-3 d-xxxl-none"  >
				   &nbsp;
				   </div>
				   <div class="col-sm-6 d-xxxl-none" align="center" id="category_item_donut" style="display:none;">
				    <div class="element-box">
						  
                      <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
					  <div class="el-tablo bigger"><div class="label" id="donutChart_items_label" >Menu Groups</div></div>
					  
                        <canvas height="148" id="donutChart_items" width="148" class="chartjs-render-monitor" style="display: block; width: 148px; height: 148px;"></canvas>
                        <div class="inside-donut-chart-label">
                         <strong > <div  id="Menu_total">0</div></strong><span>Total </span>
						 
                        </div>
                      </div>
					  
                    </div>
                    </div>
					<div class="col-sm-3 d-xxxl-none"  >
				   &nbsp;
				   </div>
                    </div>-->
				  <div id="back"  style="display:none;"><a href="#Categoryhash" onclick="javascript:Call_back();">Back</a></div>
				   
                  </div>
                 </div>
                 
                </div>
				
				
           </div>
			   <?php if($Survey_analysis == 1){ ?>
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
  
			   <?php } ?>
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
								 
								  <th style="font-size: 0.7em;">
									Member Name
								  </th>
								  <th style="font-size: 0.7em;">
									MembershipID
								  </th> 
								  <th style="font-size: 0.7em;">
									Joined Date
								  </th>                         
								  <th style="font-size: 0.7em;">
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
									$joined_date = $happy_customers['joined_date'];
									
									for($i=0;$i<5;$i++)
									{
										if($Total_Purchase_amount[$i] != NULL)
										{
											// $Last_visit_date = date('jS F',strtotime($Last_visit[$i]));
											// $Last_visit_TIME = date('H:i:s',strtotime($Last_visit[$i]));
											// echo "<br>".base_url().''.$Photograph[$i];
											if($Photograph[$i]==NULL || $Photograph[$i]=='' )
											{
												$Photograph[$i]='images/no_image.jpeg';
											}
											if($Last_visit[$i]==0)
											{
												$Last_visit2 = '<span class="smaller lighter"  style="font-size: 0.7em;">No Visit Yet</span>';
											}
											else
											{
												$Last_visit_date = date('d M Y',strtotime($Last_visit[$i]));
												$Last_visit_TIME = date('H:i:s',strtotime($Last_visit[$i]));
												
												$Last_visit2 = '<span  style="font-size: 0.7em;">'.$Last_visit_date.'</span><br><span class="smaller lighter">'.$Last_visit_TIME.'</span>';
											}
											$joined_dateX = date("d M Y",strtotime($joined_date[$i]));
											echo '<tr>
									  
												  <td>
													<div class="user-with-avatar">
													  <img alt="" src="'.base_url().''.$Photograph[$i].'"><span style="font-size: 0.7em;">'.$Customer_name[$i].'</span><br><span  class="smaller lighter">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.App_string_decrypt($Customer_phno[$i]).'</span>
													</div>
												  </td>
												  <td class="text-center">
												   
													  <a class="badge badge-success-inverted"  style="font-size: 0.7em;">'.$Card_id[$i].'</a>
												   
												  </td>
												  <td>
													<span style="font-size: 0.7em;">'.$joined_dateX.'</span>
												  </td>
												  <td>
													'.$Last_visit2.'
												  </td>
												</tr>';
										}
									}
									
								}
								?>
									<?php
								 
								if($happy_customers != NULL)
								{ ?>
								 <tr>
								<td></td>
								<td></td>
								<td></td>
								<td>
							
									<a target="_self" href="<?php echo base_url(); ?>index.php/Home/Show_more_members/?Flag=5"><button class="btn btn-primary" type="button" style="font-size: 0.6rem !important;margin-left:-15px;">Show More</button></a>
							
								</td>
								</tr>
							 <?php }
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
							<table class="table table-padded" >
							  <thead>
								<tr>
								 
								  <th style="font-size: 0.7em;">
									Member Name
								  </th>
								  <th style="font-size: 0.7em;">
									MembershipID
								  </th>
								 <th style="font-size: 0.7em;">
									Joined Date
								  </th> 
								  <th style="font-size: 0.7em;">
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
									$joined_date = $worry_customers['joined_date'];
									
									for($i=0;$i<5;$i++)
									{
										if($Card_id[$i] != NULL)
										{
											if($Last_visit[$i]==0)
											{
												$Last_visit2 = '<span class="smaller lighter" style="font-size: 0.7em;">No Visit Yet</span>';
											}
											else
											{
												$Last_visit_date = date('d M Y',strtotime($Last_visit[$i]));
												$Last_visit_TIME = date('H:i:s',strtotime($Last_visit[$i]));
												
												$Last_visit2 = '<span  style="font-size: 0.7em;">'.$Last_visit_date.'</span><br><span class="smaller lighter">'.$Last_visit_TIME.'</span>';
											}
											$joined_dateX = date("d M Y",strtotime($joined_date[$i]));
											// echo "<br>".base_url().''.$Photograph[$i];
											if($Photograph[$i]==NULL || $Photograph[$i]=='' )
											{
												$Photograph[$i]='images/no_image.jpeg';
											}
											echo '<tr>
									  
												  <td>
													<div class="user-with-avatar">
													  <img alt="" src="'.base_url().''.$Photograph[$i].'"><span style="font-size: 0.7em;">'.$Customer_name[$i].'</span><br><span  class="smaller lighter">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.App_string_decrypt($Customer_phno[$i]).'</span>
													</div>
													
												  </td>
												  <td class="text-center">
												   
													  <a class="badge badge-danger-inverted"  style="font-size: 0.7em;">'.$Card_id[$i].'</a>
												   
												  </td>
												  <td>
													<span style="font-size: 0.7em;">'.$joined_dateX.'</span>
												  </td>
												  <td>
													'.$Last_visit2.'
												  </td>
												</tr>';
										}
									}
									
								}
								?>
								<?php
								 
								if($worry_customers != NULL)
								{ ?>
							   <tr>
								<td></td>
								<td></td>
								<td></td>
								<td align="left">
					
									<a target="_self" href="<?php echo base_url(); ?>index.php/Home/Show_more_members/?Flag=6"><button class="btn btn-primary" type="button" style="font-size: 0.6rem !important;margin-left:-15px;">Show More</button></a>
								
								</td>
								</tr>
							  <?php }
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
												$Photograph= base_url().''.'images/no_image.jpeg';
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

<html>  			  
			  
	<?php 
}
		$this->load->view('header/footer');
	?>
	
<script>
	/**********************************Order Type************************************/
		<?php   if($Transaction_Order_Types_graph_flag==1){?>
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
      
	
		
		/**********************************POS ONLINE GRAPH************************************/
		
		$("select#pos_select").val('6');
		$("select#pos_select2").val('6');
		var myObj22 = JSON.parse('<?php echo $POS_online_count; ?>');
		var smry_monthArr = new Array();
		var Trans_count_posArr = new Array();
		var Trans_count_onlineArr = new Array();
		var Trans_count_thirdpartyArr = new Array();
		var Total_purchase_posArr = new Array();
		var Total_purchase_onlineArr = new Array();
		var Total_purchase_thirdpartyArr = new Array();
		
	
		for (x in myObj22) {
		  smry_monthArr.push(myObj22[x].smry_month);
		  if(myObj22[x].Trans_count_posArr== null){myObj22[x].Trans_count_posArr=0;}
		  if(myObj22[x].Trans_count_onlineArr== null){myObj22[x].Trans_count_onlineArr=0;}
		  if(myObj22[x].Trans_count_thirdpartyArr== null){myObj22[x].Trans_count_thirdpartyArr=0;}
		  if(myObj22[x].Total_purchase_posArr== null){myObj22[x].Total_purchase_posArr=0;}
		  if(myObj22[x].Total_purchase_onlineArr== null){myObj22[x].Total_purchase_onlineArr=0;}
		  if(myObj22[x].Total_purchase_thirdpartyArr== null){myObj22[x].Total_purchase_thirdpartyArr=0;}
		  
		  Trans_count_posArr.push(myObj22[x].Trans_count_pos);
		  Trans_count_onlineArr.push(myObj22[x].Trans_count_online);
		  Trans_count_thirdpartyArr.push(myObj22[x].Trans_count_thirdparty);
		  Total_purchase_posArr.push(myObj22[x].Total_purchase_pos); 
		  Total_purchase_onlineArr.push(myObj22[x].Total_purchase_online);
		  Total_purchase_thirdpartyArr.push(myObj22[x].Total_purchase_thirdparty);
		} 
		get_pos_online_trans(6);
		function get_pos_online_trans(val)
		{
			
           if(val==9)
			{ 
				var ctx329 = document.getElementById("canvas1119").getContext("2d");
				$("#canvas1119").show();
				$("#canvas2119").hide();
				$("#canvas3119").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx329 = document.getElementById("canvas2119").getContext("2d");
				$("#canvas1119").hide();
				$("#canvas2119").show();
				$("#canvas3119").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx329 = document.getElementById("canvas3119").getContext("2d");
				$("#canvas1119").hide();
				$("#canvas2119").hide();
				$("#canvas3119").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config319 = {
					type: 'line',  
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),
						datasets: [{
							label: "POS",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Trans_count_posArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Online",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Trans_count_onlineArr.slice(start_rec, smry_monthArr.length),
						}, {
							label: "3rd Party",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Trans_count_thirdpartyArr.slice(start_rec, smry_monthArr.length),
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
									labelString: 'Count'
								}
							}]
						}
					}
				};
				window.myLine = new Chart(ctx329, config319);
		}
      
		get_pos_online_trans2(6);
		function get_pos_online_trans2(val)
		{
			
           if(val==9)
			{ 
				var ctx3299 = document.getElementById("canvas11199").getContext("2d");
				$("#canvas11199").show();
				$("#canvas21199").hide();
				$("#canvas31199").hide();
				
				var start_rec = (smry_monthArr.length-3);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==6)
			{ 
				 var ctx3299 = document.getElementById("canvas21199").getContext("2d");
				$("#canvas11199").hide();
				$("#canvas21199").show();
				$("#canvas31199").hide();
				
				var start_rec = (smry_monthArr.length-6);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			if(val==0)
			{ 
				var ctx3299 = document.getElementById("canvas31199").getContext("2d");
				$("#canvas11199").hide();
				$("#canvas21199").hide();
				$("#canvas31199").show();
				
				var start_rec = (smry_monthArr.length-12);
				if(start_rec < 0)
				{
					start_rec = 0;
				}
			}
			
			var config3199 = {
					type: 'line',  
					data: {
						labels: smry_monthArr.slice(start_rec, smry_monthArr.length),  
						datasets: [{
							label: "POS",
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: Total_purchase_posArr.slice(start_rec, smry_monthArr.length),
							fill: false,
						}, {
							label: "Online",
							fill: false,
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: Total_purchase_onlineArr.slice(start_rec, smry_monthArr.length),
						}, {
							label: "3rd Party",
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: Total_purchase_thirdpartyArr.slice(start_rec, smry_monthArr.length),
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
				window.myLine = new Chart(ctx3299, config3199);
		}
      
		<?php } ?>
/****************************Line chart start**********************************************************/
<?php   if($Member_enrollments_graph_flag==1){?>
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
	
<?php } ?>
	
/****************************Line chart finish**********************************************************/
 <?php   if(($Total_point_issued_Vs_total_points_redeemed_graph_flag==1) & ($No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag==1)){ ?>
		/****************Select index 6 Months onload***************************/
		$("select#points_stats").val('6');
		$("select#trans_stats").val('6');
		
		
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
	
	
		<?php } ?>
/****************************donutChart start**********************************************************/
<?php if($Active_Vs_inactive_member_graph_flag==1){?>
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
<?php } ?>
		// -------------------------SURVEY ANALYSIS------------------------------------------------------------
	
	//var myObj = ; //alert(a);


/****************************donutChart finish**********************************************************/



	
	/***************************ITEMS ISSUED VS USED****************************************************/
<?php   if($Total_quantity_issued_Vs_total_quantity_used_graph_flag==1){?>	

	$("select#item_issued_used").val('6');
	$("select#item_order").val('6');
	
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
 
<?php } ?>
	/*******************************************************************************/
		
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
	/***************************************************get_popular_category****************/
				
		get_menugroups_bargraph(6);
		$("select#Menu_group").val('6');
		
			
						
		function get_menugroups_bargraph(month)
		{
			// alert(month);
			var Company_id = '<?php echo $Company_id; ?>';
			for(var k=0;k<=20;k++)
				{
					$('#category_item_bar'+month+''+k).hide();
				}
			if(month==3)
			{
				$("#category_bar3").show();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
				
				 var ctx = document.getElementById("category_bar3").getContext("2d");
				
			}
			else if(month==6)
			{
				$("#category_bar3").hide();
				$("#category_bar6").show();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
				
				 var ctx = document.getElementById("category_bar6").getContext("2d");
			}
			else if(month==1)
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").show();
				$("#category_bar12").hide();
				
				
				 var ctx = document.getElementById("category_bar1").getContext("2d");
			}
			else 
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").show();
				
				
				 var ctx = document.getElementById("category_bar12").getContext("2d");
			}
				$.ajax({
					type:"POST",
					data:{ Company_id:Company_id, month:month},
					url: "<?php echo base_url()?>index.php/Home/get_menugroups_bargraph",
					success: function(data)
					{
						var Merchandize_category_nameArr = new Array();
						var Total_qtyArr = new Array();
						
						var popular_category = data.popular_category;
						var myObj2 = JSON.parse(popular_category);
						
					
						for (x in myObj2) {
						  Merchandize_category_nameArr.push(myObj2[x].Merchandize_category_name);
						  Total_qtyArr.push(myObj2[x].Total_qty);
						}  
						
						
						var barChartData = {
							labels: Merchandize_category_nameArr,
							datasets: [{
								label: 'Menu Groups',
								backgroundColor: window.chartColors.blue,
								borderColor: window.chartColors.blue,
								borderWidth: 1,
								data: Total_qtyArr
							}]

						};
						
						
						 // var ctx = document.getElementById("category_bar").getContext("2d");
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
									,
									onClick: call_item,
									
								}
							});
					}
			});
			 
			
			
		}
		
		function call_item(c,i)
		{
					e = i[0];
					var Menu_group_month = $('#Menu_group').val();
					
					var index_category = e._index;
					var x_value = this.data.labels[e._index];
					var y_value = this.data.datasets[0].data[e._index];
					var Company_id = '<?php echo $Company_id; ?>';
				for(var k=0;k<=20;k++)
				{
					$('#category_item_bar'+Menu_group_month+''+k).hide();
				}		
				$('#category_item_bar'+Menu_group_month+''+index_category).show();
				
				 var ctx21 = document.getElementById('category_item_bar'+Menu_group_month+''+index_category).getContext("2d");	
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
			
				
				$.ajax({
						type:"POST",
						data:{ Company_id:Company_id, Category:x_value,Menu_group_month:Menu_group_month},
						url: "<?php echo base_url()?>index.php/Home/Get_popular_category_items",
						success: function(data)
						{
								
							$('#Menu_group').hide();
							
							document.getElementById("back").style.display="";
							var Popular_category_items = data.Popular_category_items;
							/****************************************Get_popular_category_items****************/
							var myObj212 = JSON.parse(Popular_category_items);
							var Merchandize_category_nameArr21 = new Array();
							var Total_qtyArr21 = new Array();
							var Merchandize_item_nameArr = new Array();
							var count_qty = 0;
							for (x in myObj212) {
							  Merchandize_category_nameArr21.push(myObj212[x].Merchandize_category_name);
							  Total_qtyArr21.push(parseInt(myObj212[x].Total_qty));
							  Merchandize_item_nameArr.push(myObj212[x].Merchandize_item_name);
							  count_qty = parseInt(count_qty) + parseInt(myObj212[x].Total_qty);
							  
							}  
								
							 barChartData21 = {
								labels: Merchandize_item_nameArr,
								datasets: [{
									label: Merchandize_category_nameArr21[0]+'('+count_qty+')',
									backgroundColor: window.chartColors.blue,
									borderColor: window.chartColors.blue,
									borderWidth: 1,
									data: Total_qtyArr21
								}]

							};
							 // var ctx21 = document.getElementById("category_item_bar").getContext("2d");
								window.myBar21 = new Chart(ctx21, {
									type: 'bar',
									 data: barChartData21,
									options: {
										legend: {
											position: 'top',
										},
										title: {
											display: false,
										}
										 
								}
								});
									
						}				
						});
		
		
		}					

	   function Call_back()
	   {
		   var month = $('#Menu_group').val();
		   // alert('month '+month);
		     /*  $('html, body').animate({
					scrollTop: $("#myDiv").offset().top
				}, 2000);
				 */
			for(var k=0;k<=20;k++)
			{
				$('#category_item_bar'+month+''+k).hide();
			}
		   if(month==3)
			{
				$("#category_bar3").show();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
			}
			else if(month==6)
			{
				$("#category_bar3").hide();
				$("#category_bar6").show();
				$("#category_bar1").hide();
				$("#category_bar12").hide();
			}
			else if(month==1)
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").show();
				$("#category_bar12").hide();
			}
			else 
			{
				$("#category_bar3").hide();
				$("#category_bar6").hide();
				$("#category_bar1").hide();
				$("#category_bar12").show();
			}
			
		   document.getElementById('back').style.display='none';
		   $('#Menu_group').show();
	   }


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

	<style>
	.el-tablo .value
	{
		font-size: 1.43rem !important;
	}
	</style>
	

	
<!----------------------------------------Chat Box----------------------------------------------->


<?php
$session_data = $this->session->userdata('logged_in');	
$User_email_id = $session_data['username'];
$login_userName = $session_data['Full_name'];
$enroll = $session_data['enroll'];
$Company_id = $session_data['Company_id'];
$Logged_user_id = $session_data['userId'];
$Sub_seller_admin = $session_data['Sub_seller_admin'];
	
$ci_object = &get_instance();
$ci_object->load->model('Users_model');

	/*$get_enrollment = $ci_object->Igain_model->get_enrollment_details($enroll);
	$login_userName = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
	$User_email_id = $get_enrollment->User_email_id;*/
if($Logged_user_id == 6 AND $Sub_seller_admin == 0)
{
 ?>
<link href="<?php echo $this->config->item('base_url')?>assets/css/screen.css" rel="stylesheet" /> 
<link href="<?php echo $this->config->item('base_url')?>assets/css/chat.css" rel="stylesheet" />
<script src="<?php echo $this->config->item('base_url')?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->item('base_url')?>assets/bootstrap-dialog/js/bootstrap-dialog.js"></script>
<?php

	$chake_satus = $ci_object->Users_model->Chack_online_satus($Company_id,$User_email_id,$login_userName);

	if($chake_satus !=NULL)
	{
		foreach($chake_satus as $val)
		{
			$lastmsgsent = $val['Sent_date'];
		}	
		
		$Todays=date('Y-m-d H:i:s');
		
		$lastmsgsent1 = round((strtotime($Todays) - strtotime($lastmsgsent)) /60);
		
		if($lastmsgsent1 >= 5)
		{ 
		?>
		<script>
			var enroll = '<?php echo $enroll; ?>';
			var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				type: "POST",
				data: {enroll:enroll,Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Chat/End_chat_auto",
				success: function(data)
				{ }
			});
		</script>	
		<?php	
		}
	}
}	
?>
<script>
<?php 
if($Logged_user_id == 6 AND $Sub_seller_admin == 0)
{ ?> 	
var windowFocus 		= true;
var username;
var chatHeartbeatCount 	= 0;
var minChatHeartbeat 	= 3000;
var maxChatHeartbeat 	= 5000;
var chatHeartbeatTime 	= minChatHeartbeat;
var originalTitle;
var blinkOrder 			= 0;
var chatboxFocus 		= new Array();
var newMessages 		= new Array();
var newMessagesWin 		= new Array();
var chatBoxes 			= new Array();

jQuery.noConflict();
jQuery(document).ready(function()
{	
	originalTitle = document.title;
	var Logged_user_id ='<?php echo $Logged_user_id;?>'
	if(Logged_user_id == 6)
	{
		startChatSession();
	}
});
//*************************************************************************************************
	// restructureChatBoxes
//**************************************************************************************************
function restructureChatBoxes() 
{
	align = 0;
	for (x in chatBoxes) 
	{
		chatboxtitle = chatBoxes[x];

		if (jQuery("#chatbox_"+chatboxtitle).css('display') != 'none')
		{
			if (align == 0) {
				jQuery("#chatbox_"+chatboxtitle).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				jQuery("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}
//*****************************************************************************************************
	// createChatBox
//*****************************************************************************************************
function createChatBox(chatboxtitle,minimizeChatBox) 
{	
	if (jQuery("#chatbox_"+chatboxtitle).length > 0) 
	{		
		if (jQuery("#chatbox_"+chatboxtitle).css('display') == 'none') 
		{		
			jQuery("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}
	
	jQuery(" <div style='margin-left:50% !important;'/>" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<a href="javascript:void(0)"  style="color:white !important;" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')"><div class="chatboxhead" ><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"> <div id="p1"><i class="fa fa-sort-asc"></i> </a> <a class="close_chat" href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')"> x</a> </div></div> <div class="chatboxoptions2" style="display:none"> <div id="p2" style="display:none"> <a style="color:white !important;" class="close_chat" href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')"><i class="fa fa-sort-desc"></i></div></div> </a> <br clear="all"/> </div> <div id="chatboxcontent" class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
	
	.appendTo(jQuery( "body" ));
			   
	jQuery("#chatbox_"+chatboxtitle).css('bottom', '0px');
	jQuery("#chatbox_"+chatboxtitle).css('z-index', '11');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) 
	{
		if (jQuery("#chatbox_"+chatBoxes[x]).css('display') != 'none') 
		{
			chatBoxeslength++;
		}
	}
	if (chatBoxeslength == 0) 
	{
		jQuery("#chatbox_"+chatboxtitle).css('right', '20px');
	} 
	else 
	{
		width = (chatBoxeslength)*(225+7)+20;
		jQuery("#chatbox_"+chatboxtitle).css('right', width+'px');
	}	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) 
	{
		minimizedChatBoxes = new Array();

		if (jQuery.cookie('chatbox_minimized')) 
		{
			minimizedChatBoxes = jQuery.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) 
		{
			if (minimizedChatBoxes[j] == chatboxtitle) 
			{
				minimize = 1;
			}
		}
		if (minimize == 1) 
		{
			jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			jQuery('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}
	chatboxFocus[chatboxtitle] = false;

	jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function()
	{
		chatboxFocus[chatboxtitle] = false;
		jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function()
	{
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		jQuery('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	jQuery("#chatbox_"+chatboxtitle).click(function() {
		if (jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') 
		{
			jQuery("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	jQuery("#chatbox_"+chatboxtitle).show();
}

//*****************************************************************************************************
	// chatHeartbeat
//*****************************************************************************************************
function startChatSession()
{  
		var from_name= '<?php echo $login_userName; ?>';
		var from_email_id= '<?php echo $User_email_id; ?>';
		var from_id= '<?php echo $enroll; ?>';
		var Company_id= '<?php echo $Company_id; ?>';
		$.ajax({
		type: "POST",
		data: {Company_id:Company_id,from:from_name,from_email_id:from_email_id},
		url: "<?php echo base_url()?>index.php/Chat/getchatsall",
		success: function(data)
		{ 
			var aaa=data.split('*');
			var chatboxtitle = 'Online';
			if (jQuery("#chatbox_"+chatboxtitle).length <= 0) 
			{
				createChatBox(chatboxtitle,1);
			}			
			for(var i=0;i<aaa.length;i++)
			{
				var m=aaa[i];
				jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom"></span><span class="chatboxmessagecontent">'+m+'</span></div>');		
			}
			var t=window.setTimeout('chatHeartbeat();',chatHeartbeatTime);				
		}
	});					
}
function chatHeartbeat()
{
		var itemsfound = 0;	
		if (windowFocus == false) 
		{
			var blinkNumber = 0;
			var titleChanged = 0;
			for (x in newMessagesWin) 
			{
				if (newMessagesWin[x] == false) 
				{
					++blinkNumber;
					if (blinkNumber >= blinkOrder) 
					{
						document.title = x+' says...';
						titleChanged = 1;
						break;	
					}
				}
			}		
			if (titleChanged == 0) 
			{
				document.title = originalTitle;
				blinkOrder = 0;
			} 
			else 
			{
				++blinkOrder;
			}
		} 
		else
		{
			for (x in newMessagesWin) 
			{
				newMessagesWin[x] = false;
			}
		}
		for (x in newMessages) 
		{
			if (newMessages[x] == true) 
			{
				if (chatboxFocus[x] == false) 
				{
					jQuery('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
					var audio = new Audio("<?php echo base_url();?>assets/audio/1sound.mp3");
					audio.play();
				}
			}
		}		
		var from_name= '<?php echo $login_userName; ?>';
		var from_email_id= '<?php echo $User_email_id; ?>';
		var from_id= '<?php echo $enroll; ?>';
		var Company_id= '<?php echo $Company_id; ?>';
		$.ajax({
		type: "POST",
		data: {Company_id:Company_id,from_email_id:from_email_id,from:from_name},
		url: "<?php echo base_url()?>index.php/Chat/getchatsnew",
		success: function(data)
		{		 		 
			if(data!='no messeges')
			{				
			var aaa=data.split('*');		
			var chatboxtitle = 'Online';
			
			if (jQuery("#chatbox_"+chatboxtitle).length <= 0) 
				{
					createChatBox(chatboxtitle);
				}
				
			/************************************************/
			if (jQuery("#chatbox_"+chatboxtitle).css('display') == 'none') 
				{
					jQuery("#chatbox_"+chatboxtitle).css('display','block');
					restructureChatBoxes();
				}
					
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
					
					for(var i=0;i<aaa.length;i++)
					{
						var m=aaa[i];
			
						jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom"></span><span class="chatboxmessagecontent">'+m+'</span></div>');
			
					}			
				jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop(jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
		
				chatHeartbeatCount++;

				if (itemsfound > 0) 
				{
					chatHeartbeatTime = minChatHeartbeat;
					chatHeartbeatCount = 1;
				} 
				else if (chatHeartbeatCount >= 10)
				{
					chatHeartbeatTime *= 2;
					chatHeartbeatCount = 1;
					if (chatHeartbeatTime > maxChatHeartbeat) 
					{
						chatHeartbeatTime = maxChatHeartbeat;
					}
				}
			}
		}
	});	
	setTimeout('chatHeartbeat();',chatHeartbeatTime);		
}
//*****************************************************************************************************
	// toggleChatBoxGrowth
//*****************************************************************************************************
function toggleChatBoxGrowth(chatboxtitle) 
{
	if (jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') 
	{  		
		jQuery('.chatboxoptions').css('display','none');
		jQuery('.chatboxoptions2').css('display','block');
		
		document.getElementById('p2').setAttribute('style','display:block');
		document.getElementById('p1').setAttribute('style','display:none');
		
		var minimizedChatBoxes = new Array();
		
		if (jQuery.cookie('chatbox_minimized')) 
		{
			minimizedChatBoxes = jQuery.cookie('chatbox_minimized').split(/\|/);
		}
		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) 
			{
				newCookie += chatboxtitle+'|';
			}
		}
		newCookie = newCookie.slice(0, -1)
		jQuery.cookie('chatbox_minimized', newCookie);
		jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		jQuery('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop(jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	}
	else
	{
		jQuery('.chatboxoptions').css('display','block');
		jQuery('.chatboxoptions2').css('display','none');
		document.getElementById('p1').setAttribute('style','display:block');
		document.getElementById('p2').setAttribute('style','display:none');
		 
		var newCookie = chatboxtitle;

		if (jQuery.cookie('chatbox_minimized')) {
			newCookie += '|'+jQuery.cookie('chatbox_minimized');
		}
		jQuery.cookie('chatbox_minimized',newCookie);
		jQuery('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		jQuery('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}	
}
//*****************************************************************************************************
	// checkChatBoxInputKey
//*****************************************************************************************************
function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) 
{
	if(event.keyCode == 13 && event.shiftKey == 0)  
	{
		var message = jQuery(chatboxtextarea).val();
		var message = message.replace(/^\s+|\s+$/g,"");
		var User_email_id = '<?php echo $User_email_id; ?>';
		var from_name = '<?php echo $login_userName; ?>';
		var from_id = '<?php echo $enroll; ?>';
		var Company_id = '<?php echo $Company_id; ?>';
		jQuery(chatboxtextarea).val('');
		jQuery(chatboxtextarea).focus();
		jQuery(chatboxtextarea).css('height','30px');
		if (message != '') 
		{		
			$.ajax({
				type: "POST",
				data: {message:message,from_email_id:User_email_id,from_name:from_name,enroll_id:from_id,Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Chat/insert_chat",
				success: function(data)
				{			
					 message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");	
					jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+from_name+':   </span><span class="chatboxmessagecontent">'+message+'</span></div>');
					jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop(jQuery("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);	
				}
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}
	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) 
	{
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			jQuery(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} 
	else 
	{
		jQuery(chatboxtextarea).css('overflow','auto');
	}	 
}
//*****************************************************************************************************
	// closeChatBox
//*****************************************************************************************************
function closeChatBox(chatboxtitle) 
{
	var enroll = '<?php echo $enroll; ?>';
	var Company_id = '<?php echo $Company_id; ?>';
	var message = "Your Chat is End";
	//var message = message.replace(/^\s+|\s+$/g,"");
	var User_email_id = '<?php echo $User_email_id; ?>';
	var from_name = '<?php echo $login_userName; ?>';
	var from_id = '<?php echo $enroll; ?>';
	
	BootstrapDialog.confirm("Are you sure you want to end this Chat..? ", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Chat/End_chat/?enroll='+enroll+'&Company_id='+Company_id+'&message='+message+'&from_email_id='+User_email_id+'&from_name='+from_name+'&enroll_id='+from_id;
		if (result == true)
		{ 
		
		/*	$.ajax({
				type: "POST",
				data: {message:message,from_email_id:User_email_id,from_name:from_name,enroll_id:from_id,Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Chat/insert_chat",
				success: function(data)
				{ }
				});	*/
				
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
//****************************************************************************************************
	// startChatSession
	
//*****************************************************************************************************
jQuery.cookie = function(name, value, options) 
{
    if (typeof value != 'undefined') 
	{ // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) 
		{
            var date;
            if (typeof options.expires == 'number') 
			{
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } 
	else 
	{ // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
<?php } ?>
</script>