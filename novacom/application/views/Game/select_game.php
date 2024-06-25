<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');
?>
<script src="<?php echo base_url()?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>

 
<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
	<script>
			BootstrapDialog.show({
			closable: false,
			title: 'Application Information',
			message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					window.location='<?php echo base_url()?>index.php/Cust_home/home';
				}
			}]
		});
		runjs(Title,msg);
	</script>
<?php } ?>

        <!-- Content Header (Page header) -->
		<?php echo form_open('Cust_home/game_to_play');	?>
		<?php
			if(@$this->session->flashdata('select_game'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('select_game'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}	
			?>
        <section class="content-header">
          <h1>
           Select Game to Play
          </h1>          
        </section>

        <!-- Main content -->
        <section class="content">
		
         <div class="row">
			 
		  <div class="login-box">
			  <div class="login-box-body">
				<form action="#" method="post">
					
				<div class="form-group has-feedback">
					
					<div class="panel panel-default">
					  <div class="panel-heading"><label for="exampleInputEmail1"> Play Game </label></div>
					  <div class="panel-body">
						<label class="radio-inline">
						<input type="radio" required name="game_for" id="inlineRadio1" onclick="get_games(this.value)" value="1">For Fun	
						<br>
							<input type="radio" required  name="game_for" id="inlineRadio2" onclick="get_games(this.value)" value="2">For Campaign
						<br>
							<input type="radio" required name="game_for" id="inlineRadio3" onclick="get_games(this.value)" value="3">For Competition
						</label>
						
						</div>
					</div>
				</div>
				
				<div class="form-group" id="game_block" >
						<label for="exampleInputEmail1">Game Name</label>
						<select class="form-control" name="Game_id" id="Game_id" required>
							<option value=""> Select Game </option>
					
						</select>							
				</div>
					
					
			  <div class="row">				
				 <div class="col-xs-12">				 
					<button type="submit" class="btn btn-primary btn-block btn-flat" id="submit" name="submit" >Submit</button>
					<button type="reset" class="btn btn-primary btn-block btn-flat">Reset</button>
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
						  <input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
						  <input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
						  
						  <input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
				</div>
				<!-- /.col -->
				<div class="col-xs-4">
					
				</div><!-- /.col -->
			  </div>
			</form>
			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
		
		</div>   <!-- /.row -->
		  
			  
		<?php echo form_close(); ?>
        </section><!-- /.content -->
      <?php $this->load->view('header/footer');?>
	  
<style>
.login-box{
	margin: 2% auto;
}
</style>
<script>
	function get_games(input_val)
	{
		var compID = '<?php echo $Company_id; ?>';
		
		//alert("comp id--"+compID+"--game flag--"+input_val);
		
		$.ajax({
				type: "POST",
				data: {companyID:compID, game_flag:input_val},
				url:"<?php echo base_url()?>index.php/Cust_home/get_games",
				success:function(data)
				{
					$('#game_block').html(data);
				}
			});
	}
</script>
