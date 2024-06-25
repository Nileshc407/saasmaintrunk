<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT COMPANY GAME SETUP
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
					echo form_open_multipart('Gamec/update_company_game_setup',$attributes);
					
					foreach($edit_results as $row22)
					{
						$Company_game_id = $row22->Company_game_id;
						$lv_Game_id = $row22->Game_id; 
						$lv_Link_to_game_campaign = $row22->Link_to_game_campaign;
						$lv_Game_for_fun = $row22->Game_for_fun;
						$lv_Game_for_competition = $row22->Game_for_competition;
						$lv_Competition_start_date = date("m/d/Y",strtotime($row22->Competition_start_date));
						$lv_Competition_end_date = date("m/d/Y",strtotime($row22->Competition_end_date));
						$lv_Total_game_winner = $row22->Total_game_winner;
						$lv_Competition_winner_award = $row22->Competition_winner_award;
						$lv_Initial_game_lives = $row22->Initial_game_lives;
						$lv_Lives_flag = $row22->Lives_flag;
						$lv_Points_value_for_one = $row22->Points_value_for_one;
						$lv_Active_flag = $row22->Active_flag;
					}
			?>

					<div class="row">
						<div class="col-md-6">	  		
										   
							<div class="form-group">
							<label for=""> <span class="required_info">* </span>Company Name </label>
							<select class="form-control " name="Company_id"  required="required">

							 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
							</select>
							</div>	
						</div>
						<div class="col-md-6">	 
							<div class="form-group">
							<label for=""> <span class="required_info">* </span>Game Name </label>
							<select class="form-control " name="Game_id" id="Game_id" required="required" data-error="Please select game">

								<?php 
								foreach($games as $game_details)
								{
								?>
									<option value="<?php echo $game_details->Game_id; ?>" onclick="enable_competition('<?php echo $game_details->Score_based_flag; ?>');"><?php echo $game_details->Game_name; ?></option>
								<?php  
									$Score_based_flag = $game_details->Score_based_flag;
								}
								?>
							</select>
							<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>	
						</div>		
					</div>		
						
					<div class="row">
						<div class="col-lg-4 col-md-12">	 		
							<div class="form-group">
							<label for="exampleInputEmail1"> Game for Fun <b>:</b> &nbsp; </label>		
							<label class="radio-inline">
								<input type="radio" name="Fun" id="Fun" <?php if($lv_Game_for_fun == 1){ echo "checked"; }?> value="1">&nbsp;Yes
								<input type="radio" name="Fun" id="Fun" <?php if($lv_Game_for_fun == 0){ echo "checked"; }?> value="0">&nbsp;No
							</label>
							</div>		
						</div>		
						<div class="col-lg-4 col-md-12">	
							<div class="form-group">
								<label for="exampleInputEmail1"> Link to Game Campaign <b>:</b>&nbsp;</label>
								<label class="radio-inline">
									<input type="radio" name="Campaign" id="Campaign" <?php if($lv_Link_to_game_campaign == 1){ echo "checked"; }?> value="1">&nbsp;Yes
									<input type="radio" name="Campaign" id="Campaign" <?php if($lv_Link_to_game_campaign == 0){ echo "checked"; }?> value="0">&nbsp;No
								</label>
							</div>		
						</div>		
						<div class="col-lg-4 col-md-12">	
							<div class="form-group">
								<label for="exampleInputEmail1"> Game for Competition <b>:</b>&nbsp; </label>
								<label class="radio-inline">
									<input type="radio" name="Competition" id="Competition" onclick="set_competition(this.value);"  <?php if($lv_Game_for_competition == 1){ echo "checked"; } if($Score_based_flag == 0){  echo "disabled"; } ?> value="1">&nbsp;Yes
									<input type="radio" name="Competition" id="Competition"  onclick="set_competition(this.value);"  <?php  if($Score_based_flag == 1){  echo "disabled"; } if($lv_Game_for_competition == 0){ echo "checked"; }?> value="0">&nbsp;No
								</label>
							</div>
							<div class="help-block form-text with-errors form-control-feedback" id="competitionError"></div>							
						</div>		
					</div>
			<?php 

				if($lv_Game_for_competition == 1){
			?>		
					<div class="row" id="Competition_block">
						<div class="col-md-6">	
							<div class="form-group">
							   <label for=""> <span class="required_info">* </span>Competition Start Date</label>
								<input class="single-daterange form-control" placeholder="Competition Start Date" type="text" value="<?php echo $lv_Competition_start_date; ?>"  name="start_date" id="datepicker1"/>
							</div>
							
							<div class="form-group" id="moves_block">
							<label for="exampleInputEmail1"><span class="required_info">*</span> Total Game Winners  </label>
							<input type="text" placeholder="Total Game Winners" name="Winners" id="Winners"  class="form-control" data-error="Please enter total winners" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $lv_Total_game_winner; ?>"  readonly />	
							<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

						</div>
						<div class="col-md-6">	
							<div class="form-group">
							   <label for=""> <span class="required_info">* </span>Competition End Date</label>
								<input class="single-daterange form-control" value="<?php echo $lv_Competition_end_date; ?>" placeholder="Competition End Date" type="text"  name="end_date" id="datepicker2"/>
							</div>
						<?php  
						if($lv_Game_for_competition == 1){
						?>
							<div class="form-group" id="lives_block2">
							<label for="exampleInputEmail1"> Enable Live(s) <b>:</b>&nbsp; </label>
							<label class="radio-inline">
								<input type="radio" name="lives_flag" id="lives_flag" onclick="hide_lives(this.value);"  value="1" <?php if($lv_Lives_flag == 1){ echo "checked"; } if($lv_Lives_flag == 0){ echo "disabled"; } ?> >&nbsp;Yes
								<input type="radio" name="lives_flag" id="lives_flag"  onclick="hide_lives(this.value);" value="0" <?php if($lv_Lives_flag == 0){ echo "checked"; } if($lv_Lives_flag == 1){ echo "disabled"; } ?> >&nbsp;No
							</label>
							</div>
						<?php } ?>	
						</div>
					</div>	
				<?php  
					if($lv_Lives_flag == 1){
				?>	
					<div class="row" id="lives_block">
						<div class="col-md-6">
							<div class="form-group">
							<label for=""><span class="required_info">*</span> Initial game lives for customer</label>
							<input type="text"  name="initial_lives" id="initial_lives" value="<?php echo $lv_Initial_game_lives; ?>" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')"  />	
							</div>
						
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
							<label for=""><span class="required_info">*</span> Enter Points value for 1 lives</label>
							<input type="text"  name="points_lives" id="points_lives" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $lv_Points_value_for_one; ?>" />	
							</div>
						</div>
					</div>
				<?php } ?>		
					<div class="row" id="Competition_block2">
						<div class="col-md-6">
						
						<div class="form-group">
							<label for="exampleInputEmail1"> <span class="required_info">*</span>Competition Winner Award <b>:</b>&nbsp; </label>
							<label class="radio-inline">
								<input type="radio" name="Winner_award" id="Winner_award" onclick="set_prize(this.value);" data-error="Please select one option" value="1" <?php if($lv_Competition_winner_award == 1){ echo "checked"; }?> >&nbsp;Points based
								<input type="radio" name="Winner_award" id="Winner_award"  onclick="set_prize(this.value);" data-error="Please select one option" value="2" <?php if($lv_Competition_winner_award == 2){ echo "checked"; }?> >&nbsp;Prize based
							</label>
							<div class="help-block form-text with-errors form-control-feedback"> </div>
						</div>
						
						</div>
					</div>
					<div id="Winner_award_block">
				<?php
					$i=1;
					foreach($edit_child_results as $row13)
					{
				?>	
						<div class="row">
				<?php 	
						if($lv_Competition_winner_award == 1)
						{
				?>
						<div class="col-md-6">
						<div class="form-group">
						<label for=""><span class="required_info">*</span>  Rank <?php echo $i; ?> Points</label>
						<input type="text" id="<?php echo "points_".$i; ?>" value="<?php echo $row13->Game_points_prize; ?>" name="points[]" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" required="required" />	
						</div>
						</div>								
				<?php 
						}
						
						if($lv_Competition_winner_award == 2)
						{
				?>
						<div class="col-md-2 px-2">
							<div class="project-users">
							  <img alt="" src="<?php echo base_url().''.$row13->Game_prize_image;?>" class="rounded-circle" id="<?php echo "blah_".$i; ?>" width="90" height="60">
							</div>
						</div>
						<div class="col-md-4 px-2">
							<div class="form-group">
							<label for="exampleInputEmail1"><span class="required_info">*</span> Enter Prize Name for winner <?php echo $i; ?></label>
							<input type="text" id="<?php echo "prize_".$i; ?>" value="<?php echo $row13->Game_points_prize; ?>" name="prizes[]" class="form-control" required="required" />									
							<input type="file" name="file[]"  id='<?php echo "file_".$i; ?>' onchange="readImage(this,'<?php echo "blah_".$i; ?>');"/>
							<input type="hidden"  name="<?php echo "file_".$i; ?>" value="<?php echo $row13->Game_prize_image; ?>"  />
							</div>
						</div>
				<?php
						}
					?>
						</div>
				<?php
						$i++;
							 	
					}
				?>
					</div>
			<?php  
				}
			?>	
				</div>

				 <div class="form-buttons-w" align="center">
					<input type="hidden" name="Company_game_id"   value="<?php echo $Company_game_id; ?>">
					<button class="btn btn-primary" type="submit" id="Register" >Submit</button>
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
						   Company Game Setup
						  </h5>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Game Name</th>
										<th class="text-center">Game for Fun </th>
										<th class="text-center">Link to Game Campaign</th>
										<th class="text-center">Game for Competition</th>
										<th class="text-center">Enable Lives/Lifes</th>
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Game Name</th>
										<th class="text-center">Game for Fun </th>
										<th class="text-center">Link to Game Campaign</th>
										<th class="text-center">Game for Competition</th>
										<th class="text-center">Enable Lives/Lifes</th>

									</tr>
								</tfoot>		

								<tbody>
							<?php
								if(count($comp_results) > 0)
								{
									foreach($comp_results as $row)
									{
										
										$Game_for_fun="No";	
										if($row->Game_for_fun =='1')
										{
											$Game_for_fun="Yes";
										}
										$Link_to_game_campaign="No";	
										if($row->Link_to_game_campaign  == '1')
										{
											$Link_to_game_campaign="Yes";
										}
										$Game_for_competition="No";	
										if($row->Game_for_competition =='1')
										{
											$Game_for_competition="Yes";
										}
										$Lives_flag="No";	
										if($row->Lives_flag =='1')
										{
											$Lives_flag="Yes";
										}
							
							
									?>
										<tr>
											<td class="row-actions">
												<a href="<?php echo base_url()?>index.php/Gamec/edit_company_game/?company_game_id=<?php echo $row->Company_game_id;?>" title="Edit">
													<i class="os-icon os-icon-ui-49"></i>
												</a>
												
												<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Company_game_id;?>','<?php echo $row->Game_name;?>','Game','Gamec/delete_company_game/?game_id');" title="Delete"  data-target="#deleteModal" data-toggle="modal">
													<i class="os-icon os-icon-ui-15"></i>
												</a>
											</td>
											<td class="text-center"><?php echo $row->Game_name;?></td>
											<td><?php echo $Game_for_fun;?></td>
											<td><?php echo $Link_to_game_campaign;?></td>
											<td><?php echo $Game_for_competition;?></td>
											<td><?php echo $Lives_flag;?></td>
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
$('#Register').click(function(e)
{
	if( $('#Game_id').val() !="" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" && $("input[name=Winner_award]:checked").val() > 0 )
	{
		if($("input[name=Competition]:checked").val() > 0 && $('#Winners').val() == "") {
			return;
		}
		
		if($("input[name=lives_flag]:checked").val() > 0 && ($('#initial_lives').val() == "" || $('#points_lives').val() == "")) {
			return;
		}
		
		if($("input[name=Winner_award]:checked").val() == 1 && $('#points_1').val() < 0 ){
			e.preventDefault();
			return false;
		}
		
		if($("input[name=Winner_award]:checked").val() == 2 && $('#prize_1').val() < 0 ){
			e.preventDefault();
			return false;
		}
		
		show_loader();
	}
});

/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
		
});
/******calender *********/

function enable_competition(abc)
{

	if(abc == 1)
	{
		$( "#Competition" ).prop( "disabled", false );
		$("#competitionError").html("");
		
	}
	else
	{
		$( "#Competition" ).prop( "disabled", true );
		$("#competitionError").html("Note:This game is not for competition.");
	}
}

function set_prize(input_val)
{
	var Winners = $("#Winners").val();
	
	//alert(Winners+"   ===="+input_val);
	
	if(input_val > 0)
	{
	
		$.ajax({
				type:"POST",
				data:{total_winners : Winners, prize_flag : input_val},
				url: "<?php echo base_url()?>index.php/Gamec/set_game_prize",
				success: function(data)
			  {
					$('#Winner_award_block').html(data);
			  }
					
			});
	}
		
}

function hide_lives(input_val)
{
	if(input_val == 0)
	{
		$("#lives_block").hide();
		$("#initial_lives").removeAttr("required");	
		$("#points_lives").removeAttr("required");	
	}
	else
	{
		
		$("#lives_block").show();
		$("#initial_lives").attr("required","required");
		$("#points_lives").attr("required","required");
	}
}

function set_competition(input2_val)
{
	if(input2_val == 0)
	{
		$("#lives_block").hide();
		$("#Competition_block").hide();
		$("#Competition_block2").hide();
		$("#lives_block2").hide();
		$("#datepicker1").removeAttr("required");	
		$("#datepicker2").removeAttr("required");	
		$("#Winners").removeAttr("required");	
		$("#Winner_award").removeAttr("required");	
	}
	else
	{
		$("#Competition_block").show();
		$("#Competition_block2").show();
		$("#lives_block2").show();
		$("#datepicker1").attr("required","required");
		$("#datepicker2").attr("required","required");
		$("#Winners").attr("required","required");
		$("#Winner_award").attr("required","required");

	}
}

 function readImage(input,div_id) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			console.log(e.target.result);
			$("#"+div_id)
				.attr('src', e.target.result)
				.width(90)
                .height(60);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>