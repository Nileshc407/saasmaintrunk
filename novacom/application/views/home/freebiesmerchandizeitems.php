		<?php $this->load->view('header/header');?>
		<?php echo form_open_multipart('Cust_home/merchant_list'); 

				$Login_Enroll=$Enroll_details->Enrollement_id; 
		
		?>
        <section class="content-header">
          <h1>
           Freebies Items
            <small></small>
          </h1>
          
        </section>

        <!-- Main content -->
        <section class="content">
		<div class="row">
			<?php 
			foreach($Company_Details as $cmp);
			{
				$Evoucher_expiry_period=$cmp['Evoucher_expiry_period'];
			}
			
			
			
			foreach($freebies_merchandize_items as $items)
			{
				$Enroll = $items['Enrollement_id'];
				$Photograph = $items['Photograph'];
				if($Photograph=="")
				{
					$Photograph='images/no_image.jpeg';
				}
			?>
			
					<div class="col-md-4">
						<div class="box box-widget widget-user-2">
							<div class="widget-user-header bg-green">
								<div class="widget-user-image">
									<a href="<?php echo $items['Thumbnail_image1']; ?>" target="_blank"><img src="<?php echo $items['Thumbnail_image1']; ?>" alt="<?php echo $items['Merchandize_item_name']; ?>" class="img-responsive center-block"></a>
								</div>								
							</div>							
							<div class="box-footer no-padding">
								<ul class="nav nav-stacked">
									<li><a href="javascript:void(0);"><strong>Item Name</strong> <span class="pull-right"><?php echo $items['Merchandize_item_name']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Description</strong> <span class="pull-right"><?php echo $items['Merchandise_item_description']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Item Code</strong> <span class="pull-right"><?php echo $items['Item_code']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Voucher No.</strong> <span class="pull-right"><?php echo $items['Voucher_no']; ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Voucher Status</strong> <span class="pull-right"><?php echo $items['Voucher_status']; ?></span></a></li>
									<?php /*?>	
									<li><a href="javascript:void(0);"><strong>Valid From</strong> <span class="pull-right"><?php echo date('d-M-Y',strtotime($items['Trans_date'])); ?></span></a></li>
									<li><a href="javascript:void(0);"><strong>Valid Till</strong> <span class="pull-right"><?php 							
									$Trans_date=date('d-M-Y',strtotime($items['Trans_date']));
									$date = "Mar 03, 2011";
									$date = strtotime($Trans_date);
									$date1 = strtotime("+".$Evoucher_expiry_period." day", $date);
									echo date('d-M-Y', $date1);
									?></span></a></li><?php */?>						
								</ul>
							</div>
						</div>
					</div>
				
			<?php } ?>
		</div>
	<?php 
?>
    </section>
	 <?php echo form_close(); ?>
	 <?php $this->load->view('header/loader');?> 
     <?php $this->load->view('header/footer');?>
	
	
	