<?php 
$session_data = $this->session->userdata('cust_logged_in');

$data['Company_id'] = $session_data['Company_id'];
$data['enroll'] = $session_data['enroll'];
$smartphone_flag = $session_data['smartphone_flag'];

	// echo"----smartphone_flag---".$smartphone_flag."---<br>";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Update eVoucher Status : iGainSpark</title>
	
	<!----------------------Safari form validation----------------------------------------------->
	<script src="<?php  echo $this->config->item('base_url2')?>assets/js/js-webshim/minified/polyfiller.js"></script>
    <script> 
        webshim.activeLang('en');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>
 <!--------------------------------------------------------------------------------------->	
	<link rel="shortcut icon" href="<?php echo $this->config->item('base_url2')?>images/logo_igain.ico" type="image/x-icon">
    <link href="<?php echo $this->config->item('base_url2')?>assets/Customer_assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>dist/css/AdminLTE.min.css" rel="stylesheet" />
	<link href="<?php echo base_url()?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css">	
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/jquery.min.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/js/bootstrap.js"></script>
	
	<?php echo form_open_multipart('Cust_home/Update_eVoucher_Status'); ?>

	<section class="content">
	<div class="container">
		
		<div class="col-md-3">
		</div>
		<div class="col-md-6 col-xs-12 ">
			<div class="panel panel-info col-md-12 col-xs-12 ">
				<div class="panel-heading">
					<h3 class="panel-title">
						<span class="glyphicon glyphicon-th"></span>
						Update e-Voucher Status 
					</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<?php if($smartphone_flag ==1) { ?>
						<div class="col-xs-12  col-md-12"><strong><a href="<?php echo base_url(); ?>"> <i class="fa fa-angle-double-left"></i> Back</a></strong></div>
						<?php } ?>
						
						<div style="margin-top:22px;" class="col-xs-12 col-md-12">						
							<div class="form-group">
								<label for="inputName" class="control-label">Item Name : <?php echo $item_name; ?></label>							
							</div>
							<div class="form-group">
								<label for="inputName" class="control-label" >Voucher No. : <?php echo $evoucherNo; ?></label>
							</div>
							<div class="form-group">
								<label for="inputName" class="control-label" >Enter PIN</label>
								<div class="input-group">
								  <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
								  <input class="form-control" type="password" id="customer_pin" name="customer_pin" placeholder="Enter PIN" required>
								</div>
							</div>
							<br>
							<div class="col-xs-12 col-md-12" align="center">
								<button class="btn icon-btn-save btn-success " id="Save" type="submit">
								<span class="btn-save-label">Submit </button>
								<input type="hidden" name="Offer_link" value="<?php echo $Offer_link; ?>" />
							</div >
							
						</div>
						
					</div>
				</div>
				<div class="panel-footer">
					<?php ?>
					<div class="row">
						<div class="col-xs-12  col-md-12"><strong>Copyright &copy; 2015-2020 <a href="http://www.miraclecartes.com" target="_blank">Miracle Smart Card Pvt. Ltd</a>.</strong> All rights reserved.</div>
						<div class="col-md-2">
						</div>
						<?php /* ?>
						<div class="col-xs-12  col-md-5"><strong style="float:right">Powered By <a target="_blank" href="<?php echo $partner_Company_Website; ?>" title="<?php echo $partner_Company_name; ?>"><?php echo $partner_Company_name; ?></a></strong></div>
						<?php  */?>
					</div>
					
					
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
		
		</div>
		
	</div>
</section>		
		
<?php echo form_close(); ?>

<style type="text/css">
#showHide {
  width: 15px;
  height: 15px;
  float: left;
}
#showHideLabel {
  float: left;
  padding-left: 5px;
}
input[type=checkbox]
{
  -webkit-appearance:checkbox;
}
</style>

<script>


 
</script>	
<style>

.glyphicon-ok{
	color: green;
}
.glyphicon-remove
{
	color: red;
}
</style>


	
	<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header" style="background-color:#428bca;color:#fff">
			<button type="button" onclick="window.close()"  class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Application Information</h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->session->flashdata('eVoucher_Status'); ?></p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" onclick="window.close()" data-dismiss="modal">Close</button>
		  </div>
		</div>

	</div>
	</div>
	
	
	<?php
	if(@$this->session->flashdata('eVoucher_Status'))
	{
	?>
		<script>
		
			/* var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('eVoucher_Status'); ?>';
			runjs(Title,msg); */
			$('#myModal').modal('show');  
		</script>
		
		
	<?php
	}
	?>
	
<style>
@media only screen and (min-width: 320px) {
	.list-group-item{
		font-size: 10px;
	}
}

@media only screen and (min-width: 375px) {
   .list-group-item{
		font-size: 10px;
	}
}
@media only screen and (min-width: 425px) {
  .list-group-item{
		font-size: 14px;
	}
}
@media only screen and (min-width: 768px) {
  .list-group-item{
		font-size: 14px;
	}
}
@media only screen and (min-width: 1024px) {
   .list-group-item{
		font-size: 14px;
	}
}
@media only screen and (min-width: 1440px) {
  .list-group-item{
		font-size: 14px;
	}
}

@media only screen and (min-width: 368px){
	.list-group-item{
		font-size: 14px;
	}
}

</style>