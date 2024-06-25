<?php 
$this->load->view('header/header');
$todays = date("Y-m-d");
 ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   EDIT TIER MASTER
			  </h6>
			  <div class="element-box">
			  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php $this->session->unset_userdata('success_code'); $this->session->unset_userdata('data_code');
				} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php $this->session->unset_userdata('error_code');
						$this->session->unset_userdata('data_code');
				}

				foreach($tier_details as $tier)
				{
					$Tier_id = $tier->Tier_id;
					$Tier_name = $tier->Tier_name;
					$Tier_level_id = $tier->Tier_level_id;
					$Tier_criteria = $tier->Tier_criteria;
					$Criteria_value = $tier->Criteria_value;
					$Operator_id = $tier->Operator_id;
					$Excecution_time = $tier->Excecution_time;
					$Redeemtion_limit = $tier->Redeemtion_limit;
				}
				?>
				
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('TierC/update_tier',$attributes); ?>
					<div class="row">
					<div class="col-sm-6">	
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Company Name </label>
						<select class="form-control" name="Company_id"  id="Company_id" required="required">

						 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>
						</div>		  		
									 
					  
						<div class="form-group">
						<label for=""> <span class="required_info">*</span> Tier Name </label>								
						<input class="form-control"  name="Tiername" id="Tiername"  type="text" placeholder="Enter Tier Name"  required="required" data-error="Please enter tier name"  value="<?php echo $Tier_name; ?>" >
						<div class="help-block form-text with-errors form-control-feedback" id="TierName"></div>
						</div> 
					  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Tier Level </label>
						<select class="form-control" name="Tierlevel"  id="Tierlevel" readonly required="required" onchange="ckeck_level();">
							<option value="<?php echo $Tier_level_id; ?> ">Level <?php echo $Tier_level_id; ?> </option>

						</select>
						</div>	
						
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Tier Criteria </label>
						<select class="form-control" name="Tiercriteria" required="required" data-error="Please select tier criteria">
							<option value="">Select Criteria</option>
							<option value="1" <?php if($Tier_criteria == 1){ echo "selected"; } ?> >Cumulative Spend</option>
							<option value="2" <?php if($Tier_criteria == 2){ echo "selected"; } ?> >Cumulative Number of Transactions</option>
							<option value="3" <?php if($Tier_criteria == 3){ echo "selected"; } ?> >Cumulative Points Accumlated</option>
							<option value="4" <?php if($Tier_criteria == 4){ echo "selected"; } ?> >Tenor - No. of Days</option>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					</div>
					<div class="col-sm-6">	
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Operator </label>
						<select class="form-control" name="Operatorid" required="required" data-error="Please select operator">
							<option value=""> Select Operator </option>
							<option value="1" <?php if($Operator_id == 1){ echo "selected"; } ?>> = </option>
							<option value="2" <?php if($Operator_id == 2){ echo "selected"; } ?>> > </option>
							<option value="3" <?php if($Operator_id == 3){ echo "selected"; } ?>> >= </option>
							<option value="4" <?php if($Operator_id == 4){ echo "selected"; } ?>> < </option>
							<option value="5" <?php if($Operator_id == 5){ echo "selected"; } ?>> <= </option>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<label for=""><span class="required_info">* </span>Criteria Value</label>
							<input type="text" class="form-control" name="Criteriavalue" id="Criteriavalue" data-error="Please enter criteria value" placeholder="Enter Criteria Value" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Criteria_value;?>">
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<label for=""><span class="required_info">* </span><?php if($Company_details->Enable_company_meal_flag==1){echo 'Meal Top Up';}elseif($Company_details->Daily_points_consumption_flag==1){echo 'Daily Points Consumption Limit';}else{echo '1st Time Redemption Limit';} ?></label>
							<input type="text" class="form-control" name="Redeemtion_limit" id="Redeemtion_limit"  <?php if($Company_details->Enable_company_meal_flag==1){echo 'placeholder="Enter Meal Top Up"';} elseif($Company_details->Daily_points_consumption_flag==1){echo 'placeholder="Enter Daily Points Consumption Limit"';}else{echo 'placeholder="Enter 1st Time Redemption Limit"';} ?>  required="required" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $Redeemtion_limit; ?>">
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group" id="grid-container">
						 <label for=""> <span class="required_info">*</span> Criteria Period </label><hr>
							<div class="grid-item">
							<input type="radio" name="ExcecutionTime" id="inlineRadio1" value="Monthly"  required="required" <?php if($Excecution_time == "Monthly"){ echo "checked";} ?>> Monthly
							</div>	
							<div class="grid-item">
							<input type="radio" name="ExcecutionTime" id="inlineRadio3" value="Quaterly"  required="required" <?php if($Excecution_time == "Quaterly"){ echo "checked";} ?> > Quarterly
							</div>	

							<div class="grid-item">
							<input type="radio" name="ExcecutionTime" id="inlineRadio2" value="Bi-Annualy" required="required" <?php if($Excecution_time == "Bi-Annualy"){ echo "checked";} ?>> Bi-annually
							</div>	
							<div class="grid-item">
							<input type="radio" name="ExcecutionTime" id="inlineRadio4" value="Yearly" required="required" <?php if($Excecution_time == "Yearly"){ echo "checked";} ?>> Yearly
							</div>	
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div> 
					</div> 
				   </div> 
				   
				  <div class="form-buttons-w" align="center">
					<input type="hidden" name="Tier_id" value="<?php echo $Tier_id; ?> ">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>		  
		
			</div>
			</div>
			<!-------------------- START - Data Table -------------------->
		
		<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   Tiers
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Tier Name</th>
							<th class="text-center">Level</th>
							<th class="text-center">Tier Criteria</th>
							<th class="text-center">Value</th>
							<th class="text-center">Criteria Period </th>
							<th class="text-center"><?php if($Company_details->Enable_company_meal_flag==1){echo 'Meal Top Up';}elseif($Company_details->Daily_points_consumption_flag==1){echo 'Consumption Limit';}else{echo '1st Time Redemption Limit';} ?> </th>
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Tier Name</th>
							<th class="text-center">Level</th>
							<th class="text-center">Tier Criteria</th>
							<th class="text-center">Value</th>
							<th class="text-center">Criteria Period </th>
							<th class="text-center"><?php if($Company_details->Enable_company_meal_flag==1){echo 'Meal Top Up';}elseif($Company_details->Daily_points_consumption_flag==1){echo 'Consumption Limit';}else{echo '1st Time Redemption Limit';} ?> </th>
							</tr>
						</tfoot>		

						<tbody>
						<?php
						$todays = date("Y-m-d");
						
						if($tier_results != NULL)
						{
							foreach($tier_results as $row)
							{
								
								
								if($row->Tier_criteria == 1 )
								{
									$Tier_criteria = "Cumulative Spend";
								}
								
								if($row->Tier_criteria == 2 )
								{
									$Tier_criteria = "Cumulative Number of Transactions";
								}
								
								if($row->Tier_criteria == 3 )
								{
									$Tier_criteria = "Cumulative Points Accumlated";
								}
								
								if($row->Tier_criteria == 4 )
								{
									$Tier_criteria = "Tenor - No. of Days";
								}
	

							?>
								<tr >
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/TierC/edit_tier/?Tier_id=<?php echo $row->Tier_id;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Tier_id;?>','<?php echo $row->Tier_name; ?>','Please note that there Merchandise Items linked to one or more Tiers. Well, if The Merchandise Item is linked to just one Tier then that Merchandise Item will be Inactive ( when the Tier is deleted) . But if a Merchandise Item is linked to multiple Tiers then only Merchandise Item linked to that Tier which is deleted will not be available in future. Loyalty Rule & Members linked to this Tier will be Inactive.','TierC/delete_tier/?Tier_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
											<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									<td><?php echo $row->Tier_name; ?></td>
									<td><?php echo $row->Tier_level_id;?></td>
									<td><?php echo  $Tier_criteria; ?> </td>	
									<td><?php echo $row->Criteria_value;?></td>
									<td><?php echo $row->Excecution_time;?></td>
										<td><?php echo $row->Redeemtion_limit;?></td>
									</tr>
								<?php
								}
							}
							?>					
					</tbody> 
					</table>
				  </div>
				</div>
			  </div>
			  
	
<!--------------------  END - Data Table  -------------------->

		  </div>
		</div>
		
			
	</div>
</div>			

<?php $this->load->view('header/footer'); ?>

<script>
	
$('#Register').click(function()
{
	if(!document.querySelector("#Register").classList.contains('disabled')){
		show_loader();
	}
	
/* 	if( $('#Tiername').val() != "" && $('#Tierlevel').val() != "" && $('#Tiercriteria').val() != "" && $('#Operatorid').val() != "" && $('#Criteriavalue').val() != "" && $('#Redeemtion_limit').val() != "")
	{
		var radioVAL = $("input[name=ExcecutionTime]:checked").val();

		if(radioVAL != "" || radioVAL != "undefined")
		{
			show_loader();
			
		}

	} */
});
	
	
	$('#Tiername').blur(function()
	{

		var CompanyId = '<?php echo $Company_id; ?>';
		var tiername = $("#Tiername").val();
		
		if($("#Tiername").val() == "")
		{

			var msg1 = 'Please Enter Tier Name!!';
			$('#TierName').show();
			$('#TierName').html(msg1);
		}
		
		$.ajax({
				type:"POST",
				data:{'tiername':tiername,'CompanyId':CompanyId},
				url: "<?php echo base_url()?>index.php/TierC/tier_name_validation",
				success : function(data)
				{ 
					if(data.length == 13)
					{
						$("#Tiername").val("");
						
						$("#Tiername").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#TierName').show();
							$('#TierName').html(msg1);
					}
					else
					{
						$('#TierName').html("");
						$("#Tiername").removeClass("has-error");	
					}
				}
			});
	});

</script>
<style>
#grid-container {
  display: grid;
  grid-template-columns: auto auto;
}
.grid-item {
  padding:0px 2px;
  text-align: left;
}

</style>