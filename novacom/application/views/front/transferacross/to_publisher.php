<div class="list-group">
	<?php 
		if($Get_Beneficiary_members!=NULL)	
		{
			foreach($Get_Beneficiary_members as $Rec2)
			{								 
				?>							
					<a href="javascript:void(0);" onclick="get_to_publisher_account(<?php echo $Rec2->Beneficiary_company_id; ?>,<?php echo $Rec2->Beneficiary_membership_id; ?>);" class="list-group-item text-center" >
						<div class="row">
							<div class="col-lg-6">
							
									<img src="<?php echo $this->config->item('base_url2');?><?php echo $Rec2->Company_logo; ?>" width="60" > <br> 
									<span><?php echo $Rec2->Beneficiary_company_name ?></span><br>
									
							</div><!-- col-lg-6 -->
							<div class="col-lg-6">
								<span >Name &nbsp;&nbsp;&nbsp;&nbsp;:</span> <span><?php echo $Rec2->Beneficiary_name; ?></span><br>
								<span>Identifier&nbsp;:</span>  <span><?php echo $Rec2->Beneficiary_membership_id; ?></span> 
							</div><!-- col-lg-6 -->
						</div><!-- /.row -->
					</a>
				<?php 								
			}
		} 
	?>					
</div>