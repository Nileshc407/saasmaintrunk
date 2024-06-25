<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Membership</title>	
	 
  </head>
  <body>
         <?php $this->load->view('header/header'); ?> 
		 <section class="content-header">
          <h1>
			Membership
          </h1>
         
        </section>
		
	<section class="content">
        <div class="row">
			
			<div class="login-box">
			  <div class="login-box-body">
						<div class="box box-widget widget-user-2">													
							<div class="box-footer no-padding">
								<ul class="nav nav-stacked">
									
									<li> 
										<a href="<?php echo base_url();?>index.php/Beneficiary/Add_Beneficiary_Category"><strong>Add Loyalty Programs</strong> <span class="pull-right"> <img src="<?php echo base_url(); ?>images/right.png" id="icon" align="right"> </span></a>
									</li>
									<li>
										 <a href="<?php echo base_url();?>index.php/Beneficiary/Added_Beneficiary_accounts"><strong> My Loyalty Programs</strong> <span class="pull-right"> <span class="pull-right"> <img src="<?php echo base_url(); ?>images/right.png" id="icon" align="right"> </span></a>
									</li>
									
								</ul>							  
							</div>
						</div>
				 
				 
				

			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
			
         </div><!-- /.row -->
		
        </section><!-- /.content -->
		
		
		
	
<?php $this->load->view('header/footer'); ?> 
<style>	

</style>