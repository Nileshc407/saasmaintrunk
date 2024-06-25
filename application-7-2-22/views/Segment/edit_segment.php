<?php 
$this->load->view('header/header');
$todays = date("Y-m-d");

 ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   EDIT SEGMENT MASTER
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
				<?php $this->session->unset_userdata('success_code'); $this->session->unset_userdata('data_code');
				} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php $this->session->unset_userdata('error_code');
						$this->session->unset_userdata('data_code');
				} ?>

				<?php $attributes = array('id' => 'formValidate');
				echo form_open('SegmentC/update_segment',$attributes); ?>
					<div class="row">
					<div class="col-sm-6">	
						<div class="form-group">
						<label for=""> <span class="required_info">*</span> Segment Code </label>								
						<input class="form-control"  name="Segment_Code" id="Segment_Code"  type="text" placeholder="Enter Segment Code" value="<?php echo $segment_details->Segment_code ?>" readonly required="required" >
						
						</div> 
					</div>
					<div class="col-sm-6">	
					
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Segment Name </label>
						<input class="form-control"  name="Segment_name" id="Segment_name"  type="text" placeholder="Enter Segment Name" value="<?php echo $segment_details->Segment_name ?>" required="required" data-error="Please enter segment name" >
						<div class="help-block form-text with-errors form-control-feedback" id="Segment_name_err"></div>
						</div> 
						
					</div> 
				   </div> 
				   
				   <div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   Segment Combination Details
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Segment Code</th>
							<th class="text-center">Segment name</th>
							<th class="text-center">Segment Condition</th>
							</tr>
						</thead>			

						<tbody>
						<?php
								$todays = date("Y-m-d");
								$ci_object = &get_instance();
								$ci_object->load->model('Segment/Segment_model');								
								if($segment_edit_results != NULL)
								{
									$flag=0;
									foreach($segment_edit_results as $row)
									{		
										$Segment_type_id=$row->Segment_type_id;
										$lv_Segment_code=$row->Segment_code;	
										if( ($flag==0 && $Segment_type_id==13) || ($Segment_type_id!=13))//Item Category
										{
											
										if($row->Operator == 'Between' ) 
										{
											$segment=$row->Segment_type_name.' '.$row->Operator.' '.$row->Value1.' - '.$row->Value2;
										}
										else
										{
											if($Segment_type_id!=13)//Not Item Category
											{
												$segment=$row->Segment_type_name.' '.$row->Operator.' '.$row->Value;
											}
										}
											
										if($Segment_type_id==13)//Item Category
										{
											 $Get_linked_segment_items = $ci_object->Segment_model->Get_linked_items_segment_child($row->Company_id,$lv_Segment_code);
											/* foreach($Get_linked_segment_items as $row1)
											{
												$Segment_operation[]="".$row1->Merchandize_item_name."";
											}
											$segment=implode(" AND ",$Segment_operation);
											$flag=1; */
											if($Get_linked_segment_items != NULL)
											{
												$segment='<a href="javascript:Get_segment_linked_items_table('."'$lv_Segment_code'".');">Item Category</a>';
												$flag=1;
											} 
										}
										if($Segment_type_id==14)//Hobbies
										{
											$Get_hobbies = $ci_object->Segment_model->Get_linked_segment_hobbies($row->Value);
											if($Get_hobbies != NULL)
											{
												$segment=$row->Segment_type_name." ".$row->Operator." '".$Get_hobbies->Hobbies."'";
											}
										}
										
									?>
									<tr>
										<td class="row-actions">
											<a href="javascript:void(0);" onclick="delete_segment_id('<?php echo $row->Segment_id;?>','<?php echo $row->Segment_code;?>','<?php if($Segment_type_id!=13 && $Segment_type_id!=14){echo $segment; }else{ echo 'Segment';}?>','<?php echo $row->Company_id;?>');" class="danger" title="Delete">
												<i class="os-icon os-icon-ui-15"></i>
											</a>
										</td>
										<td><?php echo $row->Segment_code;?></td>
										<td><?php echo $row->Segment_name;?></td>
										
										<td><?php echo $segment;  ?></td>
										
						
									</tr>
									<?php
									}
									}
								}
								?>				
					</tbody> 
					</table>
				  </div>
				</div>
			  </div>
			  <div class="col-md-12"  id="selected_items"  style="display:none;">
								<div class="panel panel-default">
											<div class="panel-heading">
												<legend><span>Selected Items for Segment</span></legend>
											</div>
									<div class="panel-body">
										<div class="col-md-12"  id="Linked_items" >
										
									
										</div>
									</div>
								</div>
							</div>
				 <div class="alert alert-danger alert-dismissible fade show" role="alert" id="form_msg" style="display:none;">
				  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
				  <span aria-hidden="true"> &times;</span></button>
				</div>
				
				  <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" id="addonemore" data-toggle="modal" data-target="#myModal1"   type="button">Add One More Combination</button>
				  </div>
				  
				  <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  
				  
				  <!-- Add One More Combination Modal -->
					<div id="myModal1" class="modal fade" role="dialog" style="padding-right: 320px !important;">
					  <div class="modal-dialog" style="width:900px;margin-top:50px;">
						<!-- Modal content-->
						<div class="modal-content" style="table-layout: auto;width:900px;">
						  <div class="modal-header">
						  <h4 class="modal-title">Add One More Combination</h4>
						  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
							
						  </div>
						  <div class="modal-body ui-front">
							<p>
								<div class="table-responsive">
								<table style="table-layout: auto;width:875px;" id="options-table" class="table table-bordered table-hover">
									<thead>
									<tr>
										<th class="text-center">Segment Type</th>
										<th class="text-center">Operator</th>
										<th class="text-center" id="Criteria_col">Criteria</th>
										<th class="text-center" id="Criteria1_col" >Criteria1</th>
										<th class="text-center" id="Criteria2_col" >Criteria2</th>
										<th class="text-center">
											<button type="button" id="addrows" class="btn btn-info" > Add+</button>
										</th>
									</tr>					
									</thead>
								</table>
								</div>
							</p>
						  </div>
							<div class="form-group has-feedback" id="has-feedback4">
								<div class="help-block" id="help-block4"></div>
							</div>
						  <div class="modal-footer">		  
							<button class="btn btn-primary" type="button" onclick="OK_button()" id="OK_button1"  data-dismiss="modal" >OK</button>			
						  </div>
						</div>
					  </div>
					</div>
					
				  <input type="hidden" id="linked_itemcode" name="linked_itemcode" value="">
				  <input type="hidden" id="linked_Category_id" name="linked_Category_id" value="">
				  
				<?php echo form_close(); ?>		  
				
			</div>
			</div>
  
			<!-------------------- START - Data Table -------------------->
		
		
		<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   Segments
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Segment Code</th>
							<th class="text-center">Segment name</th>
							<th class="text-center">Segment Operation</th>
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Segment Code</th>
							<th class="text-center">Segment name</th>
							<th class="text-center">Segment Operation</th>
							</tr>
						</tfoot>		

						<tbody>
						<?php
						$todays = date("Y-m-d");						
						if($segment_results != NULL)
						{	
							foreach($segment_results as $row)
							{		
								$lv_Segment_code=$row->Segment_code;
								
								$ci_object = &get_instance();
								$ci_object->load->model('Segment/Segment_model');
								$Get_segments = $ci_object->Segment_model->edit_segment_code($row->Company_id,$lv_Segment_code);
								$Segment_operation=array();
								$Segment_type_id=$row->Segment_type_id;
								
								/*if($Segment_type_id==13)//Item Category
								{
									$Get_linked_segment_items = $ci_object->Segment_model->Get_linked_items_segment_child($row->Company_id,$lv_Segment_code);
									
									//Item_code: Item_code,Merchandize_category_id: Merchandize_category_id,Segment_Code: Segment_Code,Company_id:Company_id
									$Segment_operation[]='<a href="javascript:Get_segment_linked_items_table('."'$lv_Segment_code'".');">Click to Show Purchase Item</a>';
								}*/
								$flag=0;
								foreach($Get_segments as $Get_segments)
								{
									$Segment_type_id2=$Get_segments->Segment_type_id;
									$Segment_code2=$Get_segments->Segment_code;
									/* if($Segment_type_id==13 && $lv_Segment_code==$Segment_code2)//Item Category
									{ */
										if($Segment_type_id2==13 && $flag==0)//Item Category
										{
											$Get_linked_segment_items = $ci_object->Segment_model->Get_linked_items_segment_child($row->Company_id,$lv_Segment_code);
											/* foreach($Get_linked_segment_items as $row1)
											{
												// $Segment_operation[]="".$row1->Merchandize_item_name."";
												
											} */
											//Item_code: Item_code,Merchandize_category_id: Merchandize_category_id,Segment_Code: Segment_Code,Company_id:Company_id
											if($Get_linked_segment_items != NULL)
											{
												$Segment_operation[]='<a href="javascript:Get_segment_linked_items_table('."'$lv_Segment_code'".');">Item Category</a>';
												$flag=1;
											}
										}
									// }
										if($Get_segments->Operator=='Between')
										{
											$Segment_operation[]=$Get_segments->Segment_type_name." ".$Get_segments->Operator." (".$Get_segments->Value1.",".$Get_segments->Value2.")";
										}
										else
										{
											if($Segment_type_id2!=13 && $Segment_type_id2!=14)//Not Item Category
											{
											
												$Segment_operation[]=$Get_segments->Segment_type_name." ".$Get_segments->Operator." '".$Get_segments->Value."'";
											}
											if($Segment_type_id2==14)//Hobbies
											{
												$Get_hobbies = $ci_object->Segment_model->Get_linked_segment_hobbies($Get_segments->Value);
												if($Get_hobbies != NULL)
												{
													$Segment_operation[]=$Get_segments->Segment_type_name." ".$Get_segments->Operator." '".$Get_hobbies->Hobbies."'";
												}
											}
										}
									
									
								}
								$lv_Segment_operation=implode(" AND ",$Segment_operation);
								
							?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/SegmentC/edit_segment/?SegmentCode=<?php echo $row->Segment_code;?>&CompanyId=<?php echo $row->Company_id;?>" title="Edit">
										<i class="os-icon os-icon-ui-49"></i>
									</a>
									
									<a href="javascript:void(0);" class="danger" onclick="delete_segment('<?php echo $row->Segment_code;?>','<?php echo $row->Segment_name; ?>');" title="Delete">
										<i class="os-icon os-icon-ui-15"></i>
									</a>
								</td>
								<td><?php echo $row->Segment_code;?></td>
								<td><?php echo $row->Segment_name;?></td>
								<td><?php echo $lv_Segment_operation;?></td>
								<!--
								<?php if($row->Operator == 'Between' ) { ?>
								<td><?php echo $row->Segment_type_name.' '.$row->Operator.' '.$row->Value1.' - '.$row->Value2;  ?></td>
								<?php } else { ?>
								<td><?php echo $row->Segment_type_name.' '.$row->Operator.' '.$row->Value;  ?></td>
								<?php } ?>
								-->
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
			  
	
<!--------------------  END - Data Table  -------------------->

		  </div>
		</div>
		
			
	</div>
</div>			


<!-- msg popup modal -->
<div class="modal fade" id="msg_myModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Application Information
					</h5>
					<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
				</div>
            <div class="modal-body">
                <div  id="modal_msg"></div>
            </div>
			<div class="modal-footer">
			<button class="btn btn-secondary" data-dismiss="modal" type="button"> Ok</button>
		  </div>
        </div>

    </div>
</div>	

		
	<div id="Item_modal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade " role="dialog" tabindex="-1" >
		<div class="modal-dialog modal-lg" style="margin-top:20%;width:60%;">
			<div class="modal-content" style="width:50%;">
			 <div class="modal-header">
				<button aria-label="Close"  id="close_modal3"  class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			  </div>
			  <div class="modal-body">
				<div  id="Show_items"></div>
			  </div>
			 
			</div>
		</div>
    </div>		
 
<?php $this->load->view('header/footer'); ?>

<script>
/***********************Autocomplete**************************/	
	function Autocomplete(abs,counter)
	{
		var SegmentType = $("#SegmentType_1_"+counter).val();	
		
		if(SegmentType == 3)
		{ 
			$("#Criteria_0_"+counter).autocomplete({
			 
				source:"<?php echo base_url()?>index.php/SegmentC/autocomplete_country_names", 
				
				change: function (event, ui)
				{ 
					if (!ui.item) { this.value = ''; }
					
				}			
			}); 
		} 
		else if(SegmentType == 5)
		{
			$("#Criteria_0_"+counter).autocomplete({
			 
				source:"<?php echo base_url()?>index.php/SegmentC/autocomplete_state_names", 
				
				change: function (event, ui)
				{ 
					if (!ui.item) { this.value = ''; }
					 
				}			
			});
		}
		else if(SegmentType == 6)
		{
			$("#Criteria_0_"+counter).autocomplete({
			 
				source:"<?php echo base_url()?>index.php/SegmentC/autocomplete_city_names",
				
				change: function (event, ui)
				{ 
					if (!ui.item) { this.value = ''; }
					 
				}			
			});
		}	
	} 	
	function Autocomplete1()
	{ 	   
		var SegmentType = $('#SegmentType').val();
		
		if(SegmentType == 3)
		{ 
			$("#Country_Criteriavalue").autocomplete({
			 
				source:"<?php echo base_url()?>index.php/SegmentC/autocomplete_country_names", 
				
				change: function (event, ui)
				{ 
					if (!ui.item) { this.value = ''; }
				}			
			}); 
		} 
		else if(SegmentType == 5)
		{
			$("#State_Criteriavalue").autocomplete({
			 
				source:"<?php echo base_url()?>index.php/SegmentC/autocomplete_state_names", 
				
				change: function (event, ui)
				{ 
					if (!ui.item) { this.value = ''; }
				}			
			});
		}
		else if(SegmentType == 6)
		{
			$("#City_Criteriavalue").autocomplete({
			 
				source:"<?php echo base_url()?>index.php/SegmentC/autocomplete_city_names",
				
				change: function (event, ui)
				{ 
					if (!ui.item) { this.value = ''; }
				}			
			});
		}
	}  	
/***********************Autocomplete************************/
		
	$('#Register').click(function()
	{	
		if($('#Segment_name').val() != "")	{
			show_loader();	
		}
	}); 
	
	$('#addonemore').click(function()
	{
		if($('#Segment_Code').val() == "" || $('#Segment_name').val() == "" )
		{
			var msg = "Please enter values for required fields";
			// var msg = "Please Enter Segment Code, Segment name  Operator and  Segment Type";
			//runjs(Title,msg);
			
			$("#form_msg").show();
			$("#form_msg").text(msg);
			$("#form_msg").focus();
			setTimeout(function(){
				$("#form_msg").hide();
			},2000);
			
			return false;
		}
		else
		{
			return true;
		}
		
	}); 
	
	$('#Segment_name').blur(function()
	{
		var CompanyId = '<?php echo $Company_id; ?>';
		var SegmentName = $("#Segment_name").val();
		
		if(SegmentName == "")
		{
			$("#Segment_name").val("");
			
			$('#Segment_name_err').show();
			$('#Segment_name_err').html(msg1);
		}
		else
		{
			$.ajax({
				type:"POST",
				data:{'SegmentName':SegmentName,'CompanyId':CompanyId},
				url: "<?php echo base_url()?>index.php/SegmentC/Segment_code_validation",
				success : function(data)
				{ 
					if(data == 1)
					{
						$("#Segment_name").val("");
						
						$("#Segment_name").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#Segment_name_err').show();
							$('#Segment_name_err').html(msg1);
					}
					else
					{
						$('#Segment_name_err').html("");
						$("#Segment_name").removeClass("has-error");	
					}
				}
			});
		}		
	}); 
	function Change_operator2(Segment_type,id)
	{
		 //alert(Segment_type);
		// alert(id);
		$('#Item_Category_'+id).hide();
		$('#Hobbies_'+id).hide();
		if(Segment_type==2 ){
			
			$('#Criteria_0_'+id).hide();
			document.getElementById("Single_operator_"+id).style.display="";
			document.getElementById("All_operator_"+id).style.display="none";
			
			
			 $('#Criteria_0_'+id).attr("disabled","true");
			$('#Criteria_1_'+id).hide();
			$('#Criteria_2_'+id).hide();
			$('#Sex_Criteria_0_'+id).show();
		//	$('#Sex_Criteria_0_'+id).attr("disabled","false");
		}
		else if(Segment_type==3 || Segment_type==4 || Segment_type==5 || Segment_type==6 || Segment_type==7 )
		{
			if(Segment_type == 7){
				$('#Criteria_0_'+id).attr("type","text");
			}
			document.getElementById("Single_operator_"+id).style.display="";
			document.getElementById("All_operator_"+id).style.display="none";
			$('#Criteria_0_'+id).show();
		//	$('#Criteria_0_'+id).attr("disabled","false");
			$('#Criteria_1_'+id).hide();
			$('#Criteria_2_'+id).hide();
			$('#Sex_Criteria_0_'+id).hide();
			// $('#Sex_Criteria_0_'+id).attr("disabled","true");
			ckeck_operator_popup_1('=',id);			
		}
		else if(Segment_type==13 ){
			
			
			document.getElementById("Single_operator_"+id).style.display="none";
			document.getElementById("All_operator_"+id).style.display="none";
			
			$('#Item_Category_'+id).show();
			 
			 $('#Criteria_0_'+id).hide();
			$('#Criteria_1_'+id).hide();
			$('#Criteria_2_'+id).hide();
			$('#Sex_Criteria_0_'+id).hide();
			// ckeck_operator_popup_1('=',id);
		//	$('#Sex_Criteria_0_'+id).attr("disabled","false");
		}
		else if(Segment_type==14 ){
			
			
			document.getElementById("Single_operator_"+id).style.display="none";
			document.getElementById("All_operator_"+id).style.display="none";
			
			$('#Item_Category_'+id).hide();
			$('#Hobbies_'+id).show();
			 
			 $('#Criteria_0_'+id).hide();
			$('#Criteria_1_'+id).hide();
			$('#Criteria_2_'+id).hide();
			$('#Sex_Criteria_0_'+id).hide();
			// ckeck_operator_popup_1('=',id);
		//	$('#Sex_Criteria_0_'+id).attr("disabled","false");
		}
		else
		{
			
			$('#Criteria_1_'+id).attr("type","text");
			$('#Criteria_2_'+id).attr("type","text");
			document.getElementById("Single_operator_"+id).style.display="none";
			document.getElementById("All_operator_"+id).style.display="";
			$('#Criteria_0_'+id).hide();
			$('#Criteria_1_'+id).show();
			$('#Criteria_2_'+id).show();
			$('#Sex_Criteria_0_'+id).hide();
			
			
			// $('#Sex_Criteria_0_'+id).attr("disabled","true");
			ckeck_operator_popup_1('=',id);
		}

	}
	
	function delete_segment_id(Segment_id,segmentcode,Segmentname,Companyid)
	{	
		
		if(Segment_id != "" && segmentcode != "" && Segmentname != "")
		{
				//alert(segmentcode +"--"+Segmentname);
			delete_me(Segment_id,Segmentname,'Segment Criteria','SegmentC/delete_segment_id/?Segmentid');
				$('#deleteModal').modal('toggle');
		}
	}
	
	function delete_segment(segmentcode,Segmentname)
	{
		
		var Company_id='<?php echo $Company_id;?>';
		if(segmentcode != "" && Segmentname != "")
		{
			$.ajax({
				type: "POST",			 
				data: {segmentcode: segmentcode,Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/SegmentC/Check_segment_link",
				success: function(data)
				{

					if(data==0)
					{
						//alert(segmentcode +"--"+Segmentname);
						delete_me(segmentcode,Segmentname,'','SegmentC/delete_segment/?segment_code');
						$('#deleteModal').modal('toggle');
					}
					else
					{
						var msg = "You Could Not Delete '"+Segmentname+"' Segment. Hence this Segment is link to loyalty rule or Communication.";						
						
						$("#modal_msg").text(msg);
						$('#msg_myModal').modal('toggle');
						
					}	
				}
			});
		} 
	}  
	
	function ckeck_operator_popup_1(inPutVal,counter)
	{
		if(inPutVal=='Between')
		{
			$('#Criteria_0_'+counter).hide();			 			 
			$('#Criteria_1_'+counter).show();
			$('#Criteria_2_'+counter).show();			
		}
		else
		{			
			$('#Criteria_1_'+counter).hide();
			$('#Criteria_2_'+counter).hide();
			$('#Criteria_0_'+counter).show();
		}	 
	}
 	function Get_segment_linked_items_table(Segment_Code)
	{
		$.ajax({
			  type: "POST",
			  data: {Segment_Code: Segment_Code,},
			  url: "<?php echo base_url()?>index.php/SegmentC/Get_segment_linked_items_table",
			  success: function(data)
				{
				   $('#Show_items').html(data.Linked_items);
				   $('#Item_modal').show();
					$("#Item_modal").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
					
					
				}
			});  
	}
 /******** add row ********/
     
jQuery(function(){
	
	var counter = 0;
	
    jQuery('#addrows').click(function(event)
	{
        event.preventDefault();
       
	var newRow = jQuery(
		'<tr id="Row_'+counter+'"><td class="extra_width"><select class="form-control extra_width" name="SegmentType_'+counter+'" id="SegmentType_1_'+counter+'"   onchange="Change_operator2(this.value,'+counter+');"><option value="">Select Type</option><?php foreach($Segment_type as $seg) { if($seg['Segment_type_id'] != 4 ){ ?><option value="<?php echo $seg['Segment_type_id']; ?>"><?php echo $seg['Segment_type_name']; ?></option><?php } } ?></select></td><td  style="display:none;"  class="extra_width" id="Item_Category_'+counter+'"><select class="form-control extra_width" name="Item_Category_id_'+counter+'" id="Item_Category_id_'+counter+'"   onchange="Get_items(this.value);"><option value="">Select Category</option><?php foreach($Merchandize_Category_Records as $Merchandize_Category) { if(!$Merchandize_Category->Parent_category_id) { $childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id); ?><option value="<?php echo $Merchandize_Category->Merchandize_category_id; ?>"><?php echo $Merchandize_Category->Merchandize_category_name; ?></option><?php foreach($childs as $row) {?><option value="<?php echo $row->Merchandize_category_id; ?>"><?php echo $row->Merchandize_category_name; ?></option><?php } } } ?></select></td><td  style="display:none;"  class="extra_width" id="Hobbies_'+counter+'"><select class="form-control extra_width select2" multiple="true" name="Hobbies_'+counter+'[]" ><?php foreach($Hobbies_list as $hob) {  ?><option value="<?php echo $hob->Id; ?>"><?php echo $hob->Hobbies; ?></option><?php  }  ?></select></td><td style="display:none;"  class="extra_width" id="Single_operator_'+counter+'"><select class="form-control extra_width" name="Operatorid3_'+counter+'" id="Operatorid3'+counter+'" onchange="ckeck_operator_popup_1(this.value,'+counter+')"  ><option value="="> = </option></select></td> <td id="All_operator_'+counter+'"  class="extra_width"><select class="form-control extra_width" name="Operatorid1_'+counter+'" id="Operatorid1'+counter+'" onchange="ckeck_operator_popup_1(this.value,'+counter+')"  ><option value=""> Select Operator </option><option value="="> = </option><option value=">"> > </option><option value=">="> >= </option><option value="<"> < </option><option value="<="> <= </option><option value="!="> != </option><option value="Between"> Between </option></select></td> <td id="table_col"  class="extra_width"><input  class="form-control extra_width"  value="" name="Operator_Criteria_'+counter+'"  id="Criteria_0_'+counter+'" onKeyPress="Autocomplete(this.value,'+counter+');" style="display:none"/> <select class="form-control extra_width" name="Operator_CriteriaSex_'+counter+'"  id="Sex_Criteria_0_'+counter+'" data-error="Please select sex" style="display:none"><option value=""> Select Sex </option><option value="Male"> Male </option><option value="Female"> Female </option></select></td><td  class="extra_width"><input type="text"  class="form-control extra_width"  value="" name="Operator_Criteria1_'+counter+'"  id="Criteria_1_'+counter+'"/></td><td  class="extra_width"><input type="text"  class="form-control extra_width" value="" name="Operator_Criteria2_'+counter+'" placeholder=""  id="Criteria_2_'+counter+ '"/></td><td class="extra_width"><a id="Rmv_'+counter+'" class="danger" href="javascript:RemoveRow('+counter+');"><i class="os-icon os-icon-ui-15 "></i></a></td></tr>'
			);
        jQuery('#options-table').append(newRow);
		
		counter++;
    });
});
	function Get_items(Merchandize_category_id)
	{
		 
		 var Segment_Code = $("#Segment_Code").val();
		
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Merchandize_category_id:Merchandize_category_id, Company_id:Company_id, Segment_Code:Segment_Code},
			url: "<?php echo base_url()?>index.php/SegmentC/Get_items_for_segment",
			success: function(data)
			{
				
				 $("#Show_items").html(data.Items_by_category);	
				
					
					$('#Item_modal').show();
					$("#Item_modal").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
			}				
		});
	}
function RemoveRow(rowID)
{
	jQuery('#Row_'+rowID).remove();
}	

function RemoveAllRows()
{
	$("#options-table").find("tr:gt(0)").remove();
}
</script>

<style>
.modal-dialog
{
	width: 66% !IMPORTANT;
}
<style>