<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   OFFER RULE
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
					<?php 	} ?>
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open('Administration/update_offer_rule',$attributes); ?>	
				<div class="row">
		  <div class="col-sm-6">
				  <div class="form-group">
					<label for="">Company Name</label>
					<select class="form-control" name="Company_id"  required="required">
						<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option> 
					</select>
				  </div>  
				  
				  <div class="form-group" id="offernm_feedback">
						<label for=""><span class="required_info">*</span> Offer Name</label>
						<input type="text" required="required" name="Offer_name" id="Offer_name" class="form-control" placeholder="Enter Offer Name" value="<?php echo $results->Offer_name; ?>"   data-error="Please Enter Offer Name" />	
							<div class="help-block form-text with-errors form-control-feedback" id="Offer_name2" ></div>			
					</div>
				  
				  <div class="form-group">
						<label for=""><span class="required_info">*</span>Business/Merchant Name</label>
						<select class="form-control" name="seller_id" ID="seller_id" required>

							<?php
							
							/* for artCafe to link product groups to link sellers **sandeep**13-03-2020***/
							
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
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="panel-group">
						<div class="panel panel-default">
						  <div class="panel-header">
								<b>BUY</b>
						  </div>
						  
						  <div class="form-group">
								<label for=""><span class="required_info">*</span> Select Buy Category </label>
								
								<select name="Menu_group_id" id="Menu_group_id" class="form-control"  required>
								<option value="<?php echo $Buy_item_category->Merchandize_category_id; ?>"><?php echo $Buy_item_category->Merchandize_category_name; ?></option>
								
								<?php
								
									/* foreach($MenuGrpArray as $cat)
									{
										echo "<option value='".$cat['Merchandize_category_id']."'>".$cat['Merchandize_category_name']."</option>";
									} */
								?>
								
								
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
					
						  <div class="form-group">
								<label for=""> Select Item Name</label>
								<select class="form-control" name="Company_merchandise_item_id" id="Company_merchandise_item_id">
							
								<?php
								
								echo "<option selected value='".$results->Company_merchandise_item_id."'>".$results->Merchandize_item_name."</option>";
								
									/* foreach($Buy_items_list as $item)
									{
										if( $item->Company_merchandise_item_id == $results->Company_merchandise_item_id)
										{
										echo "<option selected value='".$item->Company_merchandise_item_id."'>".$item->Merchandize_item_name."</option>";
										}
										else
										{
										echo "<option value='".$item->Company_merchandise_item_id."'>".$item->Merchandize_item_name."</option>";
										}
									} */
								?>
								
								</select>							
							</div>
							
								<div class="form-group" >
								<label for=""><span class="required_info">*</span> Buy Item Quantity</label>
								<select class="form-control" name="Buy_item" required="required">
									<option value="<?php echo $results->Buy_item; ?>"><?php echo $results->Buy_item; ?></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>							
							</div>
						  </div>
						</div>
					</div>
					
				  
				    <div class="col-sm-6">
					
					
						  <div class="form-group">
								<label for="">
									<span class="required_info" style="color:red;">*</span> Valid From <span class="required_info" style="color:red;">(click inside textbox)</span>
								</label>
								<div class="input-group">
									<input type="text" name="start_date" id="datepicker1" class="single-daterange form-control" placeholder="Rule Start Date" required="required" value="<?php echo date('m/d/Y',strtotime($results->From_date)) ?>" />			
									<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
								</div>
							</div>
							
							<div class="form-group">
								<label for="">
									<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" style="color:red;">(click inside textbox)</span>
								</label>
								<div class="input-group">
									<input type="text" name="end_date" id="datepicker2" class="single-daterange form-control" placeholder="Rule End Date" required="required"  value="<?php echo date('m/d/Y',strtotime($results->Till_date)) ?>"/>			
									<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
								</div>
							</div>
							
							<div class="form-group" >
								<label for=""> <span class="required_info">*</span> Offer Enable  </label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="form-check-label">
									<input type="radio" class="form-check-input"  name="Offer_status" id="Offer_status"  value="1" required="required" <?php if($results->Active_flag == '1') {  echo 'checked'; } ?> >Yes</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="form-check-label">
										<input type="radio" class="form-check-input"   name="Offer_status"  id="Offer_status" value="0" required="required" <?php if($results->Active_flag == '0') {  echo 'checked'; } ?> >No
									</label>
							
							</div>	
						
							<div class="panel-group mt-5">
								<div class="panel panel-default">
								  <div class="panel-header">
										<b>GET OFFER</b>
								  </div>
								  
								  <div class="form-group">
										<label for=""><span class="required_info">*</span> Select Free Category </label>
										
										<select name="Free_Menu_group_id" id="Free_Menu_group_id" class="form-control"  required>
										
										<option value="<?php echo $Free_item_category->Merchandize_category_id; ?>"><?php echo $Free_item_category->Merchandize_category_name; ?></option>
										<?php
								
											/* foreach($FreeMenuGrpArray as $cat)
											{
												echo "<option value='".$cat['Merchandize_category_id']."'>".$cat['Merchandize_category_name']."</option>";
											} */
 										?>
										</select>
									</div>
									
								  <div class="panel-body">
										
									
										<div class="form-group" id="Free_item_name_Div" style="display:block">
												<label for=""><span class="required_info">*</span> Select Free Item Name</label>
												<select class="form-control" name="Free_item_id" id="Free_item_id">
												<?php
												
													echo "<option  value='".$offers_item_name->Company_merchandise_item_id."'>".$offers_item_name->Merchandize_item_name."</option>";
													
													/* foreach($Free_items_list as $item)
													{
														if( $item->Company_merchandise_item_id == $offers_item_name->Company_merchandise_item_id)
														{
														echo "<option selected value='".$item->Company_merchandise_item_id."'>".$item->Merchandize_item_name."</option>";
														}
														else
														{
														echo "<option value='".$item->Company_merchandise_item_id."'>".$item->Merchandize_item_name."</option>";
														}
													} */
												
												?>
												</select>							
										</div>
										
										<div class="form-group" id="Free_item_Div" style="display:block">							
										<label for=""><span class="required_info">*</span> Free Item Quantity</label>
										<select class="form-control" name="Free_item"  required="required">
											<option value="<?php echo $results->Free_item; ?>"><?php echo $results->Free_item; ?></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
										</select>							
										</div>
										
									</div>
								</div>
							</div>
							
					
					</div>
					
				</div>	
					
					
				  
				  
				  <div class="form-buttons-w"  align="center">
				  <input type="hidden" name="Offer_id" value="<?php echo $results->Offer_id; ?>"/>	
					<input type="hidden" name="Company_id" value="<?php echo $results->Company_id; ?>"/>	
			
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>


	<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			  Offer Rules
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Offer Name</th>
							<th class="text-center">Category</th>
							<th class="text-center">Item Name</th>
							<th class="text-center">Buy item Quantity</th>
							<th class="text-center">Free item Quantity</th>
							<th class="text-center">Free item Name </th>
							<th>From Date</th>
							<th>Till Date</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
						if($results2 != NULL)
						{
							$todays=date("Y-m-d");
							foreach($results2 as $row)
							{
									if( ($todays >= $row->From_date) && ($todays <= $row->Till_date) )
									{
										$class = 'style="color:#00b300;"';
									}
									else
									{
										$class = "";
									}
									$ci_object = &get_instance();
									$ci_object->load->model('administration/Administration_model');
									$Get_item_name = $ci_object->Administration_model->get_offer_item_name($row->Free_item_id,$row->Company_id);
									$free_item_name=$Get_item_name->Merchandize_item_name;
							?>
								<tr>
									<td  class="row-actions">
										<a href="<?php echo base_url()?>index.php/Administration/edit_offer_rule/?offer_id=<?php echo $row->Offer_id;?>" title="Edit">
											<i class="os-icon os-icon-ui-49"></i>
										</a>
										
										<a href="javascript:void(0);"  class="danger"    onclick="delete_me('<?php echo $row->Offer_id;?>','<?php echo $row->Offer_name;?>','','Administration/delete_offer_rule/?offer_id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
											<i class="os-icon os-icon-ui-15"></i>
										</a>
									</td>
									<!--<td class="text-center"><?php echo $row->First_name." ".$row->Last_name;?></td>-->
									<td><?php echo $row->Offer_name;?></td>
									<td><?php echo $row->Merchandize_category_name;?></td>
									<td><?php echo $row->Merchandize_item_name;?></td>
									<td><?php echo $row->Buy_item;?></td>
									<td><?php echo $row->Free_item;?></td>
									<td><?php echo $free_item_name;?></td>
									<td <?php echo $class; ?>><?php echo date("Y-m-d",strtotime($row->From_date))?></td>
									<td <?php echo $class; ?>><?php echo date("Y-m-d",strtotime($row->Till_date));?></td>

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
/******calender *********/


$('#Menu_group_id').change(function()
{
	if( $("#Menu_group_id").val()  == "" )
	{
		has_error(".has-feedback","#glyphicon2","#help-block2","Please select category..!!");
	}
	else
	{
		var Menu_group_id = $("#Menu_group_id").val();
		var Company_id ='<?php echo $Company_id; ?>';
		$.ajax({
			type:"POST",
			data:{Cateygo_id:Menu_group_id,Company_id:Company_id,StampFlag:1},
			url:"<?php echo base_url()?>index.php/Administration/get_offer_item",
			success: function(data)
			{
				$('#Company_merchandise_item_id').html(data);
			}
		});
	}
});

$('#Free_Menu_group_id').change(function()
{
	if( $("#Free_Menu_group_id").val()  == "" )
	{
		has_error(".has-feedback","#glyphicon2","#help-block2","Please select category..!!");
	}
	else
	{
		var Menu_group_id = $("#Free_Menu_group_id").val();
		var Company_id ='<?php echo $Company_id; ?>';
		$.ajax({
			type:"POST",
			data:{Cateygo_id:Menu_group_id,Company_id:Company_id,StampFlag:1},
			url:"<?php echo base_url()?>index.php/Administration/get_offer_item",
			success: function(data)
			{
				$('#Free_item_id').html(data);
			}
		});
	}
});


$('#Offer_name').blur(function()
{
	if( $("#Offer_name").val()  == "" )
	{
		$("#Offer_name2").html("Please Enter Offer Name");
	}
	else
	{
		var Offername = $("#Offer_name").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			  type: "POST",
			  data: {Offer_name: Offername, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/Administration/check_offer_name",
			  success: function(data)
			  {
				 //alert(data.length);
				if(data == 0)
				{
					$('#Offer_name').val('');
					$("#Offer_name2").html("Already exist");
					$("#Offer_name").addClass("form-control has-error");
				}
				else
				{
					$("#Offer_name2").html("");
					$("#Offer_name").removeClass("has-error");
				}
				
					
			  }
		});
	}
});

	//******* sandeep **20-03-2020***************
	$('#seller_id').change(function()
	{
		var seller_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id,StampFlag:1},
			url:'<?php echo base_url()?>index.php/Administration/get_seller_menu_groups',
			success:function(opData2){
				$('#Menu_group_id').html(opData2);
				//$('#Main_or_side_item_code0').html(opData2);

			}
		});
			
	});
	
	$('#seller_id').change(function()
	{
		var seller_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id,StampFlag:0},
			url:'<?php echo base_url()?>index.php/Administration/get_seller_menu_groups',
			success:function(opData2){
				$('#Free_Menu_group_id').html(opData2);
				
			}
		});
			
	});
	
	//******* sandeep ******20-03-2020***********
		
		
function delete_offer_rule(rule_id)
{	
	BootstrapDialog.confirm("Are you sure to Delete the Offer Rule?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_offer_rule/?offer_id='+rule_id;	
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
	
</script>
