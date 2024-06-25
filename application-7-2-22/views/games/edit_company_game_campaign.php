<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT GAME CAMPAIGN
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
				<?php 	} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php 	} ?>
				
				<?php $attributes = array('id' => 'formValidate');
					echo form_open_multipart('Gamec/update_company_game_campaign',$attributes); 
					
					foreach($result5 as $row5)
					{
						$Campaign_id = $row5->Campaign_id;
						$Campaign_name = $row5->Campaign_name;
						$Start_date = date("m/d/Y",strtotime($row5->Start_date));
						$End_date = date("m/d/Y",strtotime($row5->End_date));	
					}
					
					foreach($result6 as $row4)
					{
						$GameID = $row4->Game_id;
						$Company_game_id = $row4->Company_game_id;
					}

				?>

				<div class="row">
					<div class="col-sm-6">	  		
					
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Company Name </label>
						<select class="form-control " name="Company_id" id="Company_id"  required="required">

						 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>
						</div>
							
					  <div class="form-group" >
						<label for=""> <span class="required_info">* </span>Campaign Name </label>								
						<input class="form-control" name="cmp_name"  id="cmp_name"  type="text" placeholder="Enter Campaign Name" value="<?php echo $Campaign_name; ?>" onblur="game_name_validation(this.value);" required="required" data-error="Please enter campaign name">
						<div class="help-block form-text with-errors form-control-feedback" id="CmpError"></div>
					  </div>
						
						<div class="form-group">
							<label for=""> <span class="required_info">* </span>Game Name </label>
							<select class="form-control " name="Game_id" id="Game_id" required="required" >
								<?php 
								foreach($games as $game_details)
								{
									if($GameID ==  $game_details->Game_id)
									{
								?>
									<option value="<?php echo $game_details->Game_id; ?>" ><?php echo $game_details->Game_name; ?></option>
								<?php 
									}
								}
								?>
							</select>
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
					</div>
					<div class="col-sm-6">	  
					
						<div class="form-group">
						   <label for=""> <span class="required_info">* </span>Competition Start Date</label>
							<input class="single-daterange form-control" value="<?php echo $Start_date; ?>" placeholder="Campaign Start Date" type="text"  name="start_date" id="datepicker1"/>
						</div>
						
						<div class="form-group">
						   <label for=""> <span class="required_info">* </span>Competition End Date</label>
							<input class="single-daterange form-control" value="<?php echo $End_date; ?>" placeholder="Campaign End Date" type="text"  name="end_date" id="datepicker2"/>
						</div>
	
						<input type="hidden"  name="Company_gameid" id="Company_gameid" value="" />	
					</div>
				</div>
				
				<div class="row" id="levels_block">
					<?php
						$l = 1;
						foreach($result6 as $level)
						{

						?>
						<div class="col-sm-6">	
							<div class="form-group" >
								<label for=""> <span class="required_info">* </span>Level </label>								
								<input class="form-control" id='<?php echo "level_".$l; ?>' name="game_levels[]" type="text" readonly value="<?php echo $level->Game_level; ?>">
							</div>
						</div>
						<div class="col-sm-6">	
							<div class="form-group" >
								<label for=""> <span class="required_info">* </span>Points </label>								
								<input class="form-control" id='<?php echo "points_".$l; ?>' name="level_points[]" type="text" required="required" onkeyup="this.value=this.value.replace(/\D/g,'')"  value="<?php echo $level->Reward_points; ?>">
							</div>
						</div>
						<?php
							$l++;
							
						}
					?>
				</div>
					
					<input type="hidden"  name="Company_gameid" id="Company_gameid" value="<?php echo $Company_game_id; ?>" />	
					<input type="hidden"  name="Campaign_id" id="Campaign_id" value="<?php echo $Campaign_id; ?>" />
					<input type="hidden" id="total_levels" value="<?php echo $l;?>" name="total_levels" class="form-control" />	

							
				 <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register" >Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>
				
				</div>
			</div>
<!-------------------- START - Data Table -------------------->
	           
				<div class="element-wrapper">                
						<div class="element-box">
						  <h5 class="form-header">
						   Game Campaigns
						  </h5>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
									<th class="text-center">Action</th>
									<th class="text-center">Game Name</th>
									<th class="text-center">Campaign Name </th>
									<th class="text-center">Valid From</th>
									<th class="text-center">Valid Till</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
									<th class="text-center">Action</th>
									<th class="text-center">Game Name</th>
									<th class="text-center">Campaign Name </th>
									<th class="text-center">Valid From</th>
									<th class="text-center">Valid Till</th>

											
									</tr>
								</tfoot>		

								<tbody>
							<?php
								if(count($cmp_results) > 0)
								{
									foreach($cmp_results as $row)
									{

									?>
										<tr>
											<td class="row-actions">
												<a href="<?php echo base_url()?>index.php/Gamec/edit_company_game_campaign/?game_cmp_id=<?php echo $row->Campaign_id;?>" title="Edit">
													<i class="os-icon os-icon-ui-49"></i>
												</a>
												
												<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Campaign_id;?>','<?php echo $row->Campaign_name; ?>','Campaign','Gamec/delete_game_campaign/?game_cmp_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
													<i class="os-icon os-icon-ui-15"></i>
												</a>
											</td>
											<td class="text-center"><?php echo $row->Game_name;?></td>
											<td><?php echo $row->Campaign_name; ?></td>
											<td><?php echo date("Y-m-d",strtotime($row->Start_date)); ?></td>
											<td><?php echo date("Y-m-d",strtotime($row->End_date)); ?></td>

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
	if( $('#cmp_name').val() !="" && $('#datepicker1').val() !="" && $('#datepicker2').val() !="" && $('#Game_id').val() != "")
	{	
		var allowME = 1;
		var total_levels = $('#total_levels').val();
		
		if(total_levels > 0)
		{
			for(var x=1;x < total_levels; x++)
			{
				var v = $('#points_'+x).val();

				if($('#points_'+x).val() == "")
				{
					allowME = 0;
					$('#points_'+x).addClass("form-control has-error");
					return false;
				}
				else {
					$('#points_'+x).removeClass("has-error");
				}
			}
		}
		
		//alert("total_levels--"+total_levels+"---"+allowME);
		if(allowME == 1)
		{
			show_loader();	
			return true;
		}
		
	}
});

function get_game_levels(input_val)
{
	//var CompanyID = $('#Company_id').val(); 
	
	if(input_val > 0)
	{

		$.ajax({
				type:"POST",
				data:{game_id : input_val},
				url: "<?php echo base_url()?>index.php/Gamec/get_game_levels",
				success: function(data)
			  {
					$('#levels_block').html(data);
			  }
					
			});
	}
		
}

$(document).ready(function() 
	{
		$('#cmp_name').blur(function()
		{
			var cmp_name = $('#cmp_name').val();
			var Comp_id = $('#Company_id').val();

			if( $("#cmp_name").val()  == "" )
			{
				var msg1 = 'Please Enter Campaign Name!!';
				$('#CmpError').show();
				$('#CmpError').html(msg1);
			}
			else
			{
				$.ajax({
					  type: "POST",
					  data: {cmp_name : cmp_name, Company_id : Comp_id},
					  url: "<?php echo base_url()?>index.php/Gamec/validate_campaign_name",
					  success: function(data)
					  {
						// alert(data);
						  
						 if(data.length >= 13)
						{
							$('#cmp_name').val('');
							$("#cmp_name").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#CmpError').show();
							$('#CmpError').html(msg1);
						}
						else
						{
							$('#CmpError').html("");
							$("#cmp_name").removeClass("has-error");
						}
						
							
					  }
				});
			}
		});	
		
	});
	
/******calender *********/
$(function() 
{
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
		
});
/******calender *********/
</script>