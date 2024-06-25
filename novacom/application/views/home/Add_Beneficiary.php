 <?php $this->load->view('header/header');?>
        <!-- Content Header (Page header) -->
		<?php echo form_open_multipart('Beneficiary/Add_Beneficiary');	?>
        <section class="content-header">
          <h1>
            Add Beneficiary
          </h1>
         
        </section>

			<?php
			if(@$this->session->flashdata('success'))
			{
				?>
				<script>
					var Title = "Application Information";
					var msg = '<?php echo $this->session->flashdata('success'); ?>';
					runjs(Title,msg);
				</script>
				<?php
			}
			?>
			<?php 
			
			
			if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
				<script>
						BootstrapDialog.show({
						closable: false,
						title:'Application Information',
						message:'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
						buttons:[{
							label: 'OK',
							action: function(dialog) {
								window.location='<?php echo base_url()?>index.php/Cust_home/home';
							}
						}]
					});
					runjs(Title,msg);
				</script>
			<?php } ?>
        <!-- Main content -->
        <section class="content">
        <div class="row">
			
			<div class="login-box">
			  <div class="login-box-body">
				<p class="login-box-msg"> </p>
				<form action="#" method="post">
				 <div class="form-group has-feedback">
					<label for="exampleInputEmail1"> Select Publisher Category</label>
					<select class="form-control" name="Publishers_Category" id="Publishers_Category"  onchange="Get_category_publisher(this.value)" required >
						<option value="">Select</option>
						<?php 
						foreach($Publishers_Category as $Pcategory)
						{								
						?>
							<option value="<?php echo $Pcategory->Code_decode_id; ?>" ><?php echo $Pcategory->Code_decode; ?></option>
						<?php							
						}
						?>
					</select>
					<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>						
					<div class="help-block"></div>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1"> Select Publisher  Company</label>
					<select class="form-control" name="Beneficiary_company_id" id="Beneficiary_company_id" required >
						<option value="">Select Publisher Category</option>
						<?php 
						/* foreach($Get_Beneficiary_Company as $rec)
						{								
						?>
							<option value="<?php echo $rec->Register_beneficiary_id.'*'.$rec->Igain_company_id; ?>" ><?php echo $rec->Beneficiary_company_name; ?></option>
						<?php							
						} */
						?>
					</select>
				</div>
				<div class="form-group">
						<label for="exampleInputEmail1"> Beneficiary Name</label>
						<input type="text" name="Beneficiary_name" id="Beneficiary_name" class="form-control" placeholder="Enter Beneficiary Name" required/>						
						
				</div>
				<div class="form-group">
						<label for="exampleInputEmail1"> Beneficiary Identifier ID <span style="font-size: 10px; font-style: italic; color: red;"><br>(eg.Membership ID,Account No.,Customer ID etc.)</span></label>
						<input type="text" name="Beneficiary_membership_id" id="Beneficiary_membership_id" class="form-control" placeholder="Enter Beneficiary Identifier ID" required/>						
				</div>
				 
				  <div class="row">
					
					<div class="col-xs-12">
						<button type="submit" id="submit" class="btn btn-primary btn-block btn-flat" >Add Beneficiary</button>
						<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
					
					</div><!-- /.col -->
				  </div>
				</form>


			  </div><!-- /.login-box-body -->
			</div><!-- /.login-box -->
			
         </div><!-- /.row -->
		<?php echo form_close(); ?>
        </section><!-- /.content -->
		
	<div class="box box-info">
		<div class="box-header with-border">
		  <h3 class="box-title">Added Beneficiary</h3>                 
		</div>
				
		<div class="box-body">
			<div class="table-responsive">
				
				<table class="table table-bordered">
				<thead>
				<tr> 
				
							<th>Beneficiary Company Name</th>
							<th>Beneficiary Name</th>
							<th>Beneficiary Membership ID</th>
							<th>Beneficiary Status</th>
							<th>Action</th>
							
					
				</tr>					
				</thead>				
				<tbody>					 
					<?php 
					if($Get_Beneficiary_members != "")
					{
						foreach($Get_Beneficiary_members as $Rec2)
						{
							if($Rec2->Beneficiary_status==0)
							{
								$Beneficiary_status='<span class="label label-success" style="background-color: orange !important;">Pending</span>';
							}
							if($Rec2->Beneficiary_status==1)
							{
								$Beneficiary_status='<span class="label label-success">Approved</span>';
							}
							if($Rec2->Beneficiary_status==2)
							{
								$Beneficiary_status='<span class="label label-success"  style="background-color: red !important;">Not Approved</span>';
							}							
							?>
									<tr>							  
										<td><?php echo $Rec2->Beneficiary_company_name; ?></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Rec2->Beneficiary_name; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Rec2->Beneficiary_membership_id; ?></div></td>
										<td><?php echo $Beneficiary_status; ?></td>
										<td><a href="javascript:void(0);" onclick="remove_beneficiary(<?php echo $Rec2->Beneficiary_account_id; ?>,'<?php echo $Rec2->Beneficiary_name; ?>');"><span class="label label-success"  style="background-color: grey !important;">Remove</span></a></td>
																  
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
		<?php $this->load->view('header/loader');?> 
      <?php $this->load->view('header/footer');?>	  
	<script>
	
	$('#submit').click(function()
	{	
		  
			if($('#Beneficiary_company_id').val()!="" && $('#Beneficiary_name').val()!="" && $('#Beneficiary_membership_id').val()!="" )
			{
				show_loader();
			}
		
	});	
	function remove_beneficiary(Beneficiary_account_id,Beneficiary_name)
	{
		var url = '<?php echo base_url()?>index.php/Beneficiary/Delete_Beneficiary_account/?Beneficiary_account_id='+Beneficiary_account_id;
		BootstrapDialog.confirm("Are you sure to Remove Beneficiary Person '"+Beneficiary_name+"' ?", function(result) 
		{
		
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
		});
	}
	
	function Get_category_publisher(CategoryID){
		
		var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
		var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
			
			
				if( CategoryID == "" )
				{
					has_error(".has-feedback","#glyphicon",".help-block","Please Select Publisher Category.");
				}
				else
				{
					$.ajax({
						type: "POST",
						data: {Company_id:Company_id,Enrollment_id: Enrollment_id,CategoryID:CategoryID},
						url: "<?php echo base_url()?>index.php/Beneficiary/Get_category_publisher",
						success: function(data)
						{
							// alert(data.CategoryPublisher);
							if(data == 0)
							{
								$("#Publishers_Category").val("");
								has_error(".has-feedback","#glyphicon",".help-block"," In-valid Publisher Category.");
							}
							else
							{
								$('#Beneficiary_company_id').html(data.CategoryPublisher);
								//has_success(".has-feedback","#glyphicon",".help-block",data);
							}
						}
					});
				}
		
	
		
		
	}
	
	</script>
