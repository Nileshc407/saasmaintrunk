<section class="content">
        <div class="row">			
			<div class="col-md-12">
			  <div class="col-md-4">
						<div class="box box-widget widget-user-3">													
							<div class="box-footer no-padding">
								<ul class="nav nav-stacked">
									<?php 
									if($Publishers_Category!=NULL)	
									{
										foreach($Publishers_Category as $Category)
										{  
											$CategoryID=$Category->Code_decode_id; 
											if($CategoryID==47)
											{
												$icon_name='air.png';
											}
											else if($CategoryID==48)
											{
												$icon_name='hospitality.png';
											}
											else if($CategoryID==49)
											{
												$icon_name='retail.png';
											}
											else if($CategoryID==50)
											{
												$icon_name='telecom.png';
											}
											else if($CategoryID==51)
											{
												$icon_name='car.png';
											}
											else
											{
											  $icon_name='';
											}
											?>
									<li> 
										<a href="javascript:void(0);" onclick="get_category_publisher('<?php echo $CategoryID; ?>');" ><img src="<?php echo base_url(); ?>images/<?php echo $icon_name;?>" id="icon1"> &nbsp;&nbsp; <span id="Medium_font"><?php echo $Category->Code_decode; ?></span>
											<img src="<?php echo base_url(); ?>images/right.png" id="icon" align="right"> </a>
									</li>
									<?php }
									} 
									?>									
								</ul>							  
							</div>
						</div>
				 
				 
				

			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
			
         </div><!-- /.row -->
		
        </section><!-- /.content -->