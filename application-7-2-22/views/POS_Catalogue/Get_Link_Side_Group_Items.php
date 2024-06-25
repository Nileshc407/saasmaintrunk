	
							
								<legend><span  id="title2">Side Group Items</span></legend>
							
							
							<div class="row">
							
								<div class="col-md-1"><b>Active</b></div>	
								<div class="col-md-2">
								
									<b>Item No.</b>
									
								</div>	
								<div class="col-md-3">
								
									<b>Item Name</b>
									
								</div>	
								<div class="col-md-3">
								
									<b>Quantity</b>
								</div>	
								<div class="col-md-3">
								
									<b>Price</b>
								</div>		
							
							</div>	
							<br>	<br>
							<?php 	
					
							$height = '';
							if(count($Get_Link_Side_Group_Items) >= 10)
							{
								$height = 'style="overflow-y: scroll;height:300px;"';
							}
						?>
							<div class="row"   <?php echo $height; ?>>	
							
							<?php	
							//print_r($Get_Link_Side_Group_Items);
							$Count_items= count($Get_Link_Side_Group_Items);
							$ci_object = &get_instance();
							$ci_object->load->model('POS_catlogueM/POS_catalogue_model');
							if($Get_Link_Side_Group_Items!=NULL){
								$i=0;
							foreach($Get_Link_Side_Group_Items as $Side_Group_Items)
							{
								$Merchandize_category_id= $Side_Group_Items->Merchandize_category_id;
								
								$Merchandize_category_name= $Side_Group_Items->Merchandize_category_name;
								
								
								if($Side_option==0)//Main Item
								{
									$Get_checked_groups_items = $ci_object->POS_catalogue_model->Get_checked_pos_main_groups_items($Company_id,$Company_merchandize_item_code,$Side_Group_Items->Company_merchandize_item_code);
								}
								else
								{
									$Get_checked_groups_items = $ci_object->POS_catalogue_model->Get_checked_pos_side_groups_items($Company_id,$Company_merchandize_item_code,$Side_option,$Side_Group_Items->Company_merchandize_item_code);
								}
								$Check_code =0;
								$Quanity =1;
								$Price =0.00;
								if($Get_checked_groups_items != NULL)
								{
									$Check_code =1;
									$Quanity=$Get_checked_groups_items->Quanity;
									$Price=$Get_checked_groups_items->Price;
								}
							?>
							<div class="col-md-1">
											
								<input type="checkbox" name="Side_item_check[]" id="side_item_<?php echo $i; ?>"  value="<?php echo $Side_Group_Items->Company_merchandize_item_code; ?>" onclick="toggle_side_groups_items(<?php echo $i; ?>);" <?php if($Check_code==1){echo 'checked';} ?> class="check">
									
							</div>	
							<div class="col-md-2">
							
								<?php echo $Side_Group_Items->Company_merchandize_item_code; ?>
								
							</div>	
							<div class="col-md-3">
							
								
									<?php echo $Side_Group_Items->Merchandize_item_name; ?>
								
							</div>	
							<div class="col-md-3">
							
								<div class="form-group has-feedback">
									
									<input type="text" name="Side_Quantity" id="Side_Quantity_<?php echo $i; ?>" class="form-control qty" placeholder="Enter Quantity" onkeypress="return isNumberKey2(event);"  <?php if($Check_code==0){echo 'disabled';} ?> value="<?php echo $Quanity; ?>" />
								</div>
							</div>	
							<div class="col-md-3">
							
								<div class="form-group has-feedback">
									<input type="text" name="Side_Price" id="Side_Price_<?php echo $i; ?>" class="form-control price" placeholder="Enter Price" onkeypress="return isNumberKey2(event);" <?php if($Check_code==0){echo 'disabled';} ?> value="<?php echo $Price; ?>"/>
								</div>
							</div>	
							<?php $i++;}}else{ 
								$Merchandize_category_name= 0;
								$Merchandize_category_id=0;
								$Company_merchandize_item_code=0;
								$Side_option=0;
							echo 'Items Not Found !!!';} ?>	
							
							</div>	
							
						<div class="modal-footer">
						<span  id="error" style="color:red;"></span>
								<button type="button" id="select_id" class="btn btn-primary" onclick='select_all();' >Select All</button>
								<button type="submit" id="close_modal" class="btn btn-primary" onclick="Save_side_group_items();" >Save</button>
								<button type="button" id="close_modal12" class="btn btn-primary">Close</button>
						</div>
						
<script>
	$( "#close_modal12" ).click(function(e)
	{
		
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
$('#title2').html('<?php echo "<b>".$Merchandize_category_name." Group Items</b>";?>');
	function select_all()//  
	{
		$(".check").prop("checked", true);
		
			$(".qty").removeAttr("disabled"); 
			$(".price").removeAttr("disabled"); 
			
	}
	function toggle_side_groups_items(id)//  
	{
		if(document.getElementById('side_item_'+id).checked==true)
		{
			$("#Side_Quantity_"+id).removeAttr("disabled"); 
			$("#Side_Price_"+id).removeAttr("disabled"); 
			
		}
		else
		{
			$("#Side_Quantity_"+id).attr("disabled", "disabled"); 
			$("#Side_Price_"+id).attr("disabled", "disabled"); 
		}
		
	}

	function Save_side_group_items()
	{
		
		var Count_items = '<?php echo $Count_items; ?>';
		var Merchandize_category_id = '<?php echo $Merchandize_category_id; ?>';
		var Company_merchandize_item_code = '<?php echo $Company_merchandize_item_code; ?>';
		var Side_option = '<?php echo $Side_option; ?>';
		var Sub_item_code = new Array();
		var Side_Quantity = new Array();
		var Side_Price = new Array();
		
		if(Company_merchandize_item_code== "")
		{
			var Title = "Application Information";
			var msg = 'Please Enter Item Code first';
			$('#error').html(msg);
			return false;
		}
		
		var error_count = 0;		
		for(var i=0; i<Count_items; i++ )
		{
			 if(document.getElementById('side_item_'+i).checked==true)
			{
				var side_item = $('#side_item_'+i).val();
				var Side_Quantity_val = $('#Side_Quantity_'+i).val();
				var Side_Price_val = $('#Side_Price_'+i).val();
				
				Sub_item_code.push(side_item);
				Side_Quantity.push(Side_Quantity_val);
				Side_Price.push(Side_Price_val);
				
				if(Side_Quantity_val== "" || Side_Quantity_val ==0)
				{
					var Title = "Application Information";
					var msg = 'Please Enter Quantity of Item No. '+side_item;
					// runjs(Title,msg);
					$('#error').html(msg);
					return false;
				}
				if(Side_Price_val== "")
				{
					var Title = "Application Information";
					var msg = 'Please Enter Price of Item No. '+side_item;
					// runjs(Title,msg);
					$('#error').html(msg);
					return false;
				}
				error_count = 1;	
			} 
			/* else
			{
				var error_count = i+1;
				
			} */
		}
		
		if(error_count==0)
		{
			var Title = "Application Information";
			var msg = 'Please Select atleast One !!!';
			// runjs(Title,msg);
			$('#error').html(msg);
			return false;
		} 
		
					if(Side_option==0)//Main Item
				{
					var Main_Side_label = '<?php echo $Main_Side_label; ?>';
					$.ajax({
					  type: "POST",
					  data: {Sub_item_code: Sub_item_code,Side_Quantity: Side_Quantity,Side_Price: Side_Price,Merchandize_category_id: Merchandize_category_id,Company_merchandize_item_code: Company_merchandize_item_code,Side_option: Side_option,Main_Side_label: Main_Side_label,},
					  url: "<?php echo base_url()?>index.php/POS_CatalogueC/Save_Main_items",
					  success: function(data)
						{
						   $('#Saved_Main_item_block').html(data.Linked_Main_items);
						   var Title = "Application Information";
							var msg = 'Main Items Saved Successfully !!!';
							
							$('#myModal1').hide();
							$("#myModal1").removeClass( "in" );
							$('.modal-backdrop').remove();
							// alert(msg);
						}
					});  
				}
				else //Side Item
				{
					$.ajax({
					  type: "POST",
					  data: {Sub_item_code: Sub_item_code,Side_Quantity: Side_Quantity,Side_Price: Side_Price,Merchandize_category_id: Merchandize_category_id,Company_merchandize_item_code: Company_merchandize_item_code,Side_option: Side_option,},
					  url: "<?php echo base_url()?>index.php/POS_CatalogueC/Save_side_group_items",
					  success: function(data)
						{
						   $('#Side_group_item_block').html(data.Linked_side_group_items);
						   var Title = "Application Information";
							var msg = 'Side Group Items Saved Successfully !!!';
							
							$('#myModal1').hide();
							$("#myModal1").removeClass( "in" );
							$('.modal-backdrop').remove();
							
							$('#error').html(msg);
						}
					});  
				}
		
	}
	/*/$( "#close_modal" ).click(function(e)
	{
		var Title = "Application Information";
		var msg = 'Side Group Items  Saved Successfully !!!';
		
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
		runjs(Title,msg);
		
	});*/
	
</script>	