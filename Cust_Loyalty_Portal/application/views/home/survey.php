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
			<form action="#" method="post">
			
        <!-- Main content -->
        <section class="content">		
			<div class="box box-info">
                <div class="box-header with-border">              
                </div>
				<div class="small-box" style="background-color: rgb(49, 133, 156) ! important;">
					<div class="inner" style="padding: 5px;">
						<h4 class="text-center" style="margin: 3px;color: #fff;">We value your feedback as it helps us to serve you better. So please do answer all the Questions!!</h4>
					</div>
				</div>
				<div class="col-md-6">									
					  <?php 
							$i=1;
							foreach($Survey_details as $Survey) 
							{
								if($Survey)
								{
									
									$Question_id=$Survey['Question_id'];
									$Survey['Response_type'];
									?>
									<div class="box box-info box-solid">
									<div class="box-body">
										
												
													<strong><?php echo $Survey['Question']; ?></strong>
													
													<a class="pull-right"><?php if($Survey['Response_type']=='1') { ?>
													<label class="radio-inline">
													<input type="radio"  name="<?php echo $Question_id; ?>"    value="1" required>Yes
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio"  name="<?php echo $Question_id; ?>"   value="0" required >No
													</label>
													<?php  } else if($Survey['Response_type']=='2') { ?>
													<input type="text" size="50"  name="<?php echo $Question_id; ?>"  id="<?php echo $i; ?>" class="form-control" required />
													<?php } else if($Survey['Response_type']=='3') { ?>
													<textarea class="form-control" rows="3" cols="50" name="<?php echo $Question_id; ?>"   id="<?php echo $Question_id; ?>" required></textarea>
													<?php } ?>
													</a>
												
											</div>
											</div>
										
									
										
								<?php 
									$i++;
									}								
								}
								?>										
				
            	<input type="submit" name="submit" id="Submit"  Value="Submit" class="btn btn-primary btn-block btn-flat"  >
						<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
						<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
						<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
						
					
			</div>		
			
					 
				<div class="row">					
					
				  </div>
					 
				  


			
			
		
		</section>
		</form>
        <?php echo form_close(); ?>
		<?php $this->load->view('header/loader');?> 
		<?php $this->load->view('header/footer');?>	

<style>		
.login-box-body{
background:none;
}
</style>		
 <script>
 
/*  var valSel = new Array();

function multSubType(sel) {
    var objSel = document.getElementById('subType' + sel);
    valSel.push(objSel.value);
} */
/* 
var array1 = new Array();
var array2 = new Array();
var total_question='<?php echo count($Survey_details); ?>';

function srcBlur(Val) {

		array1.push(Val.id);
			// alert(array1.join(', '));
			var array_length=array1.length;
			Check_Question(array_length);
			
}
function Check_Question(arr)
{	
	// 
	
	alert('Check_Question');
	array2.push(arr);	
	var array_length2=array2.length;
	alert(array_length2);
	alert(total_question);
	return false; */
	/* if( array_length2 < total_question && array_length2.length ==0 )
	{
		var Title = "Application Information";
		var msg = 'Please answer all the Questions';
		runjs(Title,msg);
		return false;
	} */

	
	// alert(srcBlur());
	/* if(srcBlur() < total_question)
	{
		var Title = "Application Information";
		var msg = 'Please answer all the Questions';
		runjs(Title,msg);
		return false;
	} */
	// return false;
// }
 
  
	
	
/* $('#submit').click(function()
{

	var flag=0;
	var total_question='<?php echo count($Survey_details); ?>';
	
	for (var i = 1; i < total_question; i++) 
	{ 		
		// alert($('#'+i).val());	
		 $("input[name=loyalty_rule_setup]:checked").val();
		if( $('#'+i).val() == "")
		{
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
});
 */	  
	</script>  