<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				COMPANY GAME SETUP
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
					echo form_open_multipart('Gamec/company_game_setup',$attributes); ?>

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

							 <option value=""> Select Game </option>
								<?php 
								foreach($games as $game_details)
								{
									if( $game_details->Score_based_flag == 0){ ?>
									<option value="<?php echo $game_details->Game_id; ?>" onclick="enable_competition(0);"><?php echo $game_details->Game_name; ?></option>
								<?php }else if( $game_details->Score_based_flag == 1){ ?>	
									<option value="<?php echo $game_details->Game_id; ?>" onclick="enable_competition(1);" ><?php echo $game_details->Game_name; ?></option>
								<?php } 
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
								<input type="radio" name="Fun" id="Fun"  value="1">&nbsp;Yes
								<input type="radio" name="Fun" id="Fun" checked value="0">&nbsp;No
							</label>
							</div>		
						</div>		
						<div class="col-lg-4 col-md-12">	
							<div class="form-group">
								<label for="exampleInputEmail1"> Link to Game Campaign <b>:</b>&nbsp;</label>
								<label class="radio-inline">
									<input type="radio" name="Campaign" id="Campaign"  value="1">&nbsp;Yes
									<input type="radio" name="Campaign" id="Campaign" checked value="0">&nbsp;No
								</label>
							</div>		
						</div>		
						<div class="col-lg-4 col-md-12">	
							<div class="form-group">
								<label for="exampleInputEmail1"> Game for Competition <b>:</b>&nbsp; </label>
								<label class="radio-inline">
									<input type="radio" name="Competition" id="Competition" onclick="set_competition(this.value);"  value="1">&nbsp;Yes
									<input type="radio" name="Competition" id="Competition" checked  onclick="set_competition(this.value);" value="0">&nbsp;No
								</label>
							</div>
							<div class="help-block form-text with-errors form-control-feedback" id="competitionError"></div>							
						</div>		
					</div>
					<div class="row" id="Competition_block" style="display:none;">
						<div class="col-md-6">	
							<div class="form-group">
							   <label for=""> <span class="required_info">* </span>Competition Start Date</label>
								<input class="single-daterange form-control" placeholder="Competition Start Date" type="text"  name="start_date" id="datepicker1"/>
							</div>
							
							<div class="form-group" id="moves_block">
							<label for="exampleInputEmail1"><span class="required_info">*</span> Total Game Winners  </label>
							<input type="text" placeholder="Total Game Winners" name="Winners" id="Winners"  class="form-control" data-error="Please enter total winners" onkeyup="this.value=this.value.replace(/\D/g,'')" />	
							<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

						</div>
						<div class="col-md-6">	
							<div class="form-group">
							   <label for=""> <span class="required_info">* </span>Competition End Date</label>
								<input class="single-daterange form-control" placeholder="Competition End Date" type="text"  name="end_date" id="datepicker2"/>
							</div>
	
							<div class="form-group" id="lives_block2" style="display:none;">
							<label for="exampleInputEmail1"> Enable Live(s) <b>:</b>&nbsp; </label>
							<label class="radio-inline">
								<input type="radio" name="lives_flag" id="lives_flag" onclick="hide_lives(this.value);"  value="1">&nbsp;Yes
								<input type="radio" name="lives_flag" id="lives_flag" checked  onclick="hide_lives(this.value);" value="0">&nbsp;No
							</label>
							</div>
							
						</div>
					</div>	
					
					<div class="row" id="lives_block" style="display:none;">
						<div class="col-md-6">
							<div class="form-group">
							<label for=""><span class="required_info">*</span> Initial game lives for customer</label>
							<input type="text"  name="initial_lives" id="initial_lives" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')"  />	
							</div>
						
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
							<label for=""><span class="required_info">*</span> Enter Points value for 1 lives</label>
							<input type="text"  name="points_lives" id="points_lives" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')"  />	
							</div>
						</div>
					</div>
					
					<div class="row" id="Competition_block2" style="display:none;">
						<div class="col-md-6">
						
						<div class="form-group">
							<label for="exampleInputEmail1"> <span class="required_info">*</span>Competition Winner Award <b>:</b>&nbsp; </label>
							<label class="radio-inline">
								<input type="radio" name="Winner_award" id="Winner_award" onclick="set_prize(this.value);" data-error="Please select one option" value="1">&nbsp;Points based
								<input type="radio" name="Winner_award" id="Winner_award"  onclick="set_prize(this.value);" data-error="Please select one option" value="2">&nbsp;Prize based
							</label>
							<div class="help-block form-text with-errors form-control-feedback"> </div>
						</div>
						
						</div>
					</div>
					<div id="Winner_award_block">

					</div>
					
				</div>

				 <div class="form-buttons-w" align="center">
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