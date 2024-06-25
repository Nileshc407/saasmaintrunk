<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				GAME SETUP
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
					echo form_open('Gamec/game_setup',$attributes); ?>

				<div class="row">
					<div class="col-sm-12">	  		
									   
					  <div class="form-group">
						<label for=""> <span class="required_info">* </span>Game Name </label>								
						<input class="form-control" name="game_name"  id="game_name"  type="text" placeholder="Enter Game Name" onblur="game_name_validation(this.value);" required="required" data-error="Please enter game name">
						<div class="help-block form-text with-errors form-control-feedback" id="GameError"></div>
					  </div>

						<div class="form-group">
							<label for="exampleInputEmail1"> Game Description/ Instructions</label>
							<textarea class="form-control" cols="80" id="ckeditor1" rows="10" name="Game_details"  placeholder="Game Description/ Instruction"></textarea>
						</div>
						
						<div class="form-group" data-placement="top" data-toggle="tooltip" title="If game has image, select yes">
						<label for="exampleInputEmail1"> Image Based Game &nbsp;&nbsp;</label>		
						<label class="radio-inline">
							<input type="radio" name="Image_based" id="Image_based"  value="1">&nbsp;Yes
							<input type="radio" name="Image_based" id="Image_based" checked value="0">&nbsp;No
						</label>
						</div>		
						
						<div class="form-group" data-placement="top" data-toggle="tooltip" title="If game has time to complete level, select yes">
							<label for="exampleInputEmail1"> Time Based Game &nbsp;&nbsp;</label>
							<label class="radio-inline">
								<input type="radio" name="Time_based" id="Time_based"  value="1">&nbsp;Yes
								<input type="radio" name="Time_based" id="Time_based" checked value="0">&nbsp;No
							</label>
						</div>		
						
						<div class="form-group" data-placement="top" data-toggle="tooltip" title="If game has moves to complete level, select yes">
							<label for="exampleInputEmail1"> Moves Based Game&nbsp;&nbsp; </label>
							<label class="radio-inline">
								<input type="radio" name="Moves_based" id="Moves_based"  value="1">&nbsp;Yes
								<input type="radio" name="Moves_based" id="Moves_based" checked value="0">&nbsp;No
							</label>
						</div>		
						
						<div class="form-group" data-placement="top" data-toggle="tooltip" title="If game has score to complete level, select yes">
							<label for="exampleInputEmail1"> Score Based Game &nbsp;&nbsp;</label>
							<label class="radio-inline">
								<input type="radio" name="Score_based" id="Score_based"  value="1">&nbsp;Yes
								<input type="radio" name="Score_based" id="Score_based" checked value="0">&nbsp;No
							</label>
						</div>
						
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
						   Game Setup
						  </h5>                  
						  <div class="table-responsive">
							<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Game Name</th>
										<th class="text-center">Image Based </th>
										<th class="text-center">Time Based</th>
										<th class="text-center">Moves Based</th>
										<th class="text-center">Score Based</th>
										
									</tr>
								</thead>	
								<tfoot>
									<tr>
										<th class="text-center">Action</th>
										<th class="text-center">Game Name</th>
										<th class="text-center">Image Based </th>
										<th class="text-center">Time Based</th>
										<th class="text-center">Moves Based</th>
										<th class="text-center">Score Based</th>
											
									</tr>
								</tfoot>		

								<tbody>
							<?php
								if($results != NULL)
								{
									foreach($results as $row)
									{
										
										$Game_image_flag="No";	
										if($row->Game_image_flag == '1')
										{
											$Game_image_flag="Yes";
										}
										$Time_based_flag="No";	
										if($row->Time_based_flag == '1')
										{
											$Time_based_flag="Yes";
										}
										$Moves_based_flag="No";	
										if($row->Moves_based_flag == '1')
										{
											$Moves_based_flag="Yes";
										}
										$Score_based_flag="No";	
										if($row->Score_based_flag == '1')
										{
											$Score_based_flag="Yes";
										}
							
							
									?>
										<tr>
											<td class="row-actions">
												<a href="<?php echo base_url()?>index.php/Gamec/edit_game/?Game_id=<?php echo $row->Game_id;?>" title="Edit">
													<i class="os-icon os-icon-ui-49"></i>
												</a>
												
												<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Game_id;?>','<?php echo $row->Game_name;?>','Game','Gamec/delete_game/?game_id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
													<i class="os-icon os-icon-ui-15"></i>
												</a>
											</td>
											<td class="text-center"><?php echo $row->Game_name;?></td>
											<td><?php echo $Game_image_flag;?></td>
											<td><?php echo $Time_based_flag;?></td>
											<td><?php echo $Moves_based_flag;?></td>
											<td><?php echo $Score_based_flag;?></td>
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
});

function game_name_validation(gamename)
	{

		$.ajax({
				type:"POST",
				data:{gamename:gamename},
				url: "<?php echo base_url()?>index.php/Gamec/game_name_validation",
				success : function(data)
				{ 
					//alert(data.length);
					if(data.length >= 13)
					{
						$("#game_name").val("");
						$("#game_name").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#GameError').show();
							$('#GameError').html(msg1);
					}
					else
					{
						$('#GameError').html("");
						$("#game_name").removeClass("has-error");
					}
				}
			});
	}
</script>