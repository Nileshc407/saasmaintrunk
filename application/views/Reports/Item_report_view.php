<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Item_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Item Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
								<select class="form-control" name="seller_id" ID="seller_id" required>
									<option value="">Select Business/Merchant</option>
									<?php
									
									
									//echo $Logged_user_id."-----".$Super_seller;
										if($Logged_user_id > 2 || $Super_seller == 1)
										{
											echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
										}							
											foreach($Seller_array as $seller_val)
											{
												echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
											}
										?> 
							</select>
							</div>
							
								
								
								<div class="form-group">
									<label for="">Menu Group</label>
									<select class="form-control"  name="Category"  ID="Category" >
										<option value="0">Select Business/Merchant First</option>

									</select>
									
								 </div>
							  
								
								
								<div class="form-group">
									<label for="">Item</label>
									<select class="form-control"  name="Item[]"  ID="Item" multiple >
										<option value="0">Select Menu Group First</option>

									</select>
									
								 </div>
							  
								
							  
								
								
							   
								
								
								
							</div>
							<div class="col-sm-6">
							  
								<div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date </label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  required="required" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>

							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date </label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" required="required" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
								<div class="form-group">
							   <label for="">Membership ID </label>
								<input class="form-control" placeholder="Enter Membership ID" type="text"  name="MembershipID" id="MembershipID" onchange="MembershipID_validation(this.value);"/>
								<div class="help-block form-text with-errors form-control-feedback" id="err"></div>
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
					  <h6 class="form-header"> Item Report Records
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

							
							<tr>
							<th>MembershipID</th>
							<th>Member Name</th>
							<th>Phone</th>
							<th>Item</th>
							<th>Times Purchased</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Menu Group</th>
							<th>Times Purchased</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							

							</tr>

							</thead>						
							<tfoot>
								<tr>
							<th>MembershipID</th>
							<th>Member Name</th>
							<th>Phone</th>
							<th>Item</th>
							<th>Times Purchased</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Menu Group</th>
							<th>Times Purchased</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							
							</tr>
								

							</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");
						// $Item = $_REQUEST['Item'];
						 $ci_object = &get_instance(); 
						if(count($Trans_Records) > 0)
						{
							$lv_MembershipID='0';
							$lv_category_id='0'; 
							foreach($Trans_Records as $row)
							{
								$MembershipID=$row->MembershipID;
								$Merchandize_category_id=$row->Merchandize_category_id;
								// $Times_purchased = array();
								foreach($Trans_Records2 as $row2)
								{
									$MembershipID2=$row2->MembershipID;
									$Merchandize_category_id2=$row2->Merchandize_category_id;
									
									if($MembershipID == $MembershipID2 && $Merchandize_category_id2 == $Merchandize_category_id)
									{  //die;
										$Times_purchased=$row2->Cat_Times_purchased;
										$Cat_value=$row2->Cat_value;
									}
									else
									{
										continue;
									}
									
								}
								echo "<tr>";
								echo "<td>".$row->MembershipID."</td>";
								echo "<td>".$row->Member_name."</td>";
								echo "<td>".$row->Phone_no."</td>";
								echo "<td>".$row->Merchandize_item_name."</td>";
								echo "<td>".$row->Times_purchased."</td>";
								// echo "<td>".number_format(round($row->Item_value),2)."</td>";
								echo "<td>".$row->Item_value."</td>";
								echo "<td>".$row->Menu_group."</td>";
								echo "<td>".$Times_purchased."</td>";
								echo "<td>".number_format(round($Cat_value),2)."</td>";
								
								
								echo "</tr>";
								
								$lv_MembershipID=$MembershipID;
								$lv_category_id=$Merchandize_category_id;
							}
							
						}
						?>
							</tbody>
						</table>
						<?php 
						if($Trans_Records != NULL)
						{ 
						
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Item_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Category=<?php echo $Category; ?>&Item=<?php echo $Item; ?>&seller_id=<?php echo $seller_id; ?>&MembershipID=<?php echo $MembershipID; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Item_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Category=<?php echo $Category; ?>&Item=<?php echo $Item; ?>&seller_id=<?php echo $seller_id; ?>&MembershipID=<?php echo $MembershipID; ?>&pdf_excel_flag=2">
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
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#report_type').val() != "" && $('#Outlet_id').val() != ""  && $('#seller_id').val() != "" )
		{
			show_loader();
		} 

});
/*
$(document).ready(function() {
	  var oTable = $('#dataTable1').dataTable();
 
	   // Sort immediately with columns 0 and 1
	   oTable.fnSort( [ [6,'desc'] ] );
	 } );*/
	$('#seller_id').change(function()
	{
		var seller_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_category_by_subadmin',
			success:function(opData4){
			
				$('#Category').html(opData4);
			}
		});
			
	});
	$('#Category').change(function()
	{
		var Category = $("#Category").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Category:Category,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_items_by_category',
			success:function(opData4){
			
				$('#Item').html(opData4);
			}
		});
			
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
					if(data.length == 13)
					{
						$("#MembershipID").val("");
						$("#err").html("Membership ID not Exist.!!");
						
						has_error(".has-feedback","#glyphicon",".help-block","Membership ID not Exist.!!");
					}
					else
					{
												$("#err").html("");
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
