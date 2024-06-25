<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Help</title>	
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
        ?>
    </head>
    <body> 
	<?php $this->load->view('front/header/menu'); ?>
        <div id="application_theme" class="section pricing-section" style="min-height: 400px;">
            <div class="container">
                <!--<div class="section-header">          
                    <p><a href="<?php //echo base_url(); ?>index.php/Cust_home/profile" style="color:#ffffff;"><img src="<?php //echo base_url(); ?>assets/icons/<?php //echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                    <p id="Extra_large_font" style="margin-left: -3%;">Help</p>
                </div> -->
                <div class="row pricing-tables">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:31px;">
                        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" style="background:#ffffff;">
                           														 
                            <!--<button type="button" id="button" align="center" onclick="window.location.href = '<?php echo base_url(); ?>index.php/Cust_home/profile'">Privacy Policy</button>
							
                            <button type="button" id="button" align="center" style="width: 148px;" onclick="window.location.href = 'https://kukito.co.ke/terms-and-conditions-kukito-website.pdf'">Terms and Conditions</button>
							-->
							
													
							<div class="pricing-details">
							<ul>
								<li style="color:#000">
									<a href="JavaScript:void(0)" id="startTourBtn">Take a tour</a>
								</li>
								<li style="color:#000">
									<a href="https://docs.google.com/viewerng/viewer?url=https://kukito.co.ke/terms-and-conditions-kukito-website.pdf">Terms and Conditions</a>
								</li>
								<li style="color:#000">
									<a href="https://docs.google.com/viewerng/viewer?url=https://kukito.co.ke/privacy-policy-kukito-website.pdf">Privacy Policy</a>
								</li>
								
															
							</ul>
							</div>
							
							
							
                            <br>				
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
                padding: 12px 12px 0 12px;
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
                padding: 10px 10px 0 10px;
            }


            #button{

                padding: 1% 3%;
                margin: 8% 4%;

                font-size: 12px;
            }
        </style>
		
		
<script>

/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */

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
        window.location.href = "<?php echo base_url(); ?>index.php/Shopping?page=help";
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
        window.location.href = "<?php echo base_url(); ?>index.php/Shopping?page=help";
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
        window.location.href = "<?php echo base_url(); ?>index.php/Shopping?page=help";
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
	// window.location.href = '<?php echo base_url(); ?>index.php/Cust_home/tutorial_session_insert';	
}
</script>	