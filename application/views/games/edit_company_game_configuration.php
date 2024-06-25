<?php $this->load->view('header/header'); ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   EDIT COMPANY GAME CONFIGURATION
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
					echo form_open_multipart('Gamec/update_company_game_configuration',$attributes);
					
					foreach($editResult as $row100)
					{
						$lv_Game_configuration_id = $row100->Game_configuration_id;
						$lv_Company_game_id = $row100->Company_game_id;
						$lv_Game_id = $row100->Game_id;
						$lv_Game_level = $row100->Game_level;
						$lv_Total_moves = $row100->Total_moves;
						
						$lv_Issued_lives = $row100->Issued_lives;
						$lv_Game_matrix = $row100->Game_matrix;
						$lv_Game_image = $row100->Game_image;
						
						$lv_Time_for_level = $row100->Time_for_level;
						
						$hh = date("H",strtotime($lv_Time_for_level)); //echo "hh--".$hh."--<br>";
						$mm = date("i",strtotime($lv_Time_for_level)); //echo "mm--".$mm."--<br>";
						$ss = date("s",strtotime($lv_Time_for_level)); //echo "ss--".$ss."--<br>";
						
					}
				?>
						
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Company Name </label>
						<select class="form-control " name="Company_id"  required="required">

						 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>
						</div>		  		
									  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Game Name </label>
						<select class="form-control " name="Game_id" id="Game_id" required="required" data-error="Please select game">
							
						<?php 
							foreach($games as $game_details)
							{
								if($lv_Game_id == $game_details->Game_id)
								{
							?>
								<option value="<?php echo $game_details->Game_id; ?>" ><?php echo $game_details->Game_name; ?></option>
							<?php
							
									$Time_based_flag = $game_details->Time_based_flag;
									$Moves_based_flag = $game_details->Moves_based_flag;
									$Lives_flag = $game_details->Lives_flag;
									$Game_image_flag = $game_details->Game_image_flag;
									$Company_game_id = $game_details->Company_game_id;
								}
							}
						?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Enter Game Level </label>
						<input class="form-control" name="game_level" id="game_level" type="text" value="<?php echo $lv_Game_level; ?>" readonly data-error="Please enter game level">
						<div class="help-block form-text with-errors form-control-feedback" id="LevelError"></div>
					  </div>
					<?php if($Time_based_flag == 1){ ?>	
						<div class="form-group" id="time_block">
						
							<label for=""><span class="required_info">*</span> Select Time for Level </label>
							<select name="level_time_hour" required="required" id="level_time_hour" class="txtbox-1" style="width:15%;">
								<option value="<?php echo $hh; ?>"><?php echo $hh; ?></option>
								<?php
								for($i=1;$i<=24;$i++)
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
							</select>
							
							<span>&nbsp;&nbsp;&nbsp;</span>
							
							<select name="level_time_minute" required="required" id="level_time_minute" class="txtbox-1" style="width:15%;">
								<?php
								for($J=1;$J<=59;$J++)
								{
									if($J == $mm)
									{
										echo '<option selected value="'.$J.'">'.$J.'</option>';
									}
									else
									{
										echo '<option value="'.$J.'">'.$J.'</option>';
									}
								}
								?>
							</select>
							
							<span>&nbsp;&nbsp;&nbsp;</span>
							
							<select name="level_time_second" required="required" id="level_time_second" class="txtbox-1" style="width:15%;">
								<option value="<?php echo $ss; ?>" > <?php echo $ss; ?>  </option>
								<?php
								for($k=1;$k<=59;$k++)
								{
									echo '<option value="'.$k.'">'.$k.'</option>';
								}
								?>
							</select>
							<div class="help-block form-text with-errors form-control-feedback" id="timer"></div>
						</div>
					<?php } 
					if($Moves_based_flag == 1){
					?>		
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Enter Total Moves for Level </label>
						<input class="form-control" name="game_moves" id="game_moves" type="text"  placeholder="Enter Total Moves for Level" data-error="Please enter total moves"  value="<?php echo $lv_Total_moves; ?>" required="required">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					<?php } 
					if($Lives_flag == 1){
					?>	
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Bonus Lives for Completing Level </label>
						<input class="form-control" name="bonus_lives" id="bonus_lives" type="text"  placeholder="Enter Bonus Lives" data-error="Please enter bonus lives" value="<?php echo $lv_Issued_lives; ?>" required="required">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					<?php } ?>		
					</div>	
					<div class="col-sm-12 col-md-6">	
					<?php 
					if($Game_image_flag == 1){		
					?>		
						<div class="form-group">
						<label for=""> <span class="required_info">* </span>Matrix Size for Image  <span class="required_info">(5 = 5 Rows X 5 Columns )</span></label>
						<input class="form-control" name="image_matrix" id="image_matrix" type="text" required="required" placeholder="Enter Matrix Size for Image" value="<?php echo $lv_Game_matrix; ?>" data-error="Please enter matrix size for image">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div id="image_block">
							<div class="form-group">
							<label for=""><span class="required_info">*</span> Upload Game Image for Level </label>
							<input type="file" name="file" id="gameIMG" onchange="readURL(this);" />
								
								<div class="col-md-4" style="margin: 10px auto;">
								<?php if($lv_Game_image == ""){ ?>
									<img src="<?php echo base_url(); ?>images/no_image.jpeg" id="no_image" class="img-responsive" width="100" height="80" />
								<?php } else { ?>
									<img src="<?php echo base_url().$lv_Game_image; ?>" id="no_image" class="img-responsive" width="120" height="100" />
								<?php } ?>
								</div>
								
								<span class="required_info">
								* Upload image size between 600kb to 800kb. Use Image of Resolution 1400 Pixels (H) X 1080 Pixels (V)
								</span>
							</div>
						</div>
					<?php } ?>	
						
						<input type="hidden"  name="allow_time" id="allow_time" value="<?php echo $Time_based_flag; ?>" />	
						<input type="hidden"  name="allow_moves" id="allow_moves" value="<?php echo $Moves_based_flag; ?>" />	
						<input type="hidden"  name="allow_lives" id="allow_lives" value="<?php echo $Lives_flag; ?>" />	
						<input type="hidden"  name="allow_image" id="allow_image" value="<?php echo $Game_image_flag; ?>" />	
						<input type="hidden"  name="Company_gameid" id="Company_gameid" value="<?php echo $Company_game_id; ?>" />	
						<input type="hidden"  name="Game_configuration_id" id="Game_configuration_id" value="<?php echo $lv_Game_configuration_id; ?>" />	
						
					</div>
					
				</div>

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
						   Company Game Configuration
						  </h5>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Game Name</th>
										<th class="text-center">Game Level </th>
										<th class="text-center">Time For Level</th>
										<th class="text-center">Total Moves</th>
										<th class="text-center">Bonus Lives</th>
										<th class="text-center">Matrix Size</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Game Name</th>
										<th class="text-center">Game Level </th>
										<th class="text-center">Time For Level</th>
										<th class="text-center">Total Moves</th>
										<th class="text-center">Bonus Lives</th>
										<th class="text-center">Matrix Size</th>

									</tr>
								</tfoot>		

								<tbody>
								<?php
								if(count($config_results) > 0)
								{
									foreach($config_results as $row)
									{

									?>
										<tr>
											<td class="row-actions">
												<a href="<?php echo base_url()?>index.php/Gamec/edit_company_game_configuration/?game_config_id=<?php echo $row->Game_configuration_id;?>" title="Edit">
													<i class="os-icon os-icon-ui-49"></i>
												</a>
												
												<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Game_configuration_id;?>','<?php echo $row->Game_name;?>','Game Configuration','Gamec/delete_company_game_configuration/?game_config_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
													<i class="os-icon os-icon-ui-15"></i>
												</a>
											</td>
											<td class="text-center"><?php echo $row->Game_name;?></td>
											<td><?php echo $row->Game_level; ?></td>
											<td><?php echo $row->Time_for_level; ?></td>
											<td><?php echo $row->Total_moves; ?></td>
											<td><?php echo $row->Issued_lives; ?></td>
											<td><?php echo $row->Game_matrix; ?></td>
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
	if( $('#Game_id').val() !="" && $('#game_level').val() != "")
	{
		var allow_me = 0;
		
		if( $('#allow_time').val() == 1) //*** check for time
		{
			
			
			if($("#level_time_hour").val() == "" && $("#level_time_minute").val() == "" && $("#level_time_second").val() == "" )
			{
				
				$('#timer').show();
				$('#timer').html("Please Select Time for Level..!!");
				allow_me = 1;
				//alert("in time check---"+allow_me);
				return false;
				
			}
			else
			{
				$('#timer').hide();
				$('#timer').html("");
				allow_me = 0;
			}
		}
		
		if($('#allow_moves').val()  == 1) //*** check for moves
		{
			if($("#game_moves").val() != "" )
			{
				allow_me = 0;
			}
			else
			{
				allow_me = 1;
				return false;
			}
		}
		else if($('#allow_lives').val()  == 1) //*** check for lives
		{
			if($("#bonus_lives").val() != "" )
			{
				allow_me = 0;
			}
			else
			{
				allow_me = 1;
				return false;
			}
		}
		else if($('#allow_image').val()  == 1) //*** check for image
		{
			if($("#gameIMG").val() != "" && $("#image_matrix").val() != "" )
			{	
				allow_me = 0;
			}
			else
			{
				allow_me = 1;
				//return false;
			}
		}
		
		if(allow_me == 0)
		{
			show_loader();
			return true;
		}
	}
});
	
//******** image upload **************/
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(160);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }	
</script>