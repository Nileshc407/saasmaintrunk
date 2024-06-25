<?php $this->load->view('header/header'); 
$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag'];
?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-8">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   PROMO CAMPAIGN
			  </h6>
			  <div class="element-box">
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
							
					<?php 	} 
					
		if($results5 != NULL)
			{
				foreach($results5 as $row5)
				{
					$promo_cmp_name = $row5->Pomo_campaign_name;
					$promo_cmp_desc = $row5->Campaign_description;
					$promo_cmp_From_date = $row5->From_date;
					$promo_cmp_To_date = $row5->To_date;
				}
			}
			else
			{
				$promo_cmp_name = "";
				$promo_cmp_desc = "";
				$promo_cmp_From_date = "";
				$promo_cmp_To_date = "";
			}
		?>	
				<?php  $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Administration/create_promo_campaign',$attributes); ?>	
				
				  <div class="form-group">
					<label for="">Campaign Name</label>
					<input type="text" id="CMPName" name="CMPName" class="form-control" placeholder="Campaign Name"  data-error="Please Enter Campaign Name"    required="required" 
							value="<?php if($results5 != NULL){ echo $results5[0]->Pomo_campaign_name; } ?>" />	
						<div class="help-block form-text with-errors form-control-feedback" id="campaign"></div>
				  </div> 
				  <div class="form-group">
						<label for="exampleInputEmail1">Campaign Description</label>
						<?php if($results5 != NULL)
						{
							
						?>
							<textarea class="form-control" rows="5" name="CMPdescription" id="CMPdescription" placeholder="Campaign Description"><?php echo trim($results5[0]->Campaign_description); ?></textarea>
						<?php }else{
							
						?>
							<textarea class="form-control" rows="5" name="CMPdescription" id="CMPdescription" placeholder="Campaign Description"></textarea>
						<?php
						}
						?>
					</div>
					<div class="form-group">
						<label for="">
							<span class="required_info">*</span> Valid From <span class="required_info">(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="start_date" id="datepicker1" class="single-daterange form-control" placeholder="Campaign Start Date" required  value="<?php if($results5 != NULL){ echo date("m/d/Y",strtotime($results5[0]->From_date)); } ?>"  />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="">
							<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" >(click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="end_date" id="datepicker2" class="single-daterange form-control" placeholder="Campaign End Date" required  value="<?php if($results5 != NULL){ echo date("m/d/Y",strtotime($results5[0]->To_date)); } ?>"  />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
				    <div class="form-group">
						<label for="">Upload Promo Code File <span class="required_info"> (.CSV and .Xls Only.) </span></label>
						<br>
						<span class="required_info" style="color:red;font-size:10px;">(Note - File Structure:- Column 1:Points and Column 2:Promo Codes.)</span>
						<br>	
						<div class="upload-btn-wrapper">
							<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
							<input type="file" name="file" id="file" onchange="readURL(this);"/>
						</div>
						<!--<img id="blah" src="<?php echo base_url(); ?>images/excel.png" class="img-responsive left-block" style="display:none" />-->
					</div>
				  <?php if($results5 == NULL){ ?>
				  <div class="form-buttons-w">
					<button class="btn btn-primary" name="Upload" id="Register"  type="submit">Proceed</button>
				  </div>
				  <?php } ?>
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>
	<!--------------Table------------->
	<?php 
		if($results3 != NULL)
		{
	?>
		<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Promo Campaign Details
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
						<tr>
							<!--<th>Action</th>-->
							<th>Campaign Name</th>
							<th>Valid From</th>
							<th>Valid Till</th>
							<th>File Name</th>
						</tr>
						</thead>
						
						<tbody>
						<?php
						if($results3 != NULL)
						{
							
							foreach($results3 as $row3)
							{
								
							?>
								<tr>
									<!--<td class="text-center">
										<a href="<?php echo base_url()?>index.php/Administration/delete_promo_campaign/?Campaign_id=<?php echo $row3->Campaign_id;?>&CompID=<?php echo $row3->Company_id;?>&FileName=<?php echo $row3->File_name;?>&flag=1" title="Delete">
											<i class="os-icon os-icon-ui-49"></i>
										</a>-->
								
								<td><?php echo $row3->Pomo_campaign_name;?></td>
									
									<?php 
										$todays=date("Y-m-d");
										
										if(($todays >= $row3->From_date) && ($todays <= $row3->To_date))
										{
											echo "<td style='color:green'>".$row3->From_date."</td>";
											echo "<td style='color:green'>".$row3->To_date."</td>";
										}
										else
										{
											echo "<td>".$row3->From_date."</td>";	
											echo "<td>".$row3->To_date."</td>";	
										}
									?>

									<td><?php echo $row3->File_name;?></td>
									
								</tr>
							<?php
							}
						}
						?>
						</tbody> 
					</table>
				</div>
				<?php if($_SESSION['Privileges_Add_flag']==1){ ?>
				<div class="form-buttons-w">
					<button class="btn btn-primary" name="Submit" id="submit" value="Submit" type="submit">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>	
	<?php echo form_close(); ?>	
	<?php if($_SESSION['Privileges_View_flag']==1){ ?>
		<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Promo Campaign
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
						<tr>
							<th>Action</th>
							<th>Campaign Name</th>
							<th>From Date</th>
							<th>Till Date</th>
							<th>File Name</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if($results2 != NULL)
						{
							$todays=date("Y-m-d");
							foreach($results2 as $row)
							{
								if( ($todays >= $row->From_date) && ($todays <= $row->To_date) )
								{
									$class = 'style="color:#00b300;"';
								}
								else
								{
									$class = "";
								}
							?>
								<tr>
									<td class="row-actions">
										<?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
											<a href="javascript:void(0);"  onclick="promo_file_details('<?php echo $row->Campaign_id;?>','<?php echo $row->Company_id;?>','<?php echo $row->File_name;?>','2');" id="details2">

												<abbr title="View Promo Code Details">
													<i class="os-icon os-icon-ui-49"></i>
												</abbr>
											</a>
										<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>	
										<a  href="javascript:void(0);"  class="danger"  onclick="delete_me('<?php echo $row->Campaign_id;?>','<?php echo $row->Pomo_campaign_name;?>','','Administration/delete_promo_campaign/?Campaign_id');"  title="Delete"  data-target="#deleteModal" data-toggle="modal" >
											<i class="os-icon os-icon-ui-15"></i>
										</a>
										<?php } ?>
									</td>
									<td><?php echo $row->Pomo_campaign_name;?></td>
									<td <?php echo $class; ?>><?php echo $row->From_date;?></td>
									<td <?php echo $class; ?>><?php echo $row->To_date;?></td>
									<td><?php echo $row->File_name;?></td>
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
	<?php } ?>
	<!--------------Table--------------->
<!-- Modal -->
<style>
/* Important part */
/*
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 500px;
    overflow-y: auto;
}*/
</style>	
</div>		
	<!-- Modal -->
		<div id="detail_myModal" class="modal fade" role="dialog">
			<div class="modal-dialog" >
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<button aria-label="Close"  id="close_modal3"  class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
				<!--<h5 class="modal-title text-center">Promo Codes</h5>-->
			</div>
					<div class="modal-body" style="width: 100%;margin-top:150px;overflow-y: scroll;height:550px;">
						<div  id="show_promo_file_details" ></div>
					</div>
					<div class="modal-footer">
				<button type="button" id="close_modal" class="btn btn-primary">Close</button>
			</div>
				</div>

			</div>
		</div>	
<?php $this->load->view('header/footer'); ?>
<script>
	$( "#close_modal3" ).click(function(e)
	{
		$('#detail_myModal').hide();
		$("#detail_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
$('#Register').click(function()
{
	if( $('#CMPName').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" )
	{
		show_loader();
	}
});
$('#submit').click(function()
{
	
		show_loader();
	
});
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
					.css('display','inline')
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script type="text/javascript">	
$('#CMPName').blur(function()
{	
	var Company_id = '<?php echo $Company_id; ?>';
	var cmp_name = $('#CMPName').val();
	
	if( $("#CMPName").val() == "" )
	{
		has_error(".has-feedback","#glyphicon",".help-block","Please Enter Valid Campaign Name..!!");
	}
	else
	{
		$.ajax({
			type: "POST",
			data: {cmp_name: cmp_name, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Administration/check_campaign_name",
			success: function(data)
			{
				if(data == 0)
				{
					$("#CMPName").val("");
					// has_error(".has-feedback","#glyphicon",".help-block","Campaign Name not Available..!!");
					$("#campaign").html("Already exist");
					$("#CMPName").addClass("form-control has-error");
				}
				else
				{
					// has_success(".has-feedback","#glyphicon",".help-block",data);
					$("#campaign").html("");
					$("#CMPName").removeClass("has-error");
				}
			}
		});
	}
});
/******calender *********/
$("#datepicker1").datepicker({
  minDate: 0,
  yearRange: "-80:+2",
  changeMonth: true,
  changeYear: true,
  onSelect: function(date) {
    $("#datepicker1").datepicker('option', 'minDate', date);
  }
});
$("#datepicker2").datepicker({
	
	 minDate: 0,
  yearRange: "-80:+2",
  changeMonth: true,
  changeYear: true,
	onSelect: function(date) {
    $("#datepicker2").datepicker('option', 'minDate', date);
	}
	
});
/******calender *********/
function promo_file_details(campaign_id,comp_id,file_name,flagval)
{
	$.ajax({
		type: "POST",
		data: {campaign_id: campaign_id, comp_id:comp_id, file_name:file_name, flagval:flagval},
		url: "<?php echo base_url()?>index.php/Administration/show_promo_file_details",
		success: function(data)
		{
			
			$("#show_promo_file_details").html(data.transactionDetailHtml);	
			$('#detail_myModal').show();
			$("#detail_myModal").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}

$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#detail_myModal').hide();
		$("#detail_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});


function delete_promo_campaign(cmp_id,comp_id,file_name,cmp_name)
{	
	var url = '<?php echo base_url()?>index.php/Administration/delete_promo_campaign/?Campaign_id='+cmp_id+'&CompID='+comp_id+'&FileName='+file_name+'&flag=2';
	window.location = url;
			return true;
	/* BootstrapDialog.confirm("Are you sure to Delete the Promo Campaign "+cmp_name+" ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_promo_campaign/?Campaign_id='+cmp_id+'&CompID='+comp_id+'&FileName='+file_name+'&flag=2';
		
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
</script>