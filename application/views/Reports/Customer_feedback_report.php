<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Member_feedback_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Members Feedback Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							<!--
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
								<select class="form-control" name="seller_id" ID="seller_id" required>
									<option value="">Select Business/Merchant</option>
									<?php
									
										
									/* if($Logged_user_id > 2 || $Super_seller == 1)
										{
											echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
										}							
											foreach($Seller_array as $seller_val)
											{
												echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
											} */
									
									?> 
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								-->
							 
								<div class="form-group">
								<label for=""><span class="required_info">* </span>From Date</label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  required="required" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								
								<div class="form-group has-feedback">
					
									<label for="exampleInputEmail1">Membership ID</label>
									<input type="text" id="Single_cust_membership_id"   name="membership_id" class="form-control" placeholder="Enter Membership ID"   onblur="MembershipID_validation(this.value);"/>

									<input type="hidden" name="Company_id" class="form-control" value="<?php echo $Company_details->Company_id; ?>"/>							
									<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>
									<div class="help-block"></div>
								</div>
								
							</div>
							<div class="col-sm-6">
							  
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>Till Date </label>
									<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" required="required" data-error="Please select till date"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								 
								
								
							</div>
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
				
		<?php echo form_close(); ?>
			</div>
		</div>
		
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					 
					  <h6 class="form-header">Members Feedback Report</h6>
					                
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
							
								<tr>
									
								<!--	<th>Sequence No</th>-->
									
									<th>Member Name</th>
									<th>Membership ID</th>
									
									<th>Phone No</th>
									<th>Email</th>
									<th>Feedback Type</th>
									<th>Feedback Comment</th>
									<th>Date</th>
								</tr>
								
								</thead>
								<tfoot>
								
								<tr>
									<!--	<th>Sequence No</th>-->
									<th>Member Name</th>
									<th>Membership ID</th>
									
									<th>Phone No</th>
									<th>Email</th>
									<th>Feedback Type</th>
									<th>Feedback Comment</th>
									<th>Date</th>
								</tr>
								</tfoot>
							<tbody>
						<?php
							$todays = date("Y-m-d");
						  $lv_Company_id = $_REQUEST["Company_id"];
						  $start_date = $_REQUEST["start_date"];
						  $end_date = $_REQUEST["end_date"];
						  $membership_id = $_REQUEST["membership_id"];
						
					
						if(count($Trans_Records) > 0)
						{
							//print_r($Trans_Records[0]);die;
							
							//$From_date=$_REQUEST["start_date"];
							//echo '<table  class="table table-bordered table-hover">';
							$lv_Enrollement_id=0;
							
							foreach($Trans_Records as $row)
							{
								$Member_name=$row->Member_name;
								$Card_id=$row->Membership_id;
								$Enrollement_id=$row->Enrollment_id;
								
							
									echo "<tr>";
									echo "<td>".$Member_name."</td>";
									
									echo "<td>".$Card_id."</td>";
									echo "<td>".$row->Phone_no."</td>";
									echo "<td>".$row->User_email_id."</td>";
									echo "<td>".$row->Feedback_type."</td>";
									echo "<td>".$row->Feedback_comment."</td>";
									echo "<td>".date("Y-m-d",strtotime($row->Comment_date))."</td>";
									
									echo "</tr>";
								
							}
						}
						?>
						
							</tbody>
						</table>
				<?php 
					if($Trans_Records != NULL)
						{ 
						
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Member_feedback_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&membership_id=<?php echo $membership_id; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Member_feedback_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&membership_id=<?php echo $membership_id; ?>&pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
							</a>
					<?php 
						} 
						
					?>
					  </div>
					</div>
				</div>
				<!-----------Table------------>
			
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#seller_id').val() != "" )
		{
			show_loader();
		} 

});


function MembershipID_validation(MembershipID)
{
		
		var Company_id = '<?php echo $Company_id; ?>';
		
		if( MembershipID != "" )
		{

		$.ajax({
				type:"POST",
				data:{MembershipID:MembershipID, Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Reportc/MembershipID_validation",
				success : function(data)
				{ 
					// alert(data.length);
					if(data.length == 14)
					{
						$("#Single_cust_membership_id").val("");
						
						has_error(".has-feedback","#glyphicon",".help-block","Membership ID not Exist.!!");
					}
					else
					{
						has_success(".has-feedback","#glyphicon",".help-block",data);
					}
				}
			});
		}
}
	
	
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