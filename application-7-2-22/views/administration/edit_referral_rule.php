<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   REFERRAL RULE
			  </h6>
			  <div class="element-box panel">
			 		 <!-----------------------------------Flash Messege-------------------------------->

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
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('Administration/update_referral_rule',$attributes); ?>	
				<div class="row">				
				<div class="col-sm-6">
				  <div class="form-group">
					<label for="">Company Name</label>
					<select class="form-control" name="Company_id"  required="required">
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option> 
					</select>
				  </div>  
				  
				  
				  <div class="form-group">
					<label for=""><span class="required_info" style="color:red;">* </span>Merchant Name</label>
					<select class="form-control" name="new_seller_id" ID="new_seller_id"    data-error="Please Select Merchant Name"  required="required" >
						<?php
								foreach($Seller_array as $seller_val)
								{?>
									<option value="<?php echo $seller_val->Enrollement_id;?>" 	<?php if( $results->Seller_id==$seller_val->Enrollement_id){echo "selected";}?>><?php echo $seller_val->First_name." ".$seller_val->Last_name;?></option>
							<?php	} 
							?>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
					
					<input type="hidden" name="old_seller_id" value="<?php echo $results->Seller_id;?>">
						<input type="hidden" name="old_referral_rule_for" value="<?php echo $results->Referral_rule_for;?>">
						<input type="hidden" name="Company_id" value="<?php echo $Company_details->Company_id;?>">
				  </div> 
				  
				  
				  <div class="form-group">
					  <label for=""><span class="required_info"  style="color:red;">*</span> Reference For</label>
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input type="radio"  class="form-check-input"  name="new_referral_rule_for" id="new_referral_rule_for" value="1" onclick="javascript:showhide(this.value);"  <?php if( $results->Referral_rule_for==1){echo "checked";}?>  >Enrollment</label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label class="form-check-label"><input type="radio"  class="form-check-input"  name="new_referral_rule_for" id="new_referral_rule_for" value="2" onclick="javascript:showhide(this.value);"   <?php if( $results->Referral_rule_for==2){echo "checked";}?> >Transaction</label>
						
						
					</div>
				  
				  
				  
				
				  <div class="form-group" id="cust" <?php if( $results->Referral_rule_for!=1){ echo 'style="display:none;"';}?>>
						<label for=""><span class="required_info"  style="color:red;">*</span> Auto Topup for New Member</label>
						<input type="text" name="tonewcust" id="tonewcust"  class="form-control" placeholder="Enter Topup for New Member"  required onkeypress="return isNumberKey2(event)"   data-error="Please Enter Auto Topup for New Member"      value="<?php if( $results->Referral_rule_for==1){echo $results->Customer_topup;}?>"/>	
						
						<div class="help-block form-text with-errors form-control-feedback"></div>						
					</div>
				  	
				  <div class="form-group">
						<label for=""><span class="required_info"  style="color:red;">*</span>Auto Topup for Referee</label>
						<input type="text" name="toRefree" id="toRefree"  class="form-control" placeholder="Enter Topup for Referee" required    onkeypress="return isNumberKey2(event)"  value="<?php echo $results->Refree_topup;?>" data-error="Please Enter Auto Topup for Referee" />	

					<div class="help-block form-text with-errors form-control-feedback"></div>						
					</div>
				  
				  
				  
					
					
					
				  
				  
				  
				  
				
				</div>
					<div class="col-sm-6">	
						
					<div class="form-group">
						<label for="">
							<span class="required_info" style="color:red;">*</span> Valid From <span class="required_info" >(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="from_date" id="datepicker1" class="single-daterange form-control" placeholder="Rule Start Date"  required="required"  data-error="Please Select Rule Start Date"   value="<?php echo date("m/d/Y",strtotime($results->From_date));?>" />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="">
							<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" style="color:red;font-size:10px;">(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="to_date" id="datepicker2" class="single-daterange form-control" placeholder="Rule End Date" required="required"  data-error="Please Select Rule End Date"  value="<?php echo date("m/d/Y",strtotime($results->Till_date));?>"/>			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
							
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
					</div>
						
					</div>
					
			  </div>
			  <input type="hidden" name="refid" class="form-control"  value="<?php echo $results->refid;?>"/>
				  <div class="form-buttons-w"   align="center">
					<button class="btn btn-primary" name="submit" value="Register"  id="Register"  type="submit">Submit</button>
				  </div>
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>
	<?php echo form_close(); ?>		 
	<!--------------Table------------->
	
		<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Referral Rules
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
						<tr>
							<th>Action</th>
							<th>Merchant Name</th>
							<th>Rule For</th>
							<th colspan="2">Validity Of Transaction</th>
							<th>Member Topup</th>
							<th colspan="2">Referee Topup</th>

						</tr>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th>From Date</th>
							<th>Till Date</th>
							<th> </th>
							<th></th>
						</tr>
						</thead>
						
						<tbody>
						<?php
						if($results2 != NULL)
						{
							$todays=date("Y-m-d");
							foreach($results2 as $row)
							{
								if($row->Referral_rule_for==1)
								{
									$Referral_rule_for="Enrollment";
									$Customer_topup=$row->Customer_topup;
								}
								else
								{
									$Referral_rule_for="Transaction";
									$Customer_topup="-";
								}
								
								if( ($todays >= $row->From_date) && ($todays <= $row->Till_date) )
									{
										$class = 'style="color:#00b300;"';
									}
									else
									{
										$class = "";
									}
									
								
							?>
								<tr  <?php echo $class; ?>>
									<td class="text-center">
										<a href="<?php echo base_url()?>index.php/Administration/edit_referral_rule/?refid=<?php echo $row->refid;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										|
										<!--<a href="<?php echo base_url()?>index.php/Administration/delete_referral_rule/?refid=<?php echo $row->refid;?>" title="Delete">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</a>-->
										<a href="javascript:void(0);" onclick="delete_referral_rule('<?php echo $row->refid;?>','<?php echo $row->First_name; ?>');" title="Delete">
									<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									<td><?php echo $row->First_name." ".$row->Last_name;?></td>
									<td><?php echo $Referral_rule_for;?></td>
									<td><?php echo $row->From_date;?></td>
									<td><?php echo $row->Till_date;?></td>
									<td class="text-center"><?php echo $Customer_topup;?></td>
									<td class="text-center"><?php echo $row->Refree_topup;?></td>
									
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
	</div>
	
	
	
	
	
	
	
	<!--------------Table--------------->
</div>			
<?php $this->load->view('header/footer'); ?>

<script>
$('#Register').click(function()
{
	if( $('#seller_id').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" && $('#toRefree').val() != "" )
	{
		var radioVAL = $("input[name=new_referral_rule_for]:checked").val()//$('#select_cust').val();
			
			var tonewcust = $('#tonewcust').val();
			  // alert(radioVAL);
			// alert(tonewcust);  
			if( (radioVAL == "1") && (tonewcust !="") )
			{
				show_loader();
			}
			
			
			 if( radioVAL == 2)
			{
				show_loader();
			} 
	}
});
</script>
<script type="text/javascript">
	
/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
});
	function delete_referral_rule(refid,First_name)
{	
	var url = '<?php echo base_url()?>index.php/Administration/delete_referral_rule/?refid='+refid;
	window.location = url;
	return true;
/* 	BootstrapDialog.confirm("Are you sure to Delete the Referral rule for '"+First_name+"' ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_referral_rule/?refid='+refid;
		if (result == true)
		{
			show_loader();
			window.location = url;
			return true;
		}
		else
		{
			return false;
		}
	}); */
}
/******calender *********/

	
</script>
<script>

			function showhide(custid)
			{
				if(custid==2)
				{ 
					$("#tonewcust").removeAttr("required");
					document.getElementById("cust").style.display="none";
				}
				else
				{
					$("#tonewcust").attr("required","required");
					
					document.getElementById("cust").style.display="";
				}
			}
			/*******************Phone No. Validation******************/
			function isNumberKey2(evt)
			{
			  var charCode = (evt.which) ? evt.which : event.keyCode
			 
			  if (charCode == 46 || charCode > 31 
				&& (charCode < 48 || charCode > 57))
				 return false;

			  return true;
			}
			
			
</script>
