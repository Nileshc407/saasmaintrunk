	<div class="list-group">
		<div class="bhoechie-tab-content active" id="message2">
		<?php 
			
			?>
			<div class="panel panel-info">
				<div class="panel-heading text-center"><h4>Publisher Accounts</h4></div>
				<div class="table-responsive">
				<table class="table table-bordered table-hover">
				<thead>
				<tr>				 
				  <th scope="col">#</th>
				  <th scope="col">Publisher Name</th>
				  <th scope="col">Account Name</th>
				  <th scope="col">Identifier</th>
				  <th scope="col">Purchase</th>
				</tr>
				</thead>
			  <tbody>
			<?php 
				//print_r($Get_Beneficiary_members);
				$i=1;
				if($Get_Beneficiary_members) {
					
					foreach($Get_Beneficiary_members as $Rec2)
					{ 
						// echo"-----Register_beneficiary_id-----".$Rec2->Register_beneficiary_id;
						// echo"-----Beneficiary_company_name-----".$Rec2->Beneficiary_company_name;
						// echo"-----Beneficiary_name-----".$Rec2->Beneficiary_name;
					?>	
						
						<tr>
							
							<th scope="row"><?php echo $i; ?></th>
							<td><?php echo $Rec2->Beneficiary_company_name; ?></td>
							<td><?php echo $Rec2->Beneficiary_name; ?></td>
							<td><?php echo $Rec2->Beneficiary_membership_id; ?></td>
							<td>						  
								<button type="button" onclick="window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Beneficiary_Points_Transfer_Second?To_Beneficiary_company_id=<?php echo $Rec2->Register_beneficiary_id; ?>&Beneficiary_membership_id=<?php echo $Rec2->Beneficiary_membership_id; ?>'" class="btn btn-warning">Purchase</button>						  						 			  
							</td>
						</tr>
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