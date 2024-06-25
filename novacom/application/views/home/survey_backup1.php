 <?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
		<?php echo form_open_multipart('Cust_home/survey');	?>
        <section class="content-header">
          <h1>
           Survey
          </h1>
         
        </section>

		<?php
			if(@$this->session->flashdata('survey'))
			{
			?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('survey'); ?>';
					runjs(Title,msg);
				</script>
			<?php
			}	
			?>
        <!-- Main content -->
        <section class="content">		
			<div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Survey</h3>                 
                </div>
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>                       
							  
							  <th>Question Details</th>
							  <th>Give Your Answer </th>
                        </tr>
                      </thead>
					  <tbody>
					 
					  <tr>	
							<td>Are you currently using any of Nesspro Products</td>
							<td>	<label class="radio-inline">
									<input type="radio" name="ness_porduct" id="ness_porduct"    value="1" >Yes
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="ness_porduct"  id="ness_porduct" value="0" >No
									</label>
									<input type="hidden" name="Question_id1" value="1">
							</td>
					  </tr>
						<tr>
							<td>Which Products are you currently using
							</td>
							<td><input type="text" name="curr_prod"  id="curr_prod" class="form-control"  />
							<input type="hidden" name="Question_id2" value="2">
							</td>
							</tr>
						<tr>									
							<td>Are you satisfied which the Products and Services</td>										
							<td><label class="radio-inline">
								<input type="radio" name="satisfy" id="satisfy"    value="1" >Yes
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="satisfy"  id="satisfy" value="0" >No
								</label>
								<input type="hidden" name="Question_id3" value="3">
							</td>
						</tr>
						<tr>
							<td>Would you recommend our products to your friends /relatives										
							</td>										
							<td><label class="radio-inline">
									<input type="radio" name="recommend" id="recommend"    value="1" >Yes
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="recommend"  id="recommend" value="0" >No
									</label>
									<input type="hidden" name="Question_id4" value="4">
							</td>										
							</td>
						</tr>
						<tr>
							<td>Any Suggestions /Improvement										
							</td>
							<td><textarea class="form-control" rows="3" name="Suggestions"  id="Suggestions" ></textarea>
							<input type="hidden" name="Question_id5" value="5">
							</td>										
					   </tr>
								  
					</tbody>                     
                    </table>
                  </div>
                </div> 							
			</div>		
			
			
			<div class="login-box">
			  <div class="login-box-body">
						 
				  <div class="row">					
					<div class="col-xs-12">
						<button type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" >Submit</button>
						<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
						<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
						<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
						
					</div><!-- /.col -->
				  </div>


			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
			
			
		
		</section>
        
		<?php $this->load->view('header/loader');?> 
      <?php $this->load->view('header/footer');?>	
	  
 <script>
 
$('#submit').click(function()
{
	var flag=0;
	var total_question='<?php echo count($Survey_details); ?>';
	
	for (var i = 1; i < total_question; i++) 
	{ 		
		
		 if( $('#'+i).val() == "")
		{			
			alert($('#'+i).val());
			 flag=1;			
		}
		else
		{
			flag=0;	
		} 
		
	}
	if(flag==1)
	{
			var Title = "Application Information";
			var msg = 'Please answer all the Questions';
			runjs(Title,msg);
			return false;
	}

	/* foreach($Survey_details as $Survey) 
	
	if( $('#datepicker').val() != "" && $('#datepicker2').val() != "" && $('#THH').val() != "" && $('#TMM').val() != "" && $('#auction_name').val() != "" && $('#prize').val() != "" && $('#minpointstobid').val() != "" && $('#minincrement').val() != "" && $('#auction_image').val() != "" )
	{
		show_loader();
	} */
});
	  
	</script>  