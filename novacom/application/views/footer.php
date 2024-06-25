 <footer class="footer" id="footer_fos">
               <div class="container">
                  <!-- top footer statrs -->
                  <div class="row top-footer">
                     <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                        <!--<a class="app-name" href="<?php echo base_url()?>index.php" style="font-size:20px;">Kukito</a><br /> <span>Order Delivery  </span>-->
						<img class="" src="<?php echo base_url() ?>images/KukitoLogotrans.png" style="width:180px; height:150px;">						
                     </div>
                     <div class="col-xs-12 col-sm-4 about color-gray">
                        <ul class="list-unstyled">
							<li><a href="<?php echo base_url()?>index.php/Login/food_menu">Food Menu</a></li>
                           <li><a href="#loyalty">Loyalty Program</a></li>
							<li><a href="<?php echo base_url()?>index.php/Login/track_order">Track Order </a> </li>
							<li>
								<a href="#" data-toggle="modal" data-target="#myModal1"> Sign In </a>
							</li> 
                        </ul>
                     </div>
						
						<div class="col-xs-12 col-md-4 font-white">
						<h6>Our <span>Address</span> </h6>
							<ul class="list-unstyled">
							<li><i class="fa fa-map-marker" aria-hidden="true"></i><span style="color:#bfbfbf;font-size:12px;"> &nbsp;<?php echo $Company_address; ?></span></li>
							
							<li><i class="fa fa-phone" aria-hidden="true"></i><span style="color:#bfbfbf;font-size:12px;"> &nbsp;<?php echo $Company_primary_phone_no; ?></span></li>

							<li><i class="fa fa-envelope" aria-hidden="true"></i> <span style="color:#bfbfbf;font-size:12px;"> &nbsp;<?php echo $Company_primary_email_id; ?></span></li>
							
							<?php if($Website != "") { ?>
							<div class="pull-left">
								<abbr title="Company Website">
									<i class="fa fa-globe"></i>
								</abbr>
							</div>
							&nbsp;&nbsp;
							<a href="<?php echo $Website; ?>" target="_blank" >Visit Company Website</a> <br><br>
							<?php } ?>
							</ul>
						</div>
                  </div>
                  <!-- top footer ends -->
  
                  <!-- bottom footer ends -->
               </div>
            </footer>
<style>
.app-name {
    color: #fab900 !important;
}
</style>