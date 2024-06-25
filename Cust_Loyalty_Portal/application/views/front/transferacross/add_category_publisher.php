	<div class="list-group">
		<div class="bhoechie-tab-content active" id="message2">
		<?php 
			
			?>
			<div class="panel panel-info">
				<div class="panel-heading text-center"><h4>Publisher Details</h4></div>
				<div class="table-responsive">
				<table class="table table-bordered table-hover">
				<thead>
				<tr>
				 <th scope="col">#</th>
				 
				  <th scope="col">Publisher Name</th>
				  <th scope="col">Add Membership</th>
				</tr>
				</thead>
			  <tbody>
			<?php 
				
				$i=1;
				if($Get_Beneficiary_Company) {
					
					foreach($Get_Beneficiary_Company as $rec)
					{ 
					
						if( $rec->Igain_company_id != 0 ){                                              
							  $Company_logo=$Company_details->Company_logo;                                              
						  } else {
							  $Company_logo=$rec->Company_logo;  
						  }
							// echo"-----Register_beneficiary_id-----".$rec->Register_beneficiary_id."--<br>";
							// echo"-----Beneficiary_link_company_id-----".print_r($Beneficiary_link_company_id)."--<br>";
							// echo"-----Beneficiary_company_name-----".$Rec2->Beneficiary_company_name;
							// echo"-----Beneficiary_name-----".$Rec2->Beneficiary_name;
					?>	
						
						<tr>
							<th scope="row" class="text-center"><?php echo $i; ?></th>
							<th scope="row" class="text-center">
								<img src="<?php echo $this->config->item('base_url2');?><?php echo $Company_logo;?>" class="img-responsive" style="width:150px;"><br>
								<span > <?php echo $rec->Beneficiary_company_name; ?></span>
							</th>
							
							<th>
							
							
							<?php
								if (in_array($rec->Register_beneficiary_id, $Beneficiary_link_company_id)) {
							?>
							
								
									<div class="panel panel-info">
										<div class="panel-heading text-center">
											<h4>You are already Enrolled & assign Membersh with this Publisher</h4>
										</div>
									</div>
								
								
							<?php } else { ?>
								
								<button type="button" class="btn btn-warning"  onclick="create_publisher_new_account(<?php echo $rec->Register_beneficiary_id; ?>,<?php echo $enroll; ?>,'<?php echo $rec->Beneficiary_company_name; ?>')" style="margin-left: -6px;"> Enroll New </button>
							
							<?php } ?>
							
							</th>
							<th>						  
								<button type="button" class="btn btn-warning"  onclick="link_publisher_account(<?php echo $rec->Register_beneficiary_id; ?>,<?php echo $rec->Igain_company_id; ?>)" >+ Loyalty Program</button>	
							</th>
						</tr>
						
						<div id="new_account_<?php echo $rec->Register_beneficiary_id; ?>" style="text-align:center;"></div>
						
						
					<?php
					$i++;
					}
				} 
				else 
				{
					?>
						<tr>
							<th colspan="3">No Records found</th>
						</tr>
						
					<?php
				}
			?>	
			</tbody>
			</table>
			</div>
			</div>
			<?php 
			
			?>			
		</div>
	</div>