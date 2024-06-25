<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   CREATE POS MENU GROUP
			  </h6>
			  <div class="element-box panel">
				  <div class="col-sm-8">
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						 <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			<?php 		
					} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} ?>
					<?php $attributes = array('id' => 'formValidate');
						echo form_open_multipart('CatalogueC/Create_Merchandize_Category',$attributes); ?>
					 <div class="form-group">
						<label for=""> Company Name</label>
						<select class="form-control" name="Company_id" id="Company_id" required>
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>
					  </div> 
					  
					  <div class="form-group">
						<label for="">Merchant Name</label>
						<select class="form-control" name="seller_id" ID="seller_id" >
							<option value="0">All Merchant</option>
							<?php
							
							/* for artCafe to link product groups to link sellers **sandeep**13-03-2020***/
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
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					   <div class="form-group">
						<label for=""><span class="required_info" style="color:red;">* </span>POS Menu Group Name </label>
						<input class="form-control" type="text" name="Merchandize_category_name" id="Merchandize_category_name" placeholder="Enter merchandize category name" data-error="Please enter merchandize category name" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div> 
					  
					  <div class="form-group">
						<label for=""> Parent Category</label>
						<select class="form-control" name="Parent_category_id" id="Parent_category_id"  required="required">
						<option value="0">Select parent category</option>
						 <?php foreach($Parent_category as $parent) {?>
							<option value="<?php echo $parent->Merchandize_category_id;?>"><?php echo $parent->Merchandize_category_name;?></option>
						<?php } ?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <input type="hidden" name="Create_user_id" value="<?php echo $enroll;?>">
					  <input type="hidden" name="Create_date" value="<?php echo date("Y-m-d H:i:s");?>">
						
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
						<input type="hidden" name="Company_id" value="<?php echo $Company_id; ?>" />
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
				</div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   POS Menu Groups
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Merchandize Category ID</th>
								<th>Parent Category</th>
								<th>Merchandize Category Name</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Merchandize Category ID</th>
								<th>Parent Category</th>
								<th>Merchandize Category Name</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($Merchandize_Category_Records != NULL)
						{
							foreach($Merchandize_Category_Records as $row)
							{
								$Parent_category=$this->Catelogue_model->Get_Merchandize_Category_details($row->Parent_category_id);
						?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/CatalogueC/Edit_Merchandize_Category/?Merchandize_category_id=<?php echo $row->Merchandize_category_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Merchandize_category_id;?>','<?php echo $row->Merchandize_category_name; ?>','Merchandise item linked to this category will be made inactive','CatalogueC/Delete_Merchandize_Category/?Merchandize_category_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
								
								</td>
								<td><?php echo $row->Merchandize_category_id;?></td>
								<td><?php echo $Parent_category->Merchandize_category_name;?></td>
								<td><?php echo $row->Merchandize_category_name;?></td>
							</tr>
				<?php 		}
						}	?>
						</tbody>
					</table>
				  </div>
				</div>
			</div>
			<!--------------Table--------------->
		  </div>
		</div>
	</div>
</div>			
<?php $this->load->view('header/footer'); ?>

<script>
$('#Register').click(function()
{
	if( $('#Company_id').val() != "" && $('#Merchandize_category_name').val() != "")
	{
		 show_loader();
		return true;
	}
});
/*function Merchandize_Category_inactive(Merchandize_category_id,Merchandize_category_name)
{	
	$.confirm({
		title: 'Category Inactive Confirmation',
		content: "Are you sure to Delete the Merchandize Category '"+Merchandize_category_name+"' ?<br><br>Please Note that Merchandise Item linked to this Category will be made inactive.",
		icon: 'fa fa-question-circle',
		animation: 'scale',
		closeAnimation: 'scale',
		opacity: 0.5,
		buttons: {
			'confirm': {
				text: 'OK',
				btnClass: 'btn-default',
				action: function () {
					
					$.ajax({
							type: "POST",
							data: {Merchandize_category_id: Merchandize_category_id},
							url: "<?php echo base_url()?>index.php/CatalogueC/Delete_Merchandize_Category",
							success: function(data)
							{
								$.MessageBox("Merchandise Category Deleted Successfuly!!");

								window.top.location.reload(); 
							}
							
						});
					
				}
			},
			cancel: function () {
			},
		}
	}); 
} */
function isNumberKey2(evt)
{
	
  var charCode = (evt.which) ? evt.which : event.keyCode
// alert(charCode);
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}
/*$('#Merchandize_category_name').blur(function()
{
	if( $("#Merchandize_category_name").val() == "" )
	{
		var msg = 'Please enter category name.';
		$('#help-block1').show();
		$('#help-block1').html(msg);
		$("#Merchandize_category_name").addClass("form-control has-error");
		// setTimeout(function(){ $('#help-block1').hide(); }, 3000);
		return false;
	}
	else
	{
		$("#Merchandize_category_name").removeClass("has-error");
		$("#help-block1").html("");
	}
}); */
$('#Merchandize_category_name').blur(function()
{ 
	if( $("#Merchandize_category_name").val() != "" )
	{
		var Merchandize_category_name = $("#Merchandize_category_name").val();
		
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {Merchandize_category_name: Merchandize_category_name, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/CatalogueC/Check_merchandize_category_name",
			  success: function(data)
			  {
					if(data == 1)
					{
						$("#Merchandize_category_name").val("");
						var msg1 = 'Already exist';
						$('#help-block1').show();
						$('#help-block1').html(msg1);
						$("#Merchandize_category_name").addClass("form-control has-error");
						return false; 
					}
					else
					{
						$("#Merchandize_category_name").removeClass("has-error");
						$('#help-block1').html("");
					}
			  }
		});
	}
	else
	{
		$("#Merchandize_category_name").val("");
		var msg1 = 'Please enter category name';
		$('#help-block1').show();
		$('#help-block1').html(msg1);
		$("#Merchandize_category_name").addClass("form-control has-error");
		return false;
	}
});
</script>