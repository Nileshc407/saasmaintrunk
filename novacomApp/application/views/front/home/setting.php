<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Settings</title>	
        <?php
		  $this->load->view('front/header/header');
		if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }	
		if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	
      

        //$session_data = $this->session->userdata('cust_logged_in');
        // var_dump($session_data);
        if ($icon_src == "green") {
            $foot_icon = "white";
        } else {
            $foot_icon = $icon_src;
        }
		// var_dump($Enroll_details);
        ?>
    </head>
    <body>
        <div id="application_theme" class="section pricing-section" style="min-height: 400px;">
            <div class="container">
                <div class="section-header">          
                    <p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                    <p id="Extra_large_font" style="margin-left: -3%;">Settings</p>
                </div>
                <div class="row pricing-tables">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head" style="background:#ffffff;">
							<div class="pricing-details">
								<div class="row">
									<div class="col-xs-4 main-xs-6 text-left" >
											<span id="Medium_font">Allow Notification</span>
									</div>

									<div class="col-xs-4 main-xs-6 text-left" >
										<div class="onoffswitch">
											
											<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" <?php if($Enroll_details->Communication_flag ==1){ ?> checked <?php } ?> >
											
											<label class="onoffswitch-label" for="myonoffswitch">
												<span class="onoffswitch-inner" style="display:block;"></span>
												<span class="onoffswitch-switch"></span>
											</label>
										</div>
										
									</div>
									
								</div>
								<div id="Notification_Div"></div>
								
							</div>

							
                        </div>		
                    </div>
                </div>
            </div>
        </div>
         
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
                </div>
            </div>					  
        </div>
        <!-- Loader --> 
<?php $this->load->view('front/header/footer'); ?> 
        <style>
		.pricing-table .pricing-details ul li:hover {
			    /* background-color: #5e4103 !IMPORTANT; */
				color: #fab900 !IMPORTANT;
		}
		.pricing-table .pricing-details ul li:focus {
			/* background-color: #5e4103 !IMPORTANT; */
				color: #fab900 !IMPORTANT;
		}
            #Message
            {
                color:<?php echo $MColor; ?>;
            }
            .pricing-table .pricing-details ul li {
                padding: 10px;
                font-size: 12px;
                border-bottom: 1px solid #eee;
                color: #ffffff;
                font-weight: 600;
            }
            .pricing-table
            {
                padding: 0px 12px 0 12px;
                margin-bottom: 0 !important;
                background: #fff;
            }
            html{
<?php if (!empty($General_details[0]['Application_image_flag'] == 'yes')) { ?>
                    background-image: url("<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'application', 'value', $Company_id); ?>");
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;
<?php } else { ?>

                    background:<?php echo $General_details[0]['Theme_color']; ?>;
<?php } ?>;

            }


            .footer-xs {
                padding: 10px;
                color: #000;
                width: 33.33%;
                border-right: 1px solid #eee;
            }

            .main-xs-3
            {
                width: 26%;
                padding: 10px 10px 0 10px;
            }

            .main-xs-6
            {
                width: 48%;
                padding: 14px 0px 0px 34px;;
            }


            #button{

                padding: 1% 3%;
                margin: 8% 4%;

                font-size: 12px;
            }
			
			
			
			/* Switch Check Box */
			
			.onoffswitch {
				position: relative; width: 90px;
				-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
			}

			.onoffswitch-checkbox {
				display: none;
			}

			.onoffswitch-label {
				display: block; overflow: hidden; cursor: pointer;
				border: 2px solid #999999; border-radius: 20px;
			}

			.onoffswitch-inner {
				display: block; width: 200%; margin-left: -100%;
				-moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
				-o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
			}

			.onoffswitch-inner:before, .onoffswitch-inner:after {
				display: block; float: left; width: 50%; height: 24px; padding: 0; line-height: 25px;
				font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
				-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
			}

			.onoffswitch-inner:before {
				content: "YES";
				padding-left: 10px;
				background-color: <?php echo $Footer_font_details[0]['Footer_background_color']; ?>; color: <?php echo $Footer_font_details[0]['Footer_font_color']; ?>;
			}

			.onoffswitch-inner:after {
				content: "NO";
				padding-right: 10px;
				background-color: #EEEEEE; color: #999999;
				text-align: right;
			}

			.onoffswitch-switch {
				display: block; width: 18px; margin: 6px;
				background: #FFFFFF;
				border: 2px solid #999999; border-radius: 20px;
				position: absolute; top: 0; bottom: 0; right: 56px;
				-moz-transition: all 0.3s ease-in 0s; -webkit-transition: all 0.3s ease-in 0s;
				-o-transition: all 0.3s ease-in 0s; transition: all 0.3s ease-in 0s; 
			}

			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
				margin-left: 0;
			}

			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
				right: 0px; 
			}

			/* Switch Check Box */


		</style>
		<script>
		 $(document).ready(function(){
			 
			 var Comm_flag=0;
			$('input[type="checkbox"]').click(function(){
				if($(this).prop("checked") == true){
					$.ajax({
							type: "POST",
							data: {Comm_flag:1},
							url:"<?php echo base_url(); ?>index.php/Cust_home/allow_communication",
							success: function(data)
							{					
								// console.log(data);
								$("#Notification_Div").html("Your have activated to send/receive communication");
								
								// myApp.alert('Your hav Activate Send/Receive Communication ', 'Information');
								
							}
						});

				} else if($(this).prop("checked") == false){
						$.ajax({
									type: "POST",
									data: {Comm_flag:0},
									url:"<?php echo base_url(); ?>index.php/Cust_home/allow_communication",
									success: function(data)
									{				
										$("#Notification_Div").html("Your have de-activated to send/receive communication");
										// console.log(data);
										// myApp.alert('Your hav Activate Send/Receive Communication ', 'Information');
										
									}
							});

				}
				
				setTimeout(function() {
					$("#Notification_Div").html("");
				}, 3000);
				
			});
		});
		
		$("#myonoffswitch").on('change', 'input', function() 
		{ 
			console.log('change');
			/* var Comm_flag=0;
			if ($$(this)[0].checked === true) 
			{
				$$('.allowDisable').addClass('disabled'); 
			
							$$.ajax({
										type: "POST",
										data: { EnrollId: $$('#Enrollement_id').val(), Companyid:$$('#Company_id').val(),Comm_flag:1},
										url: Base_url+"index.php/Cust_home/allow_communication",
										success: function(data)
										{						
											myApp.alert('Your hav Activate Send/Receive Communication ', 'Information');
											
										}
									});


				
			} 
			else 
			{ 
							$$('.allowDisable').removeClass('disabled'); 
							$$.ajax({
										type: "POST",
										data: { EnrollId: $$('#Enrollement_id').val(), Companyid:$$('#Company_id').val(),Comm_flag:0},
										url: Base_url+"index.php/Cust_home/allow_communication",
										success: function(data)
										{						
											myApp.alert('Your have De-activated Send/Receive Communication ', 'Information');
											
										}
									});
				
			} */	
		})
		</script>
		
			
