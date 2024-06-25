	
							
								<legend><span  id="title2">Select Items</span></legend>
							
							
							<div class="row">
							
								
								<div class="col-md-2">
								
									<b>Item Code.</b>
									
								</div>	
								<div class="col-md-5">
								
									<b>Item Name</b>
									
								</div>	
								<div class="col-md-5">
								
									<b>Discount Percentage Or Value</b>
									
								</div>	
									
								<?php	
									if(count($Get_Linked_Items_for_discount)>10)
									{
										$style="style='height: 400px;overflow: auto;'";
									}
									else
									{
										$style="style='overflow: auto;'";
									}
									?>
							</div>	
							<br>	<br>
							<div class="row" <?php echo $style;?>>	
							
							<?php	
							//print_r($Get_Linked_Items_for_discount);
							$Count_items= count($Get_Linked_Items_for_discount);
							$ci_object = &get_instance();
							$ci_object->load->model('administration/Administration_model');
							if($Get_Linked_Items_for_discount!=NULL){
								$i=0;
							foreach($Get_Linked_Items_for_discount as $Items_by_category)
							{
								$Merchandize_category_id= $Items_by_category->Merchandize_category_id;
								
								$Merchandize_category_name= $Items_by_category->Merchandize_category_name;
								
								$Get_checked_groups_items = $ci_object->Administration_model->Get_checked_items_discount($Company_id,$Discount_code,$Items_by_category->Company_merchandize_item_code);
								
								$Check_code =0;
								$Discount_percentage_or_value =1;
								$Price =0.00;
								if($Get_checked_groups_items != NULL)
								{
									$Check_code =1;
									$Discount_percentage_or_value=$Get_checked_groups_items->Discount_percentage_or_value;
									
								}
							?>
							
							
							<div class="col-md-2">
							<label>
								<input type="checkbox" name="Item_check[]" id="Item_check_<?php echo $i; ?>"  value="<?php echo $Items_by_category->Company_merchandize_item_code; ?>" onclick="toggle_items(<?php echo $i; ?>);" <?php if($Check_code==1){echo 'checked';} ?> class="check">
								<?php echo $Items_by_category->Company_merchandize_item_code; ?>
								</label>
							</div>	
							<div class="col-md-5">
							
								
									<?php echo $Items_by_category->Merchandize_item_name; ?>
								<input type="hidden" id="Merchandize_item_name_<?php echo $i; ?>" name="Merchandize_item_name[]" value="<?php echo $Items_by_category->Merchandize_item_name; ?>" >
								<input type="hidden" id="Merchandize_category_name_<?php echo $i; ?>" name="Merchandize_category_name[]" value="<?php echo $Items_by_category->Merchandize_category_name; ?>" >
							</div>	
							<div class="col-md-5">
								<div class="form-group has-feedback">
								<input type="text" name="Discount_percentage_or_value" id="Discount_percentage_or_value_<?php echo $i; ?>" class="form-control qty"  onkeypress="return isNumberKey2(event);"  <?php if($Check_code==0){echo 'disabled';} ?> value="<?php echo $Discount_percentage_or_value; ?>" onkeypress="return isNumberKey2(event)"  />
								
								</div>	
							</div>	
							
							<?php $i++;}}else{ 
								$Merchandize_category_name= '';
								$Merchandize_category_id=0;
								$Merchandize_category_name='-';
								$Company_merchandize_item_code=0;
								
							echo 'Items Not Found !!!';} ?>	
							
							</div>	
							
						<div class="modal-footer">
								<span  id="error" style="color:red;"></span>
								<button type="button" id="select_id" class="btn btn-primary" onclick='select_all();' >Select All</button>
								<button type="submit" id="close_modal" class="btn btn-primary" onclick="Save_items_for_discount_rule();" >Save</button>
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
	}

	function toggle_items(id)//  
	{
		if(document.getElementById('Item_check_'+id).checked==true)
		{
			$("#Discount_percentage_or_value_"+id).removeAttr("disabled"); 
			
		}
		else
		{
			$("#Discount_percentage_or_value_"+id).attr("disabled", "disabled"); 
			
		}
		
	}
	function Save_items_for_discount_rule()
	{
		
		var Count_items = '<?php echo $Count_items; ?>';
		var Merchandize_category_id = '<?php echo $Merchandize_category_id; ?>';
		var Discount_code = '<?php echo $Discount_code; ?>';
		var Company_id = '<?php echo $Company_id; ?>';
		/* var Item_code = new Array();
		var Merchandize_item_name = new Array();
		var Discount_percentage_or_value = new Array(); */
		
		var Discount_rule_set = $("input[name=Discount_rule_set]:checked").val();
		
		if(Discount_code== "")
		{
			var Title = "Application Information";
			var msg = 'Please Enter Item Code first';
			// runjs(Title,msg);
			// alert('Please Enter Discount Code first');
			$('#error').html('Please Enter Discount Code first');
			return false;
		}
		
		var error_count = 0;		
		for(var i=0; i<Count_items; i++ )
		{
			 if(document.getElementById('Item_check_'+i).checked==true)
			{
				var Item_check = $('#Item_check_'+i).val();
				var Merchandize_item_name2 = $('#Merchandize_item_name_'+i).val();
				var Discount_percentage_or_val = $('#Discount_percentage_or_value_'+i).val();
				var Merchandize_category_name2 = $('#Merchandize_category_name_'+i).val();
				
				Item_code.push(Item_check);
				Merchandize_item_name.push(Merchandize_item_name2);
				Discount_percentage_or_value.push(Discount_percentage_or_val);
				Merchandize_category_name.push(Merchandize_category_name2);
				
				// alert(Item_check);
				if(Discount_percentage_or_val== "" || Discount_percentage_or_val ==0)
				{
					var Title = "Application Information";
					var msg = 'Please Enter Discount Percentage Or Value of Item Code '+Item_check;
					$('#error').html(msg);
					return false;
				}
				if(Discount_rule_set==1)//Percentage
				{
					if(Discount_percentage_or_val > 100)
					{
						var msg = 'Please Enter Percentage(%) between 1 to 100 of Item Code '+Item_check;
						$('#error').html(msg);
						return false;
					}
				}
				error_count = 1;	
			} 
			
		}
		
		if(error_count==0)
		{
			var Title = "Application Information";
			var msg = 'Please Select atleast One !!!';
			// runjs(Title,msg);
			// alert(msg);
			$('#error').html(msg);
			return false;
		} 
		
					
			$.ajax({
			  type: "POST",
			  data: {Item_code: Item_code,Merchandize_category_id: Merchandize_category_id,Discount_code: Discount_code,Company_id:Company_id,Discount_percentage_or_value:Discount_percentage_or_value,Merchandize_item_name:Merchandize_item_name,Merchandize_category_name:Merchandize_category_name,},
			  url: "<?php echo base_url()?>index.php/Administration/Save_items_for_discount_rule",
			  success: function(data)
				{
				    // alert(data.Item_code);
					$("#linked_itemcode").val(data.linked_itemcode);
					$("#linked_Discount_percentage_or_value").val(data.linked_Discount_percentage_or_value);
					$("#linked_Category_id").val(data.linked_Category_id);
				   var Title = "Application Information";
					var msg = 'Main Items Saved Successfully !!!';
					$('#error').html(msg);
					$('#myModal1').hide();
					$("#myModal1").removeClass( "in" );
					$('.modal-backdrop').remove();
					// alert(msg);
					$("#selected_items").show();
					$('#Linked_items').html(data.Linked_items);
					
					$("#help-block22").html("");
					$("#Register").prop("type", "submit");
				}
			});  
				
		
	}
	function isNumberKey2(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode

  if (charCode != 46 && charCode > 31
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}
</script>	