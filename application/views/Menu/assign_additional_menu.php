<?php 
$this->load->view('header/header');

$ci_object = &get_instance();
$ci_object->load->model('Menu/Menu_model');
?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   ASSIGN ADDITIONAL MENUS TO COMPANY
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
					echo form_open('Menu/assign_additional_menu',$attributes); ?>
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Select Company</label>
								<select class="form-control" name="Company_id" id="Company_id" required="required">
									<option value="">Select Company</option>
									
									<?php
									if($Companys != NULL)
									{
										foreach($Companys as $Company)
										{
										?>
										
										<option value="<?php echo $Company['Company_id'] ?>" id="<?php echo $Company['Company_License_type'] ?>" ><?php echo $Company['Company_name'] ?></option>
										
										<?php
										}
									}
									?>
									
								</select>								
							</div>		  		
						</div>		  		
					</div>
					
					<div class="row">
						<div class="col-sm-12" id="assignNew">
						
						<div class="d-flex flex-row flex-wrap">
						  <div class="p-2"><h6>Company Menus to be Assign</h6></div>
						</div>
 
						  <div class="element-wrapper">                
							<div class="element-box">                 
								<div class="table-responsive" id="assigned_menus">
								
								</div>	
								<div class="form-buttons-w" align="center">
								<button type="submit" name="submit" value="Assign_Menus" id="Assign_Menus" class="btn btn-primary">Submit</button>
								</div>
								  
							</div>
						  </div>
						</div>
						<!--
						<div class="col-sm-12" id="assigned">
							<h6>Assigned Company Menus</h6>
						   <div class="element-wrapper">                
							<div class="element-box">                 
							  <div class="table-responsive" id="delete_menus">
								
							  </div>
								<div class="form-buttons-w" align="center">
									<button type="submit" name="submit" value="Delete_Menus" id="Delete_Menus" class="btn btn-primary">Delete Menus</button>
									
									<a href="#assignNew">assign more menus <i class="os-icon os-icon-arrow-up5"></i></a>
								</div>
							</div>
							</div>
						</div> -->
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>	
			 
		  </div>
		</div>
	</div>
</div>			
<?php $this->load->view('header/footer'); ?>
<script>
$('#Assign_Menus').click(function()
{
	if( $('#Company_id').val() != "" )
	{
		show_loader();
	}
});

$('#Delete_Menus').click(function()
{
	if( $('#Company_id').val() != "" )
	{
		show_loader();
	}
});

$(document).ready(function() 
{	
	$('#Company_id').change(function()
	{
		var Company_id = $('#Company_id').val();
		var License_type = $('#Company_id').children(":selected").attr("id");
		$.ajax({
			type:"POST",
			data:{ Company_id:Company_id,License_type:License_type  },
			url: "<?php echo base_url()?>index.php/Menu/get_company_menus",
			success: function(data)
			{
				$('#assigned_menus').html(data);
			}				
		});
		
		 $.ajax({
			type:"POST",
			data:{ Company_id:Company_id },
			url: "<?php echo base_url()?>index.php/Menu/get_company_assigned_menus",
			success: function(data)
			{
				$('#delete_menus').html(data);
			}				
		}); 
	});	
	
	$("#checkAll2").attr("data-type", "check");
	$("#checkAll2").click(function() 
	{
		if ($("#checkAll2").attr("data-type") === "check") 
		{
			$(".checkbox2").prop("checked", true);
			$("#checkAll2").attr("data-type", "uncheck");
		} 
		else 
		{
			$(".checkbox2").prop("checked", false);
			$("#checkAll2").attr("data-type", "check");
		}
	});
});
</script>
