<?php 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
$this->load->view('header/header');
?>
<script src="<?php echo base_url()?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>


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

        <!-- Main content -->
        <section class="content">
		
         <div class="row">
		  <div class="login-box">
			  <div class="login-box-body">
				<form action="#" method="post">
					
				<div class="form-group has-feedback">
					
					<img src="<?php echo $this->config->item('base_url2'); ?>Game_memory-game/images/call1.png" width="50" height="50" />
				</div>

					
			  <div class="row">				
				 <div class="col-xs-12">				 
				
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

