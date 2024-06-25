<?php $this->load->view('header/header'); ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   EDIT CODE DECODE TYPE
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
				<?php 	} 
				
				
				if($results2 != NULL)
				{
					foreach($results2 as $row2)
					{
						$Code_decode_type=$row2->Code_decode_type;
						$Code_decode_type_id=$row2->Code_decode_type_id;
					}
				}
			?>
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('Masterc/Update_CodeDecodeType',$attributes); ?>
				  <div class="col-sm-8">
				  <div class="form-group">
					<label for=""> <span class="required_info">* </span> Code Decode Type </label>								
					<input class="form-control"  name="Code_decode_type" id="Code_decode_type"  type="text"  placeholder="Enter Code Decode Type" required="required" data-error="Please enter code decode type" value="<?php echo $Code_decode_type; ?>">
					<div class="help-block form-text with-errors form-control-feedback" id="decode_err"></div>
				  </div> 
				  
				  
				  <div class="form-buttons-w">
				  <input type="hidden" name="Code_decode_type_id" value="<?php echo $Code_decode_type_id; ?>">
					<button class="btn btn-primary" id="Register" type="submit">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>		  
			  </div>
			</div>
			</div>
			
			<!-------------------- START - Data Table -------------------->
	           
		<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   List of Code Decode Types
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Id</th>
								<th>Code Decode Type</th>	
							</tr>
						</thead>	
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Id</th>
								<th>Code Decode Type</th>			
							</tr>
						</tfoot>		

						<tbody>
							<?php 
							if($results != NULL)
							{
							foreach($results as $row) { ?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Masterc/Edit_CodeDecodeType/?Code_decode_type_id=<?php echo $row->Code_decode_type_id;?>" title="Edit" >
										<i class="os-icon os-icon-ui-49"></i>
									</a>

								</td>
								<td><?php echo $row->Code_decode_type_id; ?></td>
								<td><?php echo $row->Code_decode_type; ?></td>
								
							</tr>
							<?php }
							}
							?>
						</tbody>
					</table>
				  </div>
				</div>
			  </div>
	
<!--------------------  END - Data Table  -------------------->

		  </div>
		</div>
	</div>
</div>			

<?php $this->load->view('header/footer'); ?>
<script type="text/javascript">
$('#Register').click(function()
{
	if(!document.querySelector("#Register").classList.contains('disabled')){
		show_loader();
	}
});


$('#Code_decode_type').blur(function()
	{
		var Codedecode_type = $("#Code_decode_type").val();
		
		if(Codedecode_type != "" || Codedecode_type != NULL)
		{
			//alert(Branch_code);
			$.ajax({
				  type: "POST",
				  data: {Code_decode_type: Codedecode_type,Decode_flag:1},
				  url: "<?php echo base_url()?>index.php/Masterc/check_codedecode_type",
				  success: function(data)
				  {
					  //alert(data.length);
						if(data == 1)
						{
							$('#Code_decode_type').val('');

							$("#Code_decode_type").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#decode_err').show();
							$('#decode_err').html(msg1);
							return false;
						}
						else
						{
							$('#decode_err').html("");
							$("#Code_decode_type").removeClass("has-error");	
						}
					
						
				  }
			});
		}
	});
</script>