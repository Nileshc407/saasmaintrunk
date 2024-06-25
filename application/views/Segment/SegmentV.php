<?php 
$this->load->view('header/header');
$todays = date("Y-m-d");
// print_r($Merchandize_Category_Records);
$this->load->model('Catalogue/Catelogue_model');
$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag'];

 ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   SEGMENT MASTER
			  </h6>
  
				<div class="form-buttons-w" align="left">
					 <button type="button" name="submit"  id="Segment" class="btn btn-primary" onclick="ModalClick('light','#FFFFFF','');">Show Segment Handlers</button> 
				</div><hr>
				  
			 
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
				echo form_open('SegmentC/Segment',$attributes); ?>
					<div class="row">
					<div class="col-sm-6">	
						<div class="form-group">
						<label for=""> <span class="required_info">*</span> Segment Code </label>								
						<input class="form-control"  name="Segment_Code" id="Segment_Code"  type="text" placeholder="Enter Segment Code"  required="required" data-error="Please enter segment code" >
						<div class="help-block form-text with-errors form-control-feedback" id="SegmentCode"></div>
						</div> 
					  
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Select Segment Type </label>
						<select class="form-control" name="SegmentType"  id="SegmentType" required="required" onchange="Change_operator(this.value);" data-error="Please select segment type">

							<option value="">Select Type</option>
							<?php foreach($Segment_type as $seg) 
							{	
								if($seg['Segment_type_id'] != 4){
							?>								 
								<option value="<?php echo $seg['Segment_type_id']; ?>"><?php echo $seg['Segment_type_name']; ?></option>
									
							<?php 
								}
							}
							?>
						</select>
							<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>	
						
						
					</div>
					<div class="col-sm-6">	
					
						<div class="form-group">
						<label for=""> <span class="required_info">* </span> Segment Name </label>
						<input class="form-control"  name="Segment_name" id="Segment_name"  type="text" placeholder="Enter Segment Name" required="required" data-error="Please enter segment name" >
						<div class="help-block form-text with-errors form-control-feedback" id="Segment_name_err"></div>
						</div> 
						
						<div class="row" >
						<div class="col-sm-6" >
						<div class="form-group" id="All_operator">
						<label for=""> <span class="required_info">* </span> Operator </label>
						<select class="form-control" name="Operatorid" id="Operatorid" onchange="ckeck_operator(this.value);"  data-error="Please select operator">
							<option value=""> Select Operator </option>
							<option value="="> = </option>
							<option value=">"> > </option>
							<option value=">="> >= </option>
							<option value="<"> < </option>
							<option value="<="> <= </option>
							<option value="!="> != </option>
							<option value="Between"> Between </option>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group"  id="Single_operator" style="display:none;">
						<label for=""> <span class="required_info">* </span> Operator </label>
						<select class="form-control" name="Operatorid2" id="Operatorid2" onchange="ckeck_operator(this.value);"  data-error="Please select operator">
							<option value="="> = </option>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						</div>


							<div class="col-sm-6" >
								<div class="form-group" id="Criteria_0">
								<label for=""> <span class="required_info">*</span> Criteria Value </label>								
								<input class="form-control"  name="Criteriavalue" id="Criteriavalue"  type="text" placeholder="Enter Criteria Value"   data-error="Please enter criteria value as per selected segment type" >
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div> 
								<div class="form-group" id="SexCriteriavalue" style="display:none">
								<label for=""> <span class="required_info">*</span> Select Gender</label>
								<select class="form-control" name="Criteriavalue" id="sex_Criteriavalue" data-error="Please select sex">
									<option value=""> Select Gender </option>
									<option value="Male"> Male </option>
									<option value="Female"> Female </option>
								</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div class="form-group" id="Criteria_1" style="display:none">
									<label for=""> <span class="required_info">*</span> Criteria Value 1</label>								
									<input class="form-control"  name="Criteria_Value_1" id="Criteria_Value_1"  type="text" placeholder="Enter Criteria Value 1"   data-error="Please enter criteria value" >
									<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>

									<div class="form-group" id="Country_list" style="display:none">	<label for=""> <span class="required_info">*</span> Enter Country</label>						
									<input class="form-control"  name="Country_Criteriavalue" id="Country_Criteriavalue"  type="text" placeholder="Enter Country Name" onKeyPress="Autocomplete1();" >
									<div class="help-block form-text with-errors form-control-feedback" id="Criteria2"></div>
									</div> 
									
									<div class="form-group" id="State_list" style="display:none">	
									<span class="required_info">*</span> Enter State</label>
									<input class="form-control"  name="State_Criteriavalue" id="State_Criteriavalue"  type="text" placeholder="Enter State Name" onKeyPress="Autocomplete1();" >
									<div class="help-block form-text with-errors form-control-feedback" id="Criteria3"></div>
									</div> 
									
									<div class="form-group" id="City_list" style="display:none"><span class="required_info">*</span> Enter City</label>							
									<input class="form-control"  name="City_Criteriavalue" id="City_Criteriavalue"  type="text" placeholder="Enter City Name" onKeyPress="Autocomplete1();" >
									<div class="help-block form-text with-errors form-control-feedback" id="Criteria4"></div>
									</div> 

									<div class="form-group" id="Criteria_2" style="display:none">
									<label for=""> <span class="required_info">*</span> Criteria Value 2</label>								
									<input class="form-control"  name="Criteria_Value_2" id="Criteria_Value_2"  type="text" placeholder="Enter Criteria Value 2"   data-error="Please enter criteria value" >
									<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
							</div> 
							
							
							
							
						</div> 
						
						
						<div class="form-group" id="Hobbies"  style="display:none;width:473px !important;">
							<label for=""> Hobbies/Interest</label>
							<select class="form-control select2" multiple="true" name="Seg_hobbies[]" style="width:473px !important;">
							
							  <?php
								foreach($Hobbies_list as $hob)
								{
									echo "<option value=".$hob->Id.">".$hob->Hobbies."</option>";
								}
								?>
							</select>
						</div> 
						
						<div class="form-group" id="Brand"  style="display:none;width:473px !important;">
							<label for="">Brand</label>
							<select class="form-control" name="seller_id" ID="seller_id" >
									<option value="">Select Brand</option>
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
						<div class="form-group"  id="Outlet"  style="display:none;width:473px !important;">
							<label for="">Outlet Name</label>
							<select class="form-control"  name="Outlet_id"  ID="Outlet_id" >
								<option value="0">Select Brand First</option>

							</select>
							
					  </div>
						<div class="form-group"  id="Tier"  style="display:none;width:473px !important;">
						<label for=""> <span class="required_info" style="color:red;">*</span> Select Tier</label> 
						<select class="form-control" name="member_tier_id"  id="member_tier_id"  >
							<!--<option value="0">All Tiers</option>	-->					
							<?php										
							foreach($Tier_list as $Tier)
							{
								echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
							}
							?>
						</select>						
						</div>
						
						<div class="form-group"  id="Date_range"  style="display:none;width:473px !important;">
							   <label for="">From Date </label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  >
							  </div>

						  <div class="form-group"  id="Date_range2"  style="display:none;width:473px !important;">
						   <label for="">Till Date </label>
							<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" />
						  </div>
							  
							  
							  
						<div class="form-group"  id="Item_Category"  style="display:none">
								<label for=""><span class="required_info" >* </span>Select Category</label>
								
								<select class="form-control" name="Item_Category_id" id="Item_Category_id"  data-error="Please Select Category"  onchange="Get_items(this.value);" >
								<option value="0">Select Brand First</option>
								</select>
							
							<div class="help-block form-text with-errors form-control-feedback"></div>
							<div style="color:red;" id="help-block22"></div>
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
				   </div> 
				   
				 <div class="alert alert-danger alert-dismissible fade show" role="alert" id="form_msg" style="display:none;">
				  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
				  <span aria-hidden="true"> &times;</span></button>
				</div>
				
				  <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" id="addonemore" data-toggle="modal" data-target="#myModal1"   type="button">Add One More Combination</button>
				  </div>
				  <?php if($_SESSION['Privileges_Add_flag']==1){ ?>
				  <div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
				  </div>
				  <?php } ?>
				  
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
				  <input type="hidden" id="linked_Quantity" name="linked_Quantity" value="">
				<?php echo form_close(); ?>		  
				
			</div>
			</div>
			
			<!-------------------- START - Data Table -------------------->
		
			<?php if($_SESSION['Privileges_View_flag']==1){ ?> 
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
							<th class="text-center">Segment Condition</th>
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Segment Code</th>
							<th class="text-center">Segment name</th>
							<th class="text-center">Segment Condition</th>
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
								
								
								$flag=0;
								foreach($Get_segments as $Get_segments)
								{
									$Segment_type_id2=$Get_segments->Segment_type_id;
									$Segment_code2=$Get_segments->Segment_code;
									
										if($Segment_type_id2==13 && $flag==0)//Item Category
										{
											$Get_linked_segment_items = $ci_object->Segment_model->Get_linked_items_segment_child($row->Company_id,$lv_Segment_code);
											if($Get_linked_segment_items != NULL)
											{
												$Segment_operation[]='<a href="javascript:Get_segment_linked_items_table('."'$lv_Segment_code'".');">Item Category</a>';
												$flag=1;
											}
										}
										
										
										if($Get_segments->Operator=='Between')
										{
											$Segment_operation[]=$Get_segments->Segment_type_name." ".$Get_segments->Operator." (".$Get_segments->Value1.",".$Get_segments->Value2.")";
										}
										else
										{
											if($Segment_type_id2!=13 && $Segment_type_id2!=14)//Not Item Category 
											{
												if($Segment_type_id2==17)//Tier
												{
													$Get_tier = $ci_object->Igain_model->get_tier_detail($Get_segments->Value);
													if($Get_tier != NULL)
													{
														$Get_segments->Value = $Get_tier->Tier_name;
													}
												}
												
												if($Segment_type_id2==16)//Outlet
												{
													$Get_outlet = $ci_object->Igain_model->get_seller_details($Get_segments->Value);
													if($Get_outlet != NULL)
													{
														foreach($Get_outlet as $Get_outlet){
														$Get_segments->Value = $Get_outlet->First_name.' '.$Get_outlet->Last_name;}
													}
												}
												
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
									<?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
									<a href="<?php echo base_url()?>index.php/SegmentC/edit_segment/?SegmentCode=<?php echo $row->Segment_code;?>&CompanyId=<?php echo $row->Company_id;?>" title="Edit">
										<i class="os-icon os-icon-ui-49"></i>
									</a>
									
										<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>
									<a href="javascript:void(0);" class="danger" onclick="delete_segment('<?php echo $row->Segment_code;?>','<?php echo $row->Segment_name; ?>');" title="Delete">
										<i class="os-icon os-icon-ui-15"></i>
									</a><?php } ?>
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
			  <?php } ?>
	
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


 <!-- Button trigger modal -->

            <!-- Modal -->
            <div class="modal fade" id="myModal" style="width:130%;height:110%; margin: auto; " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
						
							<h5 class="modal-title" id="exampleModalLabel">
								Segment Handlers
							</h5>
					
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            
                        </div>
						
						<div class="row">
					<div class="col-md-2">
						<div class="dropdown">
							<button class="btn btn-defualt dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Graph Themes
								<span class="glyphicon glyphicon-cog"></span>
								<span class="caret"></span>
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
							
									<a href="javascript:void(0);" onclick="makeCharts('light', '#ffffff','');">
										<img width="36" height="35" alt="theme_light" class="dropdown-item attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/LightTheme.png" kasperskylab_antibanner="on">
										
									</a>
				
									<a href="javascript:void(0);" onclick="makeCharts('dark', '#282828','');">
										<img width="36" height="35" alt="theme_dark" class="dropdown-item attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/DarkTheme.png" kasperskylab_antibanner="on">
										
									</a>
							
									<a href="javascript:void(0);" onclick="makeCharts('chalk', '#282828','<?php echo base_url()?>images/chalk_bg.jpg');">
										<img width="36" height="35" alt="theme_chalk" class="dropdown-item attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/ChalkTheme.jpg" kasperskylab_antibanner="on">
										
									</a>
								
									<a href="javascript:void(0);" onclick="makeCharts('patterns', '#ffffff','');">
										<img width="35" height="35" alt="theme_pattern" class="dropdown-item attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/PatternTheme.jpg" kasperskylab_antibanner="on">
										
									</a>
								
							</div>
						</div>
					</div> 
				</div>
                        <div class="modal-body">		
							<div id="Sex_wise_member_graph" style="width:90%;height:350px;"></div>
							<div id="City_wise_member_sex_graph" style="width:90%;height:350px;"></div>
							<div id="Age_wise_member_graph" style="width:90%;height:350px;"></div>	
							<div id="Cumulative_purchase_wise_member_graph" style="width:90%;height:350px;"></div>								
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
			
			
	<div id="Item_modal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" >
		<div class="modal-dialog modal-lg" style="margin-top:15%;width:60%;">
			<div class="modal-content" >
			 <div class="modal-header">
				<button aria-label="Close"  id="close_modal3"  class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			  </div>
			  <div class="modal-body">
				<div  id="Show_items"></div>
			  </div>
			 
			</div>
		</div>
    </div>		
<!-- msg popup modal -->
<?php $this->load->view('header/footer'); ?>


<script type="text/javascript">	
	function Change_operator(Segment_type)
	{
		$("#Criteriavalue").val('');
		// alert(Segment_type);
	//	ckeck_required(Segment_type);
		
		if(Segment_type==2 || Segment_type==3 || Segment_type==4 || Segment_type==5 || Segment_type==6 || Segment_type==7 )
		{
			document.getElementById("Single_operator").style.display="";
			document.getElementById("All_operator").style.display="none";
			$('#Operatorid').removeAttr('required');
			
			if(Segment_type > 2){
				ckeck_operator('=');
			}
		}
		else
		{
			ckeck_operator('=');
			document.getElementById("Single_operator").style.display="none";
			document.getElementById("All_operator").style.display="";
			$('#Operatorid').attr('required', 'required');
			
		}
		$("#Item_Category").hide();
		$("#Hobbies").hide();
		$("#Brand").hide();
		$("#Outlet").hide();
		$("#Tier").hide();
		$("#Date_range").hide();
		$("#Date_range2").hide();
		if(Segment_type==2)
		{
			$("#SexCriteriavalue").show();
			$("#Criteria_0").hide();
			$("#Country_list").hide();
			$("#State_list").hide();
			$("#City_list").hide();
			

			$("#sex_Criteriavalue").removeAttr("disabled");
			$("#sex_Criteriavalue").attr("required","required");
			$("#Country_Criteriavalue").removeAttr("required");
			$("#State_Criteriavalue").removeAttr("required");	
			$("#City_Criteriavalue").removeAttr("required");
			$("#Criteriavalue").removeAttr("required");
			// $('#Criteriavalue').attr("disabled","true");
						$("#Item_Category").hide();
						$("#selected_items").hide();
			
		}
		else if(Segment_type==3)
		{
			$("#Country_list").show();
			$("#Criteria_0").hide();
			$("#State_list").hide();
			$("#City_list").hide();
			$("#SexCriteriavalue").hide();
			$("#sex_Criteriavalue").removeAttr("required");
			$('#sex_Criteriavalue').attr("disabled","true");
			$("#Country_Criteriavalue").attr("required","required");
			
			$("#Criteriavalue").removeAttr("required");
			$("#State_Criteriavalue").removeAttr("required");	
			$("#City_Criteriavalue").removeAttr("required");
						$("#Item_Category").hide();
						$("#selected_items").hide();
		}
		else if(Segment_type==5)
		{
			$("#State_list").show();
			$("#Country_list").hide();
			$("#Criteria_0").hide();
			$("#City_list").hide();
			$("#SexCriteriavalue").hide();
			$("#sex_Criteriavalue").removeAttr("required");
			$('#sex_Criteriavalue').attr("disabled","true");
			$("#State_Criteriavalue").attr("required","required");
			$("#Country_Criteriavalue").removeAttr("required");
			$("#Criteriavalue").removeAttr("required");
			$("#City_Criteriavalue").removeAttr("required");	
						$("#Item_Category").hide();
						$("#selected_items").hide();
		}
		else if(Segment_type==6)
		{
			$("#City_list").show();
			$("#Country_list").hide();
			$("#State_list").hide();
			$("#Criteria_0").hide();
			$("#SexCriteriavalue").hide();
			$("#sex_Criteriavalue").removeAttr("required");
			$('#sex_Criteriavalue').attr("disabled","true");
			$("#City_Criteriavalue").attr("required","required");
			$("#Country_Criteriavalue").removeAttr("required");
			$("#Criteriavalue").removeAttr("required");
			$("#State_Criteriavalue").removeAttr("required");	
			$("#Item_Category").hide();			
			$("#selected_items").hide();
		}
		else
		{
			$("#Criteria_0").show();
			$("#Country_list").hide();
			$("#State_list").hide();
			$("#City_list").hide();
			
			$("#Criteriavalue").attr("required","required");
			$("#SexCriteriavalue").hide();
			$("#sex_Criteriavalue").removeAttr("required");
			$('#sex_Criteriavalue').attr("disabled","true");
			$("#Country_Criteriavalue").removeAttr("required");			
			$("#State_Criteriavalue").removeAttr("required");			
			$("#City_Criteriavalue").removeAttr("required");

			$("#Item_Category").hide();	
			$("#selected_items").hide();			
		}	
		if(Segment_type==13)//Item Category
		{
			$("#Criteriavalue").removeAttr("required");
			$("#sex_Criteriavalue").removeAttr("required");
			$("#Country_Criteriavalue").removeAttr("required");		
			$("#State_Criteriavalue").removeAttr("required");			
			$("#City_Criteriavalue").removeAttr("required");
			$('#Operatorid').removeAttr('required');
			
			$("#Criteria_0").hide();
			$("#All_operator").hide();
			$("#Item_Category").show();
			
			$("#Brand").show();	
			
		}
		if(Segment_type==14)//Hobbies
		{
			$("#Criteriavalue").removeAttr("required");
			$("#sex_Criteriavalue").removeAttr("required");
			$("#Country_Criteriavalue").removeAttr("required");		
			$("#State_Criteriavalue").removeAttr("required");			
			$("#City_Criteriavalue").removeAttr("required");
			$('#Operatorid').removeAttr('required');
			
			$("#Criteria_0").hide();
			$("#All_operator").hide();
			$("#Item_Category").hide();
			
			
			$("#Hobbies").show();
		}
		if(Segment_type==15)//Date Range
		{
			$("#Criteriavalue").removeAttr("required");
			$("#sex_Criteriavalue").removeAttr("required");
			$("#Country_Criteriavalue").removeAttr("required");		
			$("#State_Criteriavalue").removeAttr("required");			
			$("#City_Criteriavalue").removeAttr("required");
			$('#Operatorid').removeAttr('required');
			
			$("#Criteria_0").hide();
			$("#All_operator").hide();
			$("#Item_Category").hide();
			
			
			$("#Hobbies").hide();
			$("#Brand").hide();
			$("#Date_range").show();
			$("#Date_range2").show();
			
			
		}
		if(Segment_type==16)//Outlet
		{
			$("#Criteriavalue").removeAttr("required");
			$("#sex_Criteriavalue").removeAttr("required");
			$("#Country_Criteriavalue").removeAttr("required");		
			$("#State_Criteriavalue").removeAttr("required");			
			$("#City_Criteriavalue").removeAttr("required");
			$('#Operatorid').removeAttr('required');
			
			$("#Criteria_0").hide();
			$("#All_operator").hide();
			$("#Item_Category").hide();
			
			
			$("#Hobbies").hide();
			$("#Brand").hide();
			$("#Brand").show();		
			$("#Outlet").show();		
		}
		if(Segment_type==17)//Tier
		{
			$("#Criteriavalue").removeAttr("required");
			$("#sex_Criteriavalue").removeAttr("required");
			$("#Country_Criteriavalue").removeAttr("required");		
			$("#State_Criteriavalue").removeAttr("required");			
			$("#City_Criteriavalue").removeAttr("required");
			$('#Operatorid').removeAttr('required');
			
			$("#Criteria_0").hide();
			$("#All_operator").hide();
			$("#Item_Category").hide();
			
			
			$("#Hobbies").hide();
			$("#Brand").hide();
			$("#Tier").show();
		}
	}
		function ckeck_operator(inPutVal)
	{
		if(inPutVal == 'Between')
		{
			$("#Criteria_1").show();
			$("#Criteria_2").show();
			$("#Criteria_0").hide();
			
			$('#Criteriavalue').removeAttr('required');
			$('#Criteria_Value_1').attr('required', 'required');
			$('#Criteria_Value_2').attr('required', 'required'); 
		}
		else
		{
			$('#Criteria_Value_1').removeAttr('required');
			$('#Criteria_Value_2').removeAttr('required');
			$('#Criteriavalue').attr('required', 'required'); 	

			$("#Criteria_1").hide();
			$("#Criteria_2").hide();
			$("#Criteria_0").show();			
		}	 
	}

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
	$('#seller_id').change(function()
	{
		var seller_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_outlet_by_subadmin',
			success:function(opData4){
			
				$('#Outlet_id').html(opData4);
			}
		});
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_category_by_subadmin',
			success:function(opData4){
			
				$('#Item_Category_id').html(opData4);
			}
		});
			
	});
	function get_outlets(seller_id,counter)
	{
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_outlet_by_subadmin',
			success:function(opData4){
			
				$('#Outlet_Criteria_0_'+counter).html(opData4);
			}
		});
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_category_by_subadmin',
			success:function(opData4){
			
				$('#Item_Category_id_'+counter).html(opData4);
			}
		});
	}
   function ModalClick() {
                
		makeCharts('light', '#ffffff','');
		$('#myModal').modal('show').on('shown.bs.modal', function () {
			// get the chart 
			var chart = $(this).data('chart');
			if ( chart ) {
				// the chart was already built, let's just make it resize
				chart.invalidateSize()
			}
			else {
				// let's build the chart and store it together with
				// modal element
				$(this).data('chart', makeCharts('light', '#ffffff',''));
			}
		});
	}
			
function makeCharts(theme, bgColor, bgImage)
{ 
	// sow_segment_handlers	
	var Company_id='<?php echo $Company_id;?>';	
	var chart1;
	var chart2;
	var chart3;
	var chart4;
	var chart5;

		chart1 = AmCharts.makeChart("Sex_wise_member_graph",
		{ 
			type: "pie",
			startDuration: 1,
			addClassNames: true,
			theme: theme,
			titles: [{
				text: "Male Vs Female Vs Other Members",
				size: 12
			}],
			legend:{
				position:"bottom",
				autoMargins:true,
				equalWidths:true,
				markerType: "circle",
				horizontalGap:"20"
			},
			radius: "28%",			
			defs: {
				filter: [{
					id: "shadow",
					width: "200%",
					height: "200%",
					feOffset: {
					result: "offOut",
					"in": "SourceAlpha",
					dx: 0,
					dy: 0
				},
				feGaussianBlur: {
					result: "blurOut",
					"in": "offOut",
					stdDeviation: 5
				},
				feBlend: {
					"in": "SourceGraphic",
					"in2": "blurOut",
					"mode": "normal"
				}
				}]
			},			
			dataProvider: <?php echo $Chart_data1; ?>,
			valueField: "value1",
			titleField: "category",
			backgroundAlpha:"1",
			
			balloon: {
				adjustBorderColor: false,
				horizontalPadding: 10,
				verticalPadding: 8
			},
			
			balloonText: "<span style='font-size:12px;'>[[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",			
			depth3D: 10,
			angle: 30			
		});	
		
	var chart2 = AmCharts.makeChart("City_wise_member_sex_graph", 
	{
		"type": "serial",
		theme: theme,
		titles: [{
		text: "Distribution of Customer Profile Gender Wise",
		size: 12
		}],
		"legend": {
			"autoMargins": false,
			"borderAlpha": 0.2,
			"equalWidths": false,
			"horizontalGap": 10,
			"markerSize": 10,
			"useGraphSettings": true,
			"valueAlign": "left",
			"valueWidth": 0
		},
		"dataProvider": <?php echo $Chart_data2; ?>,
		"valueAxes": [{
			"stackType": "100%",
			"axisAlpha": 0,
			"gridAlpha": 0,
			"labelsEnabled": false,
			"position": "left"
		}],
		"graphs": [{
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Male Members",
			"type": "column",
			"valueField": "MaleMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Female Members",
			"type": "column",
			"valueField": "FemaleMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Not Mentioned Members",
			"type": "column",
			"valueField": "OtherMember"
		}],
		"marginTop": 30,
		"marginRight": 0,
		"marginLeft": 0,
		"marginBottom": 40,
		"autoMargins": false,
		"categoryField": "City",
		"categoryAxis": {
		"gridPosition": "start",
		"axisAlpha": 0,
		"gridAlpha": 0
		}
	});
	
	var chart3 = AmCharts.makeChart("Age_wise_member_graph", 
	{
		"type": "serial",
		theme: theme,
		titles: [{
		text: "Distribution of Customer Profile Age Wise",
		size: 12
		}],
		"legend": {
			"autoMargins": false,
			"borderAlpha": 0.2,
			"equalWidths": false,
			"horizontalGap": 10,
			"markerSize": 10,
			"useGraphSettings": true,
			"valueAlign": "left",
			"valueWidth": 0
		},
		"dataProvider": <?php echo $Chart_data3; ?>,
		"valueAxes": [{
			"stackType": "100%",
			"axisAlpha": 0,
			"gridAlpha": 0,
			"labelsEnabled": false,
			"position": "left"
		}],
		"graphs": [{
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Young Members(15-30 yrs)",
			"type": "column",
			"valueField": "YoungMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Middle Age Members(31-45 yrs)",
			"type": "column",
			"valueField": "MiddleAgeMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Senior Members(46-60 yrs)",
			"type": "column",
			"valueField": "SeniorMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Old Age Members(>60 yrs)",
			"type": "column",
			"valueField": "OldMember"
		}],
		"marginTop": 30,
		"marginRight": 0,
		"marginLeft": 0,
		"marginBottom": 40,
		"autoMargins": false,
		"categoryField": "City",
		"categoryAxis": {
		"gridPosition": "start",
		"axisAlpha": 0,
		"gridAlpha": 0
		}
	});
	
}

function exportCharts() 
{
	 // alert('Export');
	var images = [];
	var pending = AmCharts.charts.length;
	for ( var i = 0; i < AmCharts.charts.length; i++ ) 
	{
		var chart = AmCharts.charts[ i ];		
		chart.export.capture( {}, function() {
		this.toJPG( {}, function( data ) {
			images.push( {
				"image": data,
				"fit": [ 523.28, 769.89 ]
			} );
			pending--;
			if ( pending === 0 ) 
			{
				// all done - construct PDF
				chart.export.toPDF( {
					content: images
				}, function( data ) {
					this.download( data, "application/pdf", "<?php echo $Graph_name; ?>" );
				} );
			}
      } );
    } );
  }
}

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
	var counter = 0;	
	$('#Register').click(function()
	{	
		if( $('#Segment_Code').val() != "" && $('#SegmentType').val() != "" && $('#Segment_name').val() != "" && $('#Operatorid').val() != "")
		{			
			if( $('#Operatorid').val() == "Between")
			{			
				if( $('#Criteria_Value_1').val() != "" && $('#Criteria_Value_2').val() != "" )
				{				
					show_loader();					
				}
			}
			if($('#SegmentType').val() == 2 && $('#sex_Criteriavalue').val() != ""){
				show_loader();	
			}else if($('#Criteriavalue').val() != "" || $('#Country_Criteriavalue').val() != "" || $('#State_Criteriavalue').val() != "" || $('#City_Criteriavalue').val() != "")
			{			
				show_loader();	
			} 		
		}				
	}); 
	
	$('#addonemore').click(function()
	{
		if($('#Segment_Code').val() == "" || $('#Segment_name').val() == "" || $('#SegmentType').val() == "" )
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

	function Change_operator2(Segment_type,id)
	{
		 //alert(Segment_type);
		// alert(id);
		$('#Item_Category_'+id).hide();
		$('#Hobbies_'+id).hide();
		$('#Tier_Criteria_0_'+id).hide();
		$('#Outlet_Criteria_0_'+id).hide();
		$('#Brand_Criteria_0_'+id).hide();
		$('#Item_Category_id_'+id).hide();
		document.getElementById("Between_operator_"+id).style.display="none";
		
			$('#From_date'+id).hide();
			$('#Till_date'+id).hide();
			
			$( '#From_date'+id ).datepicker({
				changeMonth: true,
				yearRange: "-80:+2",
				changeYear: true
			});
			   
			$( '#Till_date'+id ).datepicker({
				changeMonth: true,
				yearRange: "-80:+2",
				changeYear: true
			});
			
		if(Segment_type==2 ){
			
			$('#Criteria_0_'+id).hide();
			document.getElementById("Single_operator_"+id).style.display="";
			document.getElementById("All_operator_"+id).style.display="none";
			
			
			 // $('#Criteria_0_'+id).attr("disabled","true");
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
			$('#Brand_Criteria_0_'+id).show();
			$('#Item_Category_id_'+id).show();
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
		else if(Segment_type==17 ){ //Tier
			
			
			document.getElementById("Single_operator_"+id).style.display="";
			document.getElementById("All_operator_"+id).style.display="none";
			
			$('#Item_Category_'+id).hide();
			$('#Hobbies_'+id).hide();
			 
			 $('#Criteria_0_'+id).hide();
			$('#Criteria_1_'+id).hide();
			$('#Criteria_2_'+id).hide();
			$('#Tier_Criteria_0_'+id).show();
			// ckeck_operator_popup_1('=',id);
		//	$('#Sex_Criteria_0_'+id).attr("disabled","false");
		}
		else if(Segment_type==16 ){ //Outlet
			
			
			document.getElementById("Single_operator_"+id).style.display="";
			document.getElementById("All_operator_"+id).style.display="none";
			
			$('#Item_Category_'+id).hide();
			$('#Hobbies_'+id).hide();
			 
			 $('#Criteria_0_'+id).hide();
			$('#Criteria_1_'+id).hide();
			$('#Criteria_2_'+id).hide();
			$('#Sex_Criteria_0_'+id).hide();
			$('#Outlet_Criteria_0_'+id).show();
			$('#Brand_Criteria_0_'+id).show();
			// ckeck_operator_popup_1('=',id);
		//	$('#Sex_Criteria_0_'+id).attr("disabled","false");
		}
		else if(Segment_type==15 ){ //Date Range
			
			
			document.getElementById("Single_operator_"+id).style.display="none";
			document.getElementById("All_operator_"+id).style.display="none";
			
			$('#Item_Category_'+id).hide();
			$('#Hobbies_'+id).hide();
			 
			 $('#Criteria_0_'+id).hide();
			$('#Criteria_1_'+id).hide();
			$('#Criteria_2_'+id).hide();
			$('#Sex_Criteria_0_'+id).hide();
			$('#Outlet_Criteria_0_'+id).hide();
			$('#Brand_Criteria_0_'+id).hide();
			$('#From_date'+id).show();
			$('#Till_date'+id).show();
			document.getElementById("Between_operator_"+id).style.display="";
			
	
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
	$('#Segment_Code').blur(function()
	{
		var CompanyId = '<?php echo $Company_id; ?>';
		var Segment_Code = $("#Segment_Code").val();
		
		if(Segment_Code == "")
		{
			$("#Segment_Code").val("");
			
			$('#SegmentCode').show();
			$('#SegmentCode').html(msg1);
		}
		else
		{
			$.ajax({
				type:"POST",
				data:{'SegmentCode':Segment_Code,'CompanyId':CompanyId},
				url: "<?php echo base_url()?>index.php/SegmentC/Segment_code_validation",
				success : function(data)
				{ 
					if(data == 1)
					{
						$("#Segment_Code").val("");
						
						$("#Segment_Code").addClass("form-control has-error");
							var msg1 = 'Already exist';
							$('#SegmentCode').show();
							$('#SegmentCode').html(msg1);
					}
					else
					{
						$('#SegmentCode').html("");
						$("#Segment_Code").removeClass("has-error");	
					}
				}
			});
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
	

	
	/* function ckeck_operator_popup(inPutVal)
	{
		if(inPutVal=='Between')
		{
			$("#Criteria_pop_1").hide();
			$("#Criteria_pop_2").show();
			$("#Criteria_pop_3").show();
		}
		else
		{
			$("#Criteria_pop_1").show();
			$("#Criteria_pop_2").hide();
			$("#Criteria_pop_3").hide();
		}	 
	} */
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
 
 /******** add row ********/
     
jQuery(function(){
	
	var counter = 0;
	
    jQuery('#addrows').click(function(event)
	{
        event.preventDefault();
      
        var newRow = jQuery(
		'<tr id="Row_'+counter+'"><td class="extra_width"><select class="form-control extra_width" name="SegmentType_'+counter+'" id="SegmentType_1_'+counter+'"   onchange="Change_operator2(this.value,'+counter+');"><option value="">Select Type</option><?php foreach($Segment_type as $seg) { if($seg['Segment_type_id'] != 4 ){ ?><option value="<?php echo $seg['Segment_type_id']; ?>"><?php echo $seg['Segment_type_name']; ?></option><?php } } ?></select></td><td  style="display:none;"  class="extra_width" id="Item_Category_'+counter+'"></td><td  style="display:none;"  class="extra_width" id="Hobbies_'+counter+'"><select class="form-control extra_width select2" multiple="true" name="Hobbies_'+counter+'[]" ><?php foreach($Hobbies_list as $hob) {  ?><option value="<?php echo $hob->Id; ?>"><?php echo $hob->Hobbies; ?></option><?php  }  ?></select></td><td style="display:none;"  class="extra_width" id="Single_operator_'+counter+'"><select class="form-control extra_width" name="Operatorid3_'+counter+'" id="Operatorid3'+counter+'" onchange="ckeck_operator_popup_1(this.value,'+counter+')"  ><option value="="> = </option></select></td><td style="display:none;"  class="extra_width" id="Between_operator_'+counter+'"><select class="form-control extra_width" name="Operatorid3_'+counter+'" id="Operatorid3'+counter+'"   ><option value="Between"> Between </option></select></td> <td id="All_operator_'+counter+'"  class="extra_width"><select class="form-control extra_width" name="Operatorid1_'+counter+'" id="Operatorid1'+counter+'" onchange="ckeck_operator_popup_1(this.value,'+counter+')"  ><option value=""> Select Operator </option><option value="="> = </option><option value=">"> > </option><option value=">="> >= </option><option value="<"> < </option><option value="<="> <= </option><option value="!="> != </option><option value="Between"> Between </option></select></td> <td id="table_col"  class="extra_width"><input  class="form-control extra_width"  value="" name="Operator_Criteria_'+counter+'"  id="Criteria_0_'+counter+'" onKeyPress="Autocomplete(this.value,'+counter+');" style="display:none"/> <select class="form-control extra_width" name="Operator_CriteriaSex_'+counter+'"  id="Sex_Criteria_0_'+counter+'" data-error="Please select Gender" style="display:none"><option value=""> Select Gender </option><option value="Male"> Male </option><option value="Female"> Female </option></select> <select class="form-control extra_width" name="Operator_CriteriaTier_'+counter+'"  id="Tier_Criteria_0_'+counter+'"  style="display:none"><?php foreach($Tier_list as $Tier) {  ?><option value="<?php echo $Tier->Tier_id; ?>"><?php echo $Tier->Tier_name; ?></option><?php  }  ?></select> <select class="form-control extra_width" name="Operator_CriteriaBrand_'+counter+'"  id="Brand_Criteria_0_'+counter+'" style="display:none" onchange="get_outlets(this.value,'+counter+');"><option value="">Select Brand</option><?php if($Logged_user_id > 2 || $Super_seller == 1){ ?><option value="<?php echo $enroll;?>"><?php echo $LogginUserName;?></option><?php } foreach($Seller_array as $seller_val){ ?><option value="<?php echo $seller_val->Enrollement_id;?>"><?php echo $seller_val->First_name." ".$seller_val->Last_name;?></option><?php } ?></select> <input class="single-daterange form-control datepick" placeholder="From Date" style="display:none" type="text"  name="start_date'+counter+'" id="From_date'+counter+'"  >  </td><td  class="extra_width"><input type="text"  class="form-control extra_width"  value="" name="Operator_Criteria1_'+counter+'"  id="Criteria_1_'+counter+'"/> <select class="form-control extra_width" name="Operator_CriteriaOutlet_'+counter+'"  id="Outlet_Criteria_0_'+counter+'" style="display:none"><option value="">Select Brand First</option></select>  <input class="single-daterange form-control datepick" placeholder="Till Date" style="display:none" type="text"  name="end_date'+counter+'" id="Till_date'+counter+'" /> <select class="form-control extra_width" style="display:none" name="Item_Category_id_'+counter+'" id="Item_Category_id_'+counter+'"   onchange="Get_items(this.value);"><option value="">Select Category</option><?php if($Merchandize_Category_Records !=NULL){ foreach($Merchandize_Category_Records as $Merchandize_Category) {  if($Merchandize_Category->Parent_category_id !=0 ) { $childs=$this->Catelogue_model->Get_Merchandize_Parent_Category_details($Merchandize_Category->Merchandize_category_id); ?><?php foreach($childs as $row) {?><option value="<?php echo $row->Merchandize_category_id; ?>"><?php echo $row->Merchandize_category_name; ?></option><?php } } } }?></select></td><td  class="extra_width"><input type="text"  class="form-control extra_width" value="" name="Operator_Criteria2_'+counter+'" placeholder=""  id="Criteria_2_'+counter+ '"/> </td><td class="extra_width"><a id="Rmv_'+counter+'" class="danger" href="javascript:RemoveRow('+counter+');"><i class="os-icon os-icon-ui-15 "></i></a></td></tr>'
			);
			
							
							
        jQuery('#options-table').append(newRow);
		counter++;
    });
});

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

.extra_width
{
	width: 124px !IMPORTANT;
}

.ui-datepicker { position: relative; z-index: 10000 !important; }
</style>
<!-- ************************************AM Graph************************************* -->
<script src="<?php echo base_url()?>amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>amcharts/plugins/dataloader/dataloader.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/light.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/dark.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/chalk.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/black.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/patterns.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/plugins/export/export.js"></script>
<script src="<?php echo base_url()?>amcharts/pie.js" type="text/javascript"></script>
<!-- ************************************AM Graph************************************* -->