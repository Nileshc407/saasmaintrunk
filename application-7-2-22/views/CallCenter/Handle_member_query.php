<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				HANDLE MEMBER QUERY
			  </h6>
			  
					
			  <div class="element-box">
					<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msg" style="display:none;">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button" >
							  <span aria-hidden="true"> &times;</span></button>
							  Please enter atleast one Search Criteria
							</div>
					
			<?php 	$attributes = array('id' => 'formValidate');
					echo form_open_multipart('Call_center/handle_member_query',$attributes); ?>
				
			  <div class="row">
				<legend><span>Enter Search Criteria</span></legend>
				  <div class="col-sm-6">
					<div class="form-group">
						<label for="">
							First Name 
						</label>
						<div class="form-group">
							<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" />			
							
						</div>
					</div>					
					<div class="form-group">
						<label for=""> Membership ID</label>
						<div class="form-group">
							<input type="text" name="card_id" id="card_id"  class="form-control" placeholder="Membership ID" />			
						
						</div>						
					</div>
					<div class="form-group">
						<label for="">Email ID </label>
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Email ID" name="email_id" id="email_id">							
						</div>
					</div>
					
						  
				  </div>
				   <div class="col-sm-6">
					<div class="form-group">
						<label for="">
							 Last Name
						</label>
						<div class="form-group">
							<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" />			
						</div>
					</div>	
					<div class="form-group">
						<label for=""> Mobile Number<span class="required_info"> ( without country code or '0' )</span></label>
						<div class="form-group">
							<input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile Number" />			
						</div>							
					</div>					
					<div class="form-group">
					<label for="">
						 Date of Birth<span class="required_info">(* click inside textbox)</span>
					</label>
					<div class="input-group">
						<input type="text" name="dob" id="datepicker1" class="form-control" placeholder="Date of Birth" />			
						<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
					</div>
					</div>
					
					</div>
					
				</div>
				<div class="form-buttons-w"  align="center">
				
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Search</button>
				 </div>
				</div>
			</div>
			<?php echo form_close(); ?>	
	  </div>
		</div>
	</div>		
			<!--------------Table------------->	 
	<?php 
	// var_dump($Member_info);
	if(isset($_REQUEST["submit"]) && ($Member_info != NULL))
	{ 
	  
		$first_name=$_REQUEST["first_name"]; 
		$last_name=$_REQUEST["last_name"]; 
		$dob=date("Y-m-d",strtotime($_REQUEST["dob"]));
		$card_id=$_REQUEST["card_id"];
		$mobile_no=$_REQUEST["mobile_no"];
		$email_id=$_REQUEST["email_id"];
		
		// echo "---enter_user---".$enter_user."<br>";
		// print_r($Trans_Records);	
	?>		
		<div class="content-panel">  
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   Member Records
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Select</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Membership ID</th>
								<th>Phone no.</th>
								<th>Email ID</th>
								<th>Birth Date</th>
							</tr>
						</thead>	
						<tbody>
					<?php
				if(isset($_REQUEST["submit"]) && ($Member_info != NULL))
				{ 
					foreach($Member_info as $row)
					{	
						?>
						<td><a href="<?php echo base_url()?>index.php/Call_center/edit_handle_member/?Enrollement_id=<?php echo $row['Enrollement_id'];?>"  title="Edit"><i class="os-icon os-icon-ui-49"></i></a></td>
						
						<?php
							echo "<td>".$row['First_name']."</td>";
							echo "<td>".$row['Last_name']."</td>";
							echo "<td>".$row['Card_id']."</td>";
							echo "<td>".App_string_decrypt($row['Phone_no'])."</td>";
							echo "<td>".App_string_decrypt($row['User_email_id'])."</td>";					
							echo "<td>".date("Y-m-d",strtotime($row['Date_of_birth']))."</td>";
							echo "</tr>";					
					}
				}
				?>
						</tbody>
					</table>
				  </div>
				</div>
			</div>
			<?php 
	} 
	else
	{
	?>
		<div class="panel panel-info">
			<div class="panel-heading text-center"><h4>No Record Found</h4></div>
		</div>
	<?php 
	} 
	?>
			<!--------------Table--------------->
		
</div>			
</div>			
<?php $this->load->view('header/footer'); ?>

<script>
$('#Register').click(function()
{
	if($('#first_name').val() == ""  && $('#last_name').val() == "" && $('#datepicker1').val() == "" && $('#card_id').val() == "" && $('#mobile_no').val() == "" && $('#email_id').val() == "" )
	{
		$('#msg').show();	
		return false;
	}
	else
	{ 
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
</script>
