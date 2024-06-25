<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box" style="min-height: 955px !important;">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   <?php  
			   if($_REQUEST['Flag']==1)
			   {
				   echo "Today's Birthday";
				   
					$Total_Records=$Todays_Birthdays_Count;
					$CardId = $Birthdays_Member_Card_idD;
					$Member_name = $Birthdays_Member_NameD;
					$Phone_no = $Birthdays_Member_Phone_noD;
					$Photograph = $PhotographD;
					$Date = $Date_of_birthD;
					$joined_date = $joined_dateD;
				   $Column_name="Birth Date";
				} 
		
				if($_REQUEST['Flag']==2)
				{
				   echo "Today's Anniversary";
				   
				   $Total_Records=$Todays_Anniversaries_Count;
					$CardId = $Anniversaries_Member_Card_idD;
					$Member_name = $Anniversaries_Member_NameD;
					$Phone_no = $Anniversaries_Member_Phone_noD;
					$Photograph = $PhotographWD;
					$joined_date = $joined_dateWD;
				   $Column_name="Anniversary Date";
				} 
				
			   if($_REQUEST['Flag']==3)
				{
				   echo "Birthdays This Month";
				   
					$Total_Records=$This_Month_Birthdays_Count;
					$CardId = $Birthdays_Member_Card_idM;
					$Member_name = $Birthdays_Member_NameM;
					$Phone_no = $Birthdays_Member_Phone_noM;
					$Photograph = $PhotographM;
					$Date = $Date_of_birthM;
					$joined_date = $joined_dateM;
					$Column_name="Birth Date";
				} 
			   if($_REQUEST['Flag']==4)
				{
				   echo "Anniversary's This Month";
				   
					$Total_Records=$This_Month_Anniversaries_Count;
					$CardId = $Anniversaries_Member_Card_idM;
					$Member_name = $Anniversaries_Member_NameM;
					$Phone_no = $Anniversaries_Member_Phone_noM;
					$Photograph = $PhotographWM;
					$Date = $Wedding_annversary_dateM;
					$joined_date = $joined_dateWM;
					$Column_name="Anniversary Date";
				} 
			   if($_REQUEST['Flag']==5)
				{
				   echo "TOP KEY MEMBERS";
				   $Total_Records=count($happy_customers['Card_id']);
					$CardId = $happy_customers['Card_id'];
					$Member_name = $happy_customers['Customer_name'];
					$Phone_no = $happy_customers['Customer_phno'];
					$Photograph = $happy_customers['Photograph'];
					$Last_visit = $happy_customers['Last_visit'];
					$joined_date = $happy_customers['joined_date'];
					
					$Column_name="Last Visit";
				  
				} 
			   
			   if($_REQUEST['Flag']==6)
				{
				   echo "TOP WORRY MEMBERS";
				   $Total_Records=count($worry_customers['Card_id']);
					$CardId = $worry_customers['Card_id'];
					$Member_name = $worry_customers['Customer_name'];
					$Phone_no = $worry_customers['Customer_phno'];
					$Photograph = $worry_customers['Photograph'];
					$Last_visit = $worry_customers['Last_visit'];
					$joined_date = $worry_customers['joined_date'];
				   $Column_name="Last Visit";
				} 
			   
			   ?> 
			  </h6>
			  <div class="element-box">
				<div class="row">
					<div class="col-sm-12">
					  <div class="element-wrapper">
						
					   
							  <div class="element-box-tp">
						<?php 
							
							if($Total_Records != 0)
							{ ?>	  
						  <div class="table-responsive">
						   <table class="table table-padded">
							  <thead>
							 
								<tr>
								 
								  <th>
									Member Name
								  </th>
								  <th class="text-center">
									MembershipID
								  </th>
								  <th class="text-center">
									Joined Date
								  </th>
								  <th class="text-center">
									<?php echo $Column_name; ?>
								  </th>
								  
								  <th class="text-center">
									Phone No.
								  </th>
								  
								<!-- 
								  <th class="text-center">
									
								  </th>
								 -->
								 
								
								</tr>
							  </thead>
							  <tbody>
							 <?php 
							
							
									 for($i=0;$i<$Total_Records;$i++)
									{
											if($Photograph[$i]==NULL || $Photograph[$i]=='')
											{
												$Photograph2= base_url().''.'images/no_image.jpeg';
											}
											else
											{
												$Photograph2= base_url().''.$Photograph[$i];
											}
											if($_REQUEST['Flag']==5 || $_REQUEST['Flag']==6 )
											{
												$Last_visit_date = date('d M Y',strtotime($Last_visit[$i]));
												$Last_visit_TIME = date('H:i:s',strtotime($Last_visit[$i]));
												$Date[$i] = $Last_visit_date.'<br><span class="smaller lighter">'.$Last_visit_TIME.'</span>';
											}
											$joined_dateX = date("d M Y",strtotime($joined_date[$i]));
											
											if($_REQUEST['Flag']==5){$color='badge-success-inverted';}
											else if($_REQUEST['Flag']==6){$color='badge-danger-inverted';}
											else{$color='badge-primary-inverted';}
											
										echo ' <tr>
								  
											  <td>
												<div class="user-with-avatar">
												  <img alt="" src="'.$Photograph2.'"><span  class="smaller lighter">'.$Member_name[$i].'</span>
												</div>
											  </td>
											  <td class="text-center">
											   
												  <a class="badge '.$color.'" >'.$CardId[$i].'</a>
											   
											  </td>
											  <td class="text-center">
											   
												 '.$joined_dateX.'
											   
											  </td>
											  <td class="text-center">
											   
												 '.$Date[$i].'
											   
											  </td>
											  <td class="text-center smaller lighter">
												'.App_string_decrypt($Phone_no[$i]).'
											  </td>
												
											 
											</tr>';	
									}
								/*<td>
												<div align="center">
													<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Action</button>
												  </div>
											  </td>*/			
								?>
							   
							 
							  
							  </tbody>
							</table>
						  </div>
						 <?php  }
								else
								{
									echo "<font color='red'>No Records Found !!!</font>";
								}			
								?>
						</div>
					  
						 
						</div>
						</div>
					  
					
					  
					  
					  </div>
			  </div>
			</div>
		
			
			
			
			
			
		  </div>
		</div>
	</div>
</div>			

<?php $this->load->view('header/footer'); ?>
