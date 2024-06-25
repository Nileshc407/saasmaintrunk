<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			CREATE PRODUCT GROUP
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
					}
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} ?>
					
					
					<?php  $attributes = array('id' => 'formValidate');
						echo form_open('E_commerce/create_product_group',$attributes); ?>
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
						<label for=""><span class="required_info">* </span>Product Group Name </label>
						<input class="form-control" type="text" name="product_group_name" id="product_group_name" placeholder="Enter product group name" data-error="Please enter product group name" required="required">
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div> 
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
				</div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   Active Product Group
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Product Group ID</th>
								<th>Product Group Name</th>
								<th>Status</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Product Group ID</th>
								<th>Product Group Name</th>
								<th>Status</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results != NULL)
						{
							foreach($results as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/E_commerce/edit_product_group/?Product_group_id=<?php echo $row->Product_group_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
									
									<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Product_group_id;?>','<?php echo $row->Product_group_name; ?>','Product brands and Merchandise items linked to this product group will be made inactive','E_commerce/delete_product_group/?Product_group_id');" data-target="#deleteModal" data-toggle="modal"  title="Delete">
									<i class="os-icon os-icon-ui-15"></i></a>
								</td>
								<td><?php echo $row->Product_group_id;?></td>
								<td><?php echo $row->Product_group_name;?></td>
								<td>Active</td>
							</tr>
				<?php 		}
						}	?>
						</tbody>
					</table>
				  </div>
				</div>
			</div>
			<!--------------Table--------------->
			<!--------------Table------------->	 
	<?php   if($results1 != NULL)
			{ ?>
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				  In-Active Product Group
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Product Group ID</th>
								<th>Product Group Name</th>
								<th>Status</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Product Group ID</th>
								<th>Product Group Name</th>
								<th>Status</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						if($results1 != NULL)
						{
							foreach($results1 as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="javascript:void(0);" onclick="Active_me('<?php echo $row->Product_group_id;?>','<?php echo $row->Product_group_name; ?>','','E_commerce/Active_product_group/?Product_group_id');" data-target="#MakeActive" data-toggle="modal" title="Make-Active"><i class="fa fa-check-square-o"></i></a>
								</td>
								<td><?php echo $row->Product_group_id;?></td>
								<td><?php echo $row->Product_group_name;?></td>
								<td>In-Active</td>
							</tr>
				<?php 		}
						}	?> 
						</tbody>
					</table>
				  </div>
				</div>
			</div>
	  <?php } ?>
			<!--------------Table--------------->
		  </div>
		</div>
	</div>
</div>	
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show" id="MakeActive" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Confirmation
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="arg111" id="arg111" value=""/>
                <input type="hidden" name="arg222" id="arg222" value=""/>
                <input type="hidden" name="arg333" id="arg333" value=""/>
                <input type="hidden" name="argUrl11" id="argUrl11" value=""/>
                Are you sure to Activate the Product Group <b id="arg222"></b> ?<br><span id="arg333"></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="confirmed_active(arg111.value, arg222.value, arg333.value, argUrl11.value)">OK</button>
            </div>
        </div>
    </div>
</div>		
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	if( $('#product_group_name').val() != "" )
	{
		show_loader();
		return true;
	}
});

$('#product_group_name').blur(function()
{ 
	if( $("#product_group_name").val() != "" )
	{
		var product_group_name = $("#product_group_name").val();
		
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {productGroupName: product_group_name, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/E_commerce/Check_product_group_name",
			  success: function(data)
			  {
					if(data == 1)
					{
						$("#product_group_name").val("");
						var msg1 = 'Already exist';
						$('.help-block').show();
						$('.help-block').html(msg1);
						$("#product_group_name").addClass("form-control has-error");
						return false; 
					}
					else
					{
						$("#product_group_name").removeClass("has-error");
						$('.help-block').html("");
					}
			  }
		});
	}
	else
	{
		$("#product_group_name").val("");
		var msg1 = 'Please enter product group name';
		$('.help-block').show();
		$('.help-block').html(msg1);
		$("#product_group_name").addClass("form-control has-error");
		return false;
	}
});
function Active_me(arg1, arg2, arg3, argUrl) 
{
    $(".modal-body #arg111").val(arg1);
    $(".modal-body #arg111").html(arg1);

    $(".modal-body #arg222").val(arg2);
    $(".modal-body #arg222").html(arg2);


    $(".modal-body #arg333").val(arg3);
    $(".modal-body #arg333").html(arg3);

    $(".modal-body #argUrl11").val(argUrl);
}
function confirmed_active(arg1, arg2, arg3, argUrl) 
{
    if (argUrl)
    {
        var url = '<?php echo base_url(); ?>index.php/' + argUrl + '=' + arg1;
        $('#MakeActive').modal('hide');
        show_loader();
        setTimeout(function () {
            window.location = url;
        }, 3000)
        return true;
    } 
	else
    {
        return false;
    }
}
$(".alert").alert('close');
</script>