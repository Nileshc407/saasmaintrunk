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
			   TRIGGER NOTIFICATION
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
				} ?>
				
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('TriggerC/trigger_notification',$attributes); ?>
					<div class="col-sm-8">
					<div class="form-group">
					<label for=""> <span class="required_info">* </span> Company Name </label>
					<select class="form-control" name="Company_id"  id="Company_id" required="required">

					 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
					</select>
					</div>		  		
								 
				  
				  <div class="form-group">
					<label for=""> <span class="required_info">*</span> Trigger Name </label>								
					<input class="form-control"  name="Triggername" id="Triggername"  type="text" placeholder="Enter Trigger Name"  required="required" data-error="Please enter trigger name" >
					<div class="help-block form-text with-errors form-control-feedback" id="triggerName"></div>
				  </div> 
						
				  <div class="form-group" id="grid-container">
					 <label for=""> <span class="required_info">*</span> Criteria </label><hr>
						<div class="grid-item">
						<input type="radio" name="Criteria" id="inlineRadio1" value="1" onclick="show_hide_div(this.value);"  required="required">Member Defined
						</div>	
						<div class="grid-item">
						<input type="radio" name="Criteria" id="inlineRadio3" value="3" onclick="show_hide_div(this.value);"  required="required"> Auction Defined
						</div>	

						<div class="grid-item">
						<input type="radio" name="Criteria" id="inlineRadio2" value="2" onclick="show_hide_div(this.value);" required="required"> Loyalty Rule Defined
						</div>	
						<div class="grid-item">
						<input type="radio" name="Criteria" id="inlineRadio4" value="4" onclick="show_hide_div(this.value);"  required="required"> Game Defined
						</div>	
						<div class="help-block form-text with-errors form-control-feedback"></div>
				   </div> 
				   
					<div class="form-group" id="Tier_block">
					<label for=""> <span class="required_info">* </span> Tier </label>
					<select class="form-control" name="Tierid" id="Tierid" data-error="Please select tier" onchange="next_tier_info(this.value);">

					<option value="">Select Tier </option>
						
						<?php
							foreach($tier_results as $row)
							{
								if($row->Active_flag == 1)
								{
									echo '<option value='.$row->Tier_id.'>'.$row->Tier_name.'</option>';
								}
							}
						?>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					
					<div class="form-group" id="Loyalty_block">
					<label for=""> <span class="required_info">* </span> Loyalty Rule </label>
					<select class="form-control" name="lp_rules[]"  onchange="loyalty_program_info(this.value);" id="Loyaltyid" data-error="Please select loyalty rule">

					<option value="" selected>Select Loyalty Rules</option>
					<?php

						foreach($loyalty_results as $lp)
						{
							if($todays >= $lp->From_date && $todays <= $lp->Till_date)
							{
								echo "<option value='".$lp->Loyalty_name."'>".$lp->Loyalty_name."</option>";
							}
						}
					?>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					
					<div class="form-group" id="Auction_block">
					<label for=""> <span class="required_info">* </span> Auction </label>
					<select class="form-control" name="Auctionid"  id="Auctionid"  onchange="Auction_info(this.value);" data-error="Please select auction">

					<option value="">Select Auction </option>
						
						<?php

							foreach($auction_results as $row2)
							{
								if( ($todays >= $row2->From_date) && ($todays <= $row2->To_date) )
								{
									echo '<option value='.$row2->Auction_id.'>'.$row2->Auction_name.'</option>';
								}
							}
						?>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					
						<div class="form-group" id="Game_block">
					<label for=""> <span class="required_info">* </span> Game </label>
					<select class="form-control" name="Gameid"  id="Gameid" data-error="Please select game">

					<option value="">Select Competition Game </option>
						
						<?php
						$todays = date("Y-m-d");
						
							foreach($game_results as $row3)
							{
								if( ($todays >= $row3->Competition_start_date) && ($todays <= $row3->Competition_end_date) )
								{
									echo '<option value='.$row3->Company_game_id.'>'.$row3->Game_name.'</option>';
								}
							}
						?>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					
					<div class="form-group" id="Threshold_block">
					<label for=""> <span class="required_info">*</span> Threshold Value </label>								
					<input class="form-control"  name="Thresholdvalue" id="Thresholdvalue" placeholder="Enter Threshold Value"  type="text" onchange="check_threshold_value_with_criteria(this.value);" data-error="Please enter threshold value" onkeyup="this.value=this.value.replace(/\D/g,'')">
					<div class="help-block form-text with-errors form-control-feedback" id="threshold_value"></div>
					</div> 
 
					<div id="lp_info">
			
					</div>
					
					<div id="tier_info">
							
					</div>	
					<div id="auction_info">
							
					</div>
			
				  <div class="form-buttons-w">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>		  
			  </div>		
			</div>
			</div>
			<!-------------------- START - Data Table -------------------->
		
		<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   Trigger Notifications
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Trigger Name</th>
							<th class="text-center">Trigger Criteria</th>
							<th class="text-center">Trigger Defination </th>
											
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Trigger Name</th>
							<th class="text-center">Trigger Criteria</th>
							<th class="text-center">Trigger Defination </th>
							</tr>
						</tfoot>		

						<tbody>
					<?php
						$todays = date("Y-m-d");
						
						if($trigger_results != NULL)
						{
							foreach($trigger_results as $row)
							{
	
								if($row->Trigger_notification_type == 1 )
								{
									$Tier_criteria = "Customer Defined";
									
									if($row->Tier_id > 0)
									{
										foreach($tier_results as $rowt)
										{
											if($row->Tier_id == $rowt->Tier_id)
											{
												$DefName = $rowt->Tier_name;
											}
										}
									}
								}
								
								if($row->Trigger_notification_type == 2 )
								{
									$Tier_criteria = "Loyalty Rule Defined";
									
									$DefName = $row->Loyalty_rule;
								}
								
								if($row->Trigger_notification_type == 3 )
								{
									$Tier_criteria = "Auction Defined";
									
									if($row->Auction_id > 0)
									{
										foreach($auction_results as $rowa)
										{
											if($row->Auction_id == $rowa->Auction_id)
											{
												$DefName = $rowa->Auction_name;
											}
										}
									}
								}
								
								if($row->Trigger_notification_type == 4 )
								{
									$Tier_criteria = "Game Defined";
									
									if($row->Company_game_id > 0)
									{
										foreach($game_results as $rowg)
										{
											if( $row->Company_game_id == $rowg->Company_game_id )
											{
												$DefName = $rowg->Game_name;
											}
										}
									}
								}
							?>	

								<tr>
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/TriggerC/edit_trigger_notification/?Trigger_id=<?php echo $row->Trigger_notification_id;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										|
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Trigger_notification_id;?>','<?php echo $row->Trigger_notification_name; ?>','','TriggerC/delete_trigger/?Trigger_id');" data-target="#deleteModal" data-toggle="modal"  title="Delete">
											<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									<td><?php echo $row->Trigger_notification_name; ?></td>
									<td><?php echo  $Tier_criteria; ?> </td>
									<td><?php echo $DefName ;?></td>
					
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
$(document).ready(function() 
{
	$("#Tier_block").hide();
	$("#Threshold_block").hide();
	$("#Loyalty_block").hide();
	$("#Auction_block").hide();
	$("#Game_block").hide();
	
});
	
$('#Register').click(function()
{
	if( $('#Triggername').val() != "" )
	{
		var radioVAL = $("input[name=Criteria]:checked").val();
		
		if(radioVAL == 1 && $('#Tierid').val() != "" && ($('#Thresholdvalue').val() == "" || $('#Thresholdvalue').val() == 0))
		{
			return false;
		}
		
		if(radioVAL == 1 && $('#Tierid').val() != "" && $('#Thresholdvalue').val() != "" )
		{
			show_loader();	
		}
		
		if(radioVAL == 2 && $('#Loyaltyid').val() != "" && $('#Thresholdvalue').val() != "" )
		{
			show_loader();	
		}
		
		if(radioVAL == 3 && $('#Auctionid').val() != "" )
		{
			show_loader();	
		}
		
		if(radioVAL == 4 && $('#Gameid').val() != "" )
		{
			show_loader();	
		}

	}
});
	
	$('#Triggername').blur(function()
	{

		var CompanyId = '<?php echo $Company_id; ?>';
		var triggern = $("#Triggername").val();
		
		if($("#Triggername").val() == "")
		{

			var msg1 = 'Please Enter Trigger Name!!';
			$('#triggerName').show();
			$('#triggerName').html(msg1);
		}
			
		$.ajax({
				type:"POST",
				data:{'triggername':triggern,'CompanyId':CompanyId},
				url: "<?php echo base_url()?>index.php/TriggerC/trigger_name_validation",
				success : function(data)
				{ 
					if(data.length == 13)
					{
						$("#Triggername").val("");
						//has_error(".has-feedback","#glyphicon",".help-block","Trigger Notification Is Already Exist.!!");
						
						$("#Triggername").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#triggerName').show();
							$('#triggerName').html(msg1);
					}
					else
						{
							$('#triggerName').html("");
							$("#Triggername").removeClass("has-error");	
						}
				}
			});
	});
	
	
function show_hide_div(dicID)
{
	//alert(dicID);
	
	//Tier_block	Auction_block	Game_block	Threshold_block	Loyalty_block 
	//Tierid Auctionid Gameid Operatorid Thresholdvalue Loyaltyid
	
	if(dicID == 1) //**** customer defined ***/
	{
		$("#Tier_block").show();
		$("#tier_info").show();
		$("#Threshold_block").show();
		$("#Loyalty_block").hide();
		$("#Auction_block").hide();
		$("#Game_block").hide();
		$("#lp_info").hide();
		$("#auction_info").hide();
		
		//$("#Threshold_label").html("<span class='required_info'>*</span>Threshold Current Balance");
		
		$("#merchant_type").removeAttr("required");
		$("#Merchant_type_div").hide();
		
		$("#Tierid").attr("required","required");
		//$("#Operatorid").attr("required","required");
		$("#Thresholdvalue").attr("required","required");

		$("#Loyaltyid").removeAttr("required");
		$("#Auctionid").removeAttr("required");
		$("#Gameid").removeAttr("required");
	}
	
	if(dicID == 2) //**** Loyalty defined ***/
	{
	
		$("#Tier_block").hide();
		$("#Threshold_block").hide();
		$("#Loyalty_block").show();
		$("#Auction_block").hide();
		$("#Game_block").hide();
		$("#tier_info").hide();
		$("#auction_info").hide();
		$("#lp_info").show();
		$("#Loyaltyid").attr("required","required");
		
		$("#merchant_type").removeAttr("required");
		$("#Merchant_type_div").hide();
		
		//$("#Operatorid").removeAttr("required");
		$("#Thresholdvalue").removeAttr("required");
		//$("#Thresholdvalue2").removeAttr("required");
		$("#Tierid").removeAttr("required");
		$("#Auctionid").removeAttr("required");
		$("#Gameid").removeAttr("required");
	}
	
	if(dicID == 3) //**** Auction defined ***/
	{
		$("#Auctionid").attr("required","required");
		$("#Tierid").removeAttr("required");
		//$("#Operatorid").removeAttr("required");
		$("#Thresholdvalue").removeAttr("required");
		//$("#Thresholdvalue2").removeAttr("required");
		$("#Gameid").removeAttr("required");
		$("#Loyaltyid").removeAttr("required");
		$("#lp_info").hide();
		$("#merchant_type").removeAttr("required");
		$("#Merchant_type_div").hide();
		$("#tier_info").hide();
		$("#Tier_block").hide();
		$("#auction_info").show();
		$("#Threshold_block").hide();
		$("#Loyalty_block").hide();
		$("#Auction_block").show();
		$("#Game_block").hide();
		
	}
	
	if(dicID == 4) //**** Game defined ***/
	{
		$("#Gameid").attr("required","required");
		$("#Tierid").removeAttr("required");
		//$("#Operatorid").removeAttr("required");
		$("#Thresholdvalue").removeAttr("required");
		//$("#Thresholdvalue2").removeAttr("required");
		$("#Auctionid").removeAttr("required");
		$("#Loyaltyid").removeAttr("required");
		$("#merchant_type").removeAttr("required");
		$("#Merchant_type_div").hide();
		$("#Tier_block").hide();
		$("#Threshold_block").hide();
		$("#Loyalty_block").hide();
		$("#auction_info").hide();
		$("#Auction_block").hide();
		$("#Game_block").show();
		$("#lp_info").hide();
		$("#tier_info").hide();
	}
	
	if(dicID == 5) //**** Hobbies defined ***/
	{
		$("#merchant_type").attr("required","required");
		$("#Gameid").removeAttr("required");
		$("#Tierid").removeAttr("required");
		//$("#Operatorid").removeAttr("required");
		$("#Thresholdvalue").removeAttr("required");
		//$("#Thresholdvalue2").removeAttr("required");
		$("#Auctionid").removeAttr("required");
		$("#Loyaltyid").removeAttr("required");
		
		$("#Tier_block").hide();
		$("#Threshold_block").hide();
		$("#Loyalty_block").hide();
		$("#Auction_block").hide();
		$("#Game_block").hide();
		$("#Merchant_type_div").show();
	}
}

	function Auction_info()
	{
		var Company_id = '<?php echo $Company_id; ?>';
		
		var Auctionid = $('#Auctionid').val();
		
		if(Auctionid == "")
		{
			$('#auction_info').html("");
			return false;
		}
		
		$.ajax({
			type: "POST",
			data: { Auctionid:Auctionid, Company_id:Company_id},
			
			url: "<?php echo base_url()?>index.php/TriggerC/get_auction_info",
			success: function(data)
			{	
				$('#auction_info').html(data);
			}
		}); 
		
	}
	
	function loyalty_program_info()
	{
		var Company_id = '<?php echo $Company_id; ?>';
		
		var Lpid = new Array();
		 Lpid = $('#Loyaltyid').val();
		
		if(Lpid == "")
		{
			$('#lp_info').html("");
			return false;
		}
		
		$.ajax({
			type: "POST",
			data: { lp_id:Lpid, Company_id:Company_id},
			
			url: "<?php echo base_url()?>index.php/Transactionc/get_loyalty_program_details",
			success: function(data)
			{	
				$('#lp_info').html(data);
			}
		}); 
		
	}
	

	function next_tier_info(TierID)
	{
		var Company_id = '<?php echo $Company_id; ?>';
		
		if(TierID == "")
		{
			$('#tier_info').html("");
			return false;
		}
		
		$.ajax({
			type: "POST",
			data: { Tier_id:TierID, Company_id:Company_id},
			
			url: "<?php echo base_url()?>index.php/TriggerC/get_next_tier",
			success: function(data)
			{	
				var Thresholdvalue = $('#Thresholdvalue').val();
				check_threshold_value_with_criteria(Thresholdvalue);
				$('#tier_info').html(data);
				
			}
		}); 
		
	}
	function check_threshold_value_with_criteria(Threshold_val)
	{
		if(Threshold_val == 0 || Threshold_val == ""){
			$('#Thresholdvalue').val('');
			$("#Thresholdvalue").addClass("form-control has-error");
			$('#threshold_value').show();
			$('#threshold_value').html("Please enter valid threshold value");
			return false;
		}
		
		var Company_id = '<?php echo $Company_id; ?>';
		var TierID = $('#Tierid').val();
		// alert(TierID);
		$.ajax({
			type: "POST",
			data: { Tier_id:TierID, Company_id:Company_id, Threshold_val:Threshold_val},
			
			url: "<?php echo base_url()?>index.php/TriggerC/check_threshold_value_with_criteria",
			success: function(data)
			{	
				if(data != 1)
				{
					$('#Thresholdvalue').val('');
					$("#Thresholdvalue").addClass("form-control has-error");
					$('#threshold_value').show();
					$('#threshold_value').html(data);
				}
				else{
					$("#Thresholdvalue").removeClass("has-error");
					$('#threshold_value').hide();
					$('#threshold_value').html("");
				}
				
			}
		}); 
	}
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