		<?php $this->load->view('header/header');?>
		<?php echo form_open_multipart('Cust_home/merchant_list'); 

		$Login_Enroll=$Enroll_details->Enrollement_id; 
		
		?>
        <section class="content-header">
          <h1>
            Company Merchants
            <small></small>
          </h1>
          
        </section>

        <!-- Main content -->
        <section class="content">
		<div class="row">
			<?php 
			foreach($All_Merchants_details as $Merchant)
			{
				$Enroll = $Merchant['Enrollement_id'];
				$Photograph = $Merchant['Photograph'];
				if($Photograph=="")
				{
					$Photograph='images/no_image.jpeg';
				}
			?>
			
					<div class="col-md-4">
						<div class="box box-widget widget-user-2">
							<div class="widget-user-header bg-green">
								<div class="widget-user-image">
									<img class="img-circle" src="<?php echo $this->config->item('base_url2')?><?php echo $Photograph; ?>" alt="User Avatar">
								</div>
								<h3 class="widget-user-username"><?php echo $Merchant['First_name'].' '.$Merchant['Last_name']; ?></h3>
								<h5 class="widget-user-desc"><?php echo $Merchant['Current_address']; ?></h5>
							</div>
							
							<div class="box-footer no-padding">
								<ul class="nav nav-stacked">
									<li><a href="javascript:void(0);"><strong>City</strong> <span class="pull-right"><?php echo $Merchant['City_name']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>District</strong> <span class="pull-right"><?php echo $Merchant['District']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>State</strong> <span class="pull-right"><?php echo $Merchant['State_name']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Phone Number</strong> <span class="pull-right"><?php echo $Merchant['Phone_no']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Since From</strong> <span class="pull-right"><?php echo date('M-Y',strtotime($Merchant['joined_date'])); ?></span></a></li>
								</ul>
							</div>
						</div>
					</div>
			
				<?php /*<div class="col-md-3">
				  <!-- DIRECT CHAT DANGER -->
				  <div class="box box-danger direct-chat direct-chat-danger">
					<div class="box-header with-border">
					  <h3 class="box-title"><b><?php echo $Merchant['First_name'].' '.$Merchant['Last_name']; ?></b></h3>
					 
					</div><!-- /.box-header -->
					<div class="box-body">
					  <!-- Conversations are loaded here -->
					  <div class="direct-chat-messages">
						<!-- Message. Default to the left -->
						<div class="direct-chat-msg">
						 
						  
						   <div class="direct-chat-info clearfix">
							<span class="direct-chat-name pull-right"><?php echo $Merchant['Current_address']; ?></span>
							<span class="direct-chat-timestamp pull-left">Address</span>
						  </div><!-- /.direct-chat-info -->
						  
						  <img class="direct-chat-img" src="<?php echo base_url()?>../<?php echo $Photograph; ?>" alt="message user image"><!-- /.direct-chat-img -->
						 
						</div><!-- /.direct-chat-msg -->

						<!-- Message to the right -->
						<div class="direct-chat-msg right">
						  <div class="direct-chat-info clearfix">
							<span class="direct-chat-name pull-right"><?php echo $Merchant['City']; ?></span>
							<span class="direct-chat-timestamp pull-left">City</span>
						  </div><!-- /.direct-chat-info -->
						  <div class="direct-chat-info clearfix">
							<span class="direct-chat-name pull-right"><?php echo $Merchant['District']; ?></span>
							<span class="direct-chat-timestamp pull-left">District</span>
						  </div><!-- /.direct-chat-info -->
						  <div class="direct-chat-info clearfix">
							<span class="direct-chat-name pull-right"><?php echo $Merchant['State']; ?></span>
							<span class="direct-chat-timestamp pull-left">State</span>
						  </div><!-- /.direct-chat-info -->
						 
						 <div class="direct-chat-info clearfix">
							<span class="direct-chat-name pull-right"><?php echo date('M-Y',strtotime($Merchant['joined_date'])); ?></span>
							<span class="direct-chat-timestamp pull-left">Since From</span>
						  </div><!-- /.direct-chat-info -->
						  
						  <div class="direct-chat-info clearfix">
							<span class="direct-chat-name pull-right"><a href="http://<?php echo $Merchant['Website']; ?>" target="_blank"> <?php echo $Merchant['Website']; ?> </a></span>
							<span class="direct-chat-timestamp pull-left">Website</span>
						  </div><!-- /.direct-chat-info -->
						  <div class="input-group">
						  <span class="input-group-btn">
							<button type="button" class="btn btn-danger btn-flat"><i class="fa fa-phone"></i> : <?php echo $Merchant['Phone_no']; ?></button>
						  </span>
						</div>
						</div><!-- /.direct-chat-msg -->
					  </div><!--/.direct-chat-messages-->

					  <!-- Contacts are loaded here -->
					  
					</div><!-- /.box-body -->
				   
				  </div><!--/.direct-chat -->
				</div> */?>
				
			<?php } ?>
		</div>
	<?php 
							  
/* $Current_balance=$Enroll_details->Current_balance;
$Blocked_points=$Enroll_details->Blocked_points;
$Total_balance=  $Current_balance-$Blocked_points; */

?>
    </section>
	 <?php echo form_close(); ?>
	 <?php $this->load->view('header/loader');?> 
     <?php $this->load->view('header/footer');?>
	
	
<style>
.col-md-4{margin-left:15%;}
</style>