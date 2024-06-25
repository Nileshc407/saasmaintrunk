</div>
	
<?php 
	
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
$Company_details = $ci_object->Igain_model->get_company_details($Company_id);
$Company_details->Partner_company_flag;
$Parent_company=$Company_details->Parent_company;
$Company_partner_cmp = $this->Igain_model->Fetch_Company_Details($Parent_company);	
foreach($Company_partner_cmp as $partner)
{
	$partner_Company_name=$partner['Company_name'];
	$partner_Company_Website=$partner['Website'];
}
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
?>
<div class="main-footer">
	<div class="row">		
			<div class="col-sm-6 col-xs-12 footer-nav1" align="center" >
				<strong>Copyright &copy; 2015-2020 NOVACOM SYSTEM<?php //echo $partner_Company_name; ?></a>.</strong> All rights reserved.
			</div>
			<div class="col-sm-6 col-xs-12 footer-nav2" align="center" >
				<strong>Powered By NOVACOM SYSTEM<?php //echo $partner_Company_name; ?></a></strong>
			</div>		
				
	</div>
</div>


	
	</div>
	
</body>
</html>

<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/js/bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/plugins/fastclick/fastclick.min.js"></script>	
<script src="<?php echo base_url()?>dist/js/app.min.js"></script>


<style>
<?php //if($smartphone_flag == 1) { ?>

@font-face{
    font-family:"cocogoose-regular";
    src:url("<?php echo base_url()?>/assets/fonts/Cocogoose/Cocogoose-Pro-Regular-TTF.ttf") format("woff"),
    url("<?php echo base_url()?>/assets/fonts/Cocogoose/Cocogoose-Pro-Regular-TTF.ttf") format("opentype"),
    url("<?php echo base_url()?>/assets/fonts/Cocogoose/Cocogoose-Pro-Regular-TTF.ttf") format("truetype");
}

@font-face{
    font-family:"nexa-rust-sans-black";
	
	src:url("<?php echo base_url()?>/assets/fonts/Fontfabric - Nexa Rust Sans Black.otf") format("woff"),
    url("<?php echo base_url()?>/assets/fonts/Fontfabric - Nexa Rust Sans Black.otf") format("opentype"),
    url("<?php echo base_url()?>/assets/fonts/Fontfabric - Nexa Rust Sans Black.otf") format("truetype");
}

@media only screen and (min-width: 320px) {
  .footer-nav1{
		padding-left: 28px;
	}
	.footer-nav2{
		padding-right: 21px;
	}
}
@media only screen and (min-width: 375px) {
   .footer-nav1{
		padding-left: 28px;
	}
	.footer-nav2{
		padding-right: 67px;
	}
}
@media only screen and (min-width: 425px) {
   .footer-nav1{
		padding-left: 28px;
	}
	.footer-nav2{
		padding-right: 67px;
	}
}
@media only screen and (min-width: 768px) {
  .footer-nav1{
		padding-left: 28px;
	}
	.footer-nav2{
		padding-right: 67px;
	}
}
@media only screen and (min-width: 1024px) {
  .footer-nav1{
		padding-left: 28px;
	}
	.footer-nav2{
		padding-right: 67px;
	}
}
@media only screen and (min-width: 1440px) {
   .footer-nav1{
		padding-left: 28px;
	}
	.footer-nav2{
		padding-right: 67px;
	}
}

@media only screen and (min-width: 368px){
	.footer-nav1{
		padding-left: 28px;
	}
	.footer-nav2{
		padding-right: 0px;
	}
}
<?php //} ?>
</style>