<?php $this->load->view('front/header/header'); ?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/notification-bg.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url();?>index.php/Cust_home/front_home"></a>
					</div>
					<h2>Help
				</div>
			</div>
		</div>
		<div class="custom-body transparent">
			<nav class="menu-wrapper">
			<ul>
				<?php
					$page=0;
					if($_REQUEST){
						$page= $_REQUEST['page'];
					} else {
						$page=0;
					}
					// echo"<br>---page------".$page; 
				?>
                <!--<li><a href="JavaScript:void(0)" id="startTourBtn" <?php if($page==1){ ?> class="active" <?php } ?> >Take a tour</a>
					<ul class="submenu"></ul>
                </li>-->
                <li><a href="https://ehp.online/artcaffe/index.php/Term_condition" <?php if($page==2){ ?> class="active" <?php } ?>>Terms and Conditions</a> 
                  <ul class="submenu"> </ul>
                </li>
                <li><a href="https://ehp.online/artcaffe/index.php/Privacy_policy" <?php if($page==3){ ?> class="active" <?php } ?>>Privacy Policy</a>
                  <ul class="submenu"></ul>
                </li>
            </ul>
        </nav>
		</div>
<?php $this->load->view('front/header/footer');  ?>
		
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